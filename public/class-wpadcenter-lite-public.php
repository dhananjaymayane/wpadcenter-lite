<?php

/**
 * The public-facing functionality of the plugin.
 *
 * @link       http://example.com
 * @since      1.0.0
 *
 * @package    Plugin_Name
 * @subpackage Plugin_Name/public
 */

/**
 * The public-facing functionality of the plugin.
 *
 * Defines the plugin name, version, and two examples hooks for how to
 * enqueue the admin-specific stylesheet and JavaScript.
 *
 * @package    Plugin_Name
 * @subpackage Plugin_Name/public
 * @author     Your Name <email@example.com>
 */
class WPAdcenter_Lite_Public {

	/**
	 * The ID of this plugin.
	 *
	 * @since    1.0.0
	 * @access   private
	 * @var      string    $plugin_name    The ID of this plugin.
	 */
	private $wpadcenter_lite;

	/**
	 * The version of this plugin.
	 *
	 * @since    1.0.0
	 * @access   private
	 * @var      string    $version    The current version of this plugin.
	 */
	private $version;

	/**
	 * Initialize the class and set its properties.
	 *
	 * @since    1.0.0
	 * @param      string    $plugin_name       The name of the plugin.
	 * @param      string    $version    The version of this plugin.
	 */
	public function __construct( $plugin_name, $version ) {

		$this->plugin_name = $plugin_name;
		$this->version = $version;
                add_shortcode('displayAdzone', 'wpadl_displayAdzoneFunction');

	}

	/**
	 * Register the stylesheets for the public-facing side of the site.
	 *
	 * @since    1.0.0
	 */
	public function enqueue_styles() {

		/**
		 * This function is provided for demonstration purposes only.
		 *
		 * An instance of this class should be passed to the run() function
		 * defined in Plugin_Name_Loader as all of the hooks are defined
		 * in that particular class.
		 *
		 * The Plugin_Name_Loader will then create the relationship
		 * between the defined hooks and the functions defined in this
		 * class.
		 */

		wp_enqueue_style( $this->plugin_name, plugin_dir_url( __FILE__ ) . 'css/plugin-name-public.css', array(), $this->version, 'all' );

	}

	/**
	 * Register the JavaScript for the public-facing side of the site.
	 *
	 * @since    1.0.0
	 */
	public function enqueue_scripts() {

		/**
		 * This function is provided for demonstration purposes only.
		 *
		 * An instance of this class should be passed to the run() function
		 * defined in Plugin_Name_Loader as all of the hooks are defined
		 * in that particular class.
		 *
		 * The Plugin_Name_Loader will then create the relationship
		 * between the defined hooks and the functions defined in this
		 * class.
		 */

		wp_enqueue_script( $this->plugin_name, plugin_dir_url( __FILE__ ) . 'js/plugin-name-public.js', array( 'jquery' ), $this->version, false );

	}
        function wpadl_displayAdzone($id)
        {	
            global $wpdb, $current_user;

            $res = wpadl_totalZones( "WHERE id = '".$id."' LIMIT 1" );	

            $ads = $wpdb->get_results("SELECT ban.*, ad_ban.adzone_id, camp.status FROM " . $wpdb->prefix . "banner ban,  " . $wpdb->prefix . "adv_banner ad_ban," . $wpdb->prefix . "campaign camp WHERE  
                            ad_ban.banner_id = ban.id AND   ad_ban.adzone_id = '".$id."' AND   camp.advertiser_id = ban.advertiser_id AND  camp.id = ad_ban.campaign_id AND   camp.status = 1   ORDER BY RAND()");


            $size = explode( 'x', $res[0]->size );

            /*
            *	Code Commented - Was increasing Impression count on plugin load
            */

            /*foreach ($ads as $ad) {
              Impression( $ad );
            }*/

            $con = wpadl_displaySingle($id,$res,$ads,$size);

            return $con;

        }

        function wpadl_displayAdzoneFunction($atribute,$content=null) //Function For The Creation Of Short Code
        {
            extract( shortcode_atts( array('id' => 1), $atribute ) ); return $this->wpadl_displayAdzone( esc_attr($id) );
        }
        
        // This function loads JQuery in our theme
        function wpadl_loadJqueryForTheme() {

            global $pluginUrl;
                wp_register_script( 'validjs', WP_ADCENTER_ADMIN_URL.'js/valid.js', $deps = array(), $ver = '1.5.0', $media = 'all');
                wp_register_script( 'validatejs', WP_ADCENTER_ADMIN_URL.'js/jquery.validate.js', $deps = array(), $ver = '1.5.0', $media = 'all');
                wp_register_script('sliderjs',WP_ADCENTER_ADMIN_URL.'js/slider.js',array( 'jquery' ), $ver = '1.5.0');

                wp_enqueue_script( 'sliderjs');
                wp_enqueue_script( 'validatejs');
                wp_enqueue_script( 'validjs');
                wpadl_checkFinished();
                wpadl_impressionEndDate();

        }    
        
        function wpadl_force_deactivation(){

                if(defined('WP_ADCENTER_PLUGIN_DIR')){

                        // if plugin is found active then display errors message
                        add_action('admin_notices' , 'wpadl_forced_deactivation_notice');
                }
                else{
                        // else include the files
                        require_once(WP_ADCENTER_LITE_PLUGIN_DIR.'includes/wpadcenter-lite-functions.php');
                        require_once(WP_ADCENTER_PUBLIC_DIR.'partials/wpadcenter-lite-adzone_display.php');
                        add_action('init', array( $this, 'wpadl_loadJqueryForTheme' ) );
                }
        }
        function wpadl_forced_deactivation_notice()
        {
            deactivate_plugins( plugin_basename( __FILE__ ) );
            echo '<script>
                            jQuery(function(){
                                    jQuery("#message").hide();
                            });
                    </script>
            <div class="error">
                    <p>You have already activated WP-Adcenter PRO Version. You cannot activate Lite Version.</p>
            </div>';
    }
    function wpadl_clickOnBanner()
    {	
            if ( isset($_GET['move_to']) ){ require_once(WP_ADCENTER_ADMIN_DIR.'partials/wpadcenter-lite-admin-redirect.php');}
    }

}
