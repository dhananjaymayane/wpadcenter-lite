<?php

/**
 * The admin-specific functionality of the plugin.
 *
 * @link       http://example.com
 * @since      1.0.0
 *
 * @package    Plugin_Name
 * @subpackage Plugin_Name/admin
 */

/**
 * The admin-specific functionality of the plugin.
 *
 * Defines the plugin name, version, and two examples hooks for how to
 * enqueue the admin-specific stylesheet and JavaScript.
 *
 * @package    Plugin_Name
 * @subpackage Plugin_Name/admin
 * @author     Your Name <email@example.com>
 */
class WPAdcenter_Lite_Admin {

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
	 * @param      string    $plugin_name       The name of this plugin.
	 * @param      string    $version    The version of this plugin.
	 */
	public function __construct( $plugin_name, $version ) {

		$this->plugin_name = $plugin_name;
		$this->version = $version;
	}

	/**
	 * Register the stylesheets for the admin area.
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
		wp_enqueue_style('admin', WP_ADCENTER_ADMIN_URL.'css/wpadcenter-lite-admin.css', '', '', $media = 'all');
		wp_enqueue_style('tooltip', WP_ADCENTER_ADMIN_URL.'css/tooltips.css', '', '', $media = 'all');
		wp_enqueue_style( 'datepicker-css', WP_ADCENTER_ADMIN_URL.'/css/ui-lightness/datepicker.css' );


		wp_enqueue_style( $this->plugin_name, plugin_dir_url( __FILE__ ) . 'css/plugin-name-admin.css', array(), $this->version, 'all' );

	}

	/**
	 * Register the JavaScript for the admin area.
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
		wp_enqueue_script('jquery-ui-datepicker');
		wp_enqueue_script('jquery.validate.js', WP_ADCENTER_ADMIN_URL . 'js/jquery.validate.js', array('jquery'), '', true );
		wp_enqueue_script('valid.js', WP_ADCENTER_ADMIN_URL . 'js/valid.js', array('jquery'), '', true );
		wp_enqueue_script('jquery.tipTip.minified.js', WP_ADCENTER_ADMIN_URL . 'js/jquery.tipTip.minified.js', array('jquery'), '', true);
		wp_enqueue_script('date.js', WP_ADCENTER_ADMIN_URL . 'js/date.js', array('jquery'), '', true );

		/*  Enqueue Chartjs */
		wp_register_script('chartjs', WP_ADCENTER_ADMIN_URL . 'js/Chart.min.js', array('jquery'), '', true );
		wp_enqueue_script( $this->plugin_name, plugin_dir_url( __FILE__ ) . 'js/plugin-name-admin.js', array( 'jquery' ), $this->version, false );

	}

	/* Adds required menus on admin side */

	public function admin_menu(){
			
		include_once( WP_ADCENTER_ADMIN_DIR.'partials/wpadcenter-lite-admin-menu.php' );
		$admin_menu = new WPAdcenter_Admin_Menu();
		add_menu_page("WP Ad Center", "WP Ad Center", "administrator", "setting" , array( $admin_menu, "wpadl_setting" ), WP_ADCENTER_ADMIN_URL.'images/wp-icon.png' );
		add_submenu_page("setting", "Settings", "Settings", "administrator", "setting", array( $admin_menu, "wpadl_setting" ) );
		add_submenu_page("setting", "AdZones", "Ad Zones", "administrator", "adzones", array( $admin_menu, "wpadl_adzones" ) );
		add_submenu_page("setting", "Packages", "Packages", "administrator", "packages", array( $admin_menu, "wpadl_package" ) );
		add_submenu_page("setting", "Campaigns", "Campaigns", "administrator", "campaigns", array( $admin_menu, "wpadl_campaign" ) );
		add_submenu_page("setting", "Banners", "Banners", "administrator", "banners", array( $admin_menu, "wpadl_banner" ) );
		add_submenu_page("setting", "Advertisers", "Advertisers", "administrator", "advertisement", array( $admin_menu, "wpadl_advertiser" ) );
		add_submenu_page("setting", "Advertiser Status", "Advertiser Status", "administrator", "status", array( $admin_menu, "wpadl_status" ) );
		add_submenu_page("setting", "Statistics", "Statistics", "administrator", "statistics", array( $admin_menu, "wpadl_statistics" ) );
		add_submenu_page("setting", "Statistics", "Statistics", "subscriber", "stats", array( $admin_menu, "wpadl_statistics" ) );

		$user_ID = get_current_user_id();
		$value=get_user_meta($user_ID,"wpadcenter_notification",true);
		if($value=="0"){
			add_submenu_page("setting", "Enable Email Notification", "Enable Email Notification", "subscriber", "notification_status", array( $admin_menu, "wpadl_email_notification" ) );
		}
		if($value=="1"){
			add_submenu_page("setting", "Disable Email Notification", "Disable Email Notification", "subscriber", "notification_status", array( $admin_menu, "wpadl_email_notification" ) );
		}
	}

}
