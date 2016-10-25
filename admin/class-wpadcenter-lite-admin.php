<?php

/**
 * The admin-specific functionality of the plugin.
 *
 * Defines the plugin name, version, and two examples hooks for how to
 * enqueue the admin-specific stylesheet and JavaScript.
 *
 * @package    WPAdcenter_Lite
 * @subpackage WPAdcenter_Lite/admin
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
		add_action( 'wpadcenter_daily_event_hook', array( $this, 'wpadcenter_do_this_daily_lite' ) );
	}

	/**
	 * Register the stylesheets for the admin area.
	 *
	 * @since    1.0.0
	 */
	public function enqueue_styles( $hook ) {

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
		$page = isset( $_GET['page'])?$_GET['page']:'';
		if( $hook != 'toplevel_page_'.$page && $hook != 'wp-ad-center_page_'.$page){
			return;
		}
		wp_enqueue_style($this->plugin_name.'_admin', WP_ADCENTER_ADMIN_URL.'css/wpadcenter-lite-admin.css', '', '', $media = 'all');
		wp_enqueue_style($this->plugin_name.'_tooltip', WP_ADCENTER_ADMIN_URL.'css/tooltips.css', '', '', $media = 'all');
		wp_enqueue_style( $this->plugin_name.'_datepicker-css', WP_ADCENTER_ADMIN_URL.'/css/ui-lightness/datepicker.css' );
	}

	/**
	 * Register the JavaScript for the admin area.
	 *
	 * @since    1.0.0
	 */
	public function enqueue_scripts( $hook ) {

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
		$page = isset( $_GET['page'])?$_GET['page']:'';
		if( $hook != 'toplevel_page_'.$page && $hook != 'wp-ad-center_page_'.$page){
			return;
		}
		wp_enqueue_script('jquery-ui-datepicker');
		wp_enqueue_script($this->plugin_name.'_jquery_validate_js', WP_ADCENTER_ADMIN_URL . 'js/jquery.validate.js', array('jquery'), '', true );
		wp_enqueue_script($this->plugin_name.'_valid_js', WP_ADCENTER_ADMIN_URL . 'js/valid.js', array('jquery'), '', true );
		wp_enqueue_script($this->plugin_name.'_jquery_tipTip_minified_js', WP_ADCENTER_ADMIN_URL . 'js/jquery.tipTip.minified.js', array('jquery'), '', true);
		wp_enqueue_script($this->plugin_name.'_date_js', WP_ADCENTER_ADMIN_URL . 'js/date.js', array('jquery'), '', true );

		/*  Enqueue Chartjs */
		wp_enqueue_script($this->plugin_name.'_chartjs', WP_ADCENTER_ADMIN_URL . 'js/Chart.min.js', array('jquery'), '', true );

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

	public function wpadl_show_campaign_name(){
		?>
<script type="text/javascript">
var imgURL = "<?php echo plugins_url('images/',__FILE__);?>";

	function wpadl_showCampaign(id)
	{	
	document.getElementById('imgloader').innerHTML="<img src="+imgURL+"/wpt-loading-icon.gif>loading...";

		if (window.XMLHttpRequest)
		{// code for IE7+, Firefox, Chrome, Opera, Safari
			xmlhttp=new XMLHttpRequest();
		}
		else
		{// code for IE6, IE5
			xmlhttp=new ActiveXObject("Microsoft.XMLHTTP");
		}
		xmlhttp.onreadystatechange=function()
		{	document.getElementById('imgloader').innerHTML="";
			if (xmlhttp.readyState==4 && xmlhttp.status==200)
			{
				document.getElementById("CampaignDiv").innerHTML=xmlhttp.responseText;
			}
		}

		var url="<?php echo admin_url('admin-ajax.php');?>";

		var data= "action=wpadl_get_campaigns&id="+id;
		jQuery.ajax({
			url : url,
			data:data,
			success:function(res){
				jQuery('#campaignsListing').html(res);
				document.getElementById('imgloader').innerHTML="";
			}
		});
	}
	
	function wpadl_showCampaignUpd(id)
	{ 	document.getElementById('imgloader').innerHTML="<img src="+imgURL+"/wpt-loading-icon.gif>loading...";
		if (window.XMLHttpRequest)
		{// code for IE7+, Firefox, Chrome, Opera, Safari
			xmlhttp=new XMLHttpRequest();
		}
		else
		{// code for IE6, IE5
			xmlhttp=new ActiveXObject("Microsoft.XMLHTTP");
		}
		xmlhttp.onreadystatechange=function()
		{	
		document.getElementById('imgloader').innerHTML="";
			if (xmlhttp.readyState==4 && xmlhttp.status==200)
			{
				document.getElementById("CampaignDivUpd").innerHTML=xmlhttp.responseText;
			}
		}
		xmlhttp.open("GET","<?php echo plugins_url('getcampaigns.php',__FILE__);?>/?id="+id+"&step=1",true);
		xmlhttp.send();
	}

function wpadl_Delete(id,val,trid)
{

if(confirm('Warning : Deletion of Record will also delete data associated with it.Do you want to proceed?'))
{

var resURL = "<?php echo admin_url('admin-ajax.php');?>";
var imgURL = "<?php echo plugins_url('images',__FILE__);?>";

document.getElementById('loader').innerHTML="<img src="+imgURL+"/wpt-loading-icon.gif>loading...";
var data="action=wpadl_delete_Data&id="+id+"&val="+val;
jQuery.ajax(
  {
   type: "POST",
   url: resURL,
   data: data,
   
  success:function(msg)
   {	
		document.getElementById('loader').innerHTML = "";
		  
  		if(msg=='deleted')
		{
		document.getElementById('deleted').innerHTML = "Advertiser Deleted Successfully";
		jQuery('#'+trid).remove();
		}
		
		else if(msg=='campdeleted')
		{
		document.getElementById('deleted').innerHTML = "Campaign Deleted Successfully";
		jQuery('#'+trid).remove();
		}
		else if(msg=='bannerdeleted')
		{
		document.getElementById('deleted').innerHTML = "Banner Deleted Successfully";
		jQuery('#'+trid).remove();
		}
		else if(msg=='zonedeleted')
		{
		document.getElementById('deleted').innerHTML = "Zone Deleted Successfully";
		jQuery('#'+trid).remove();
		}
		else if(msg=='packagedeleted')
		{
		document.getElementById('deleted').innerHTML = "Package Deleted Successfully";
		jQuery('#'+trid).remove();
		}
		else if(msg=='userdeleted')
		{
		document.getElementById('deleted').innerHTML = "User Deleted Successfully";
		jQuery('#'+trid).remove();
		}
   }
  });
  }

}

/*	Function to Delete Advertiser and its entry for wp_users Table
*/
function wpadl_delete_Adv(id,name,val,trid)
{
	var resURL = "<?php echo admin_url('admin-ajax.php');?>";
	var imgURL = "<?php echo plugins_url('images',__FILE__);?>";

	document.getElementById('loader').innerHTML="<img src="+imgURL+"/wpt-loading-icon.gif>loading...";
	var data="action=wpadl_delete_Adv&id="+id+"&val="+val+"&name=" + name;
	jQuery.ajax(
  	{
	   type: "POST",
	   url: resURL,
	   data: data,
	  	success:function(msg)
   		{	
			document.getElementById('loader').innerHTML = "";
			if(msg=='deleted')
			{
				document.getElementById('deleted').innerHTML = "Advertiser Deleted Successfully";
				jQuery('#'+trid).remove();
			}
		}
	});
}

</script>
		<?php
	}

	public function wpadl_load_widgets(){
		include_once WP_ADCENTER_ADMIN_DIR.'wpadcenter-widgets/wpadcenter-lite-ad-widget.php';
		register_widget('ADWidget_lite');
	}

	/**
	 * On the scheduled action hook, run the function.
	 */
	public function wpadcenter_do_this_daily_lite(){

		// do this event daily
		global $wpdb;

		$headers  = 'MIME-Version: 1.0' . "\r\n";
		$headers .= 'Content-type: text/html; charset=iso-8859-1' . "\r\n";
		$headers .= 'Content-Transfer_Encoding: 7bit' . "\r\n";
		if(get_option('adcenterName')!=""&&get_option('adcenterEmail')!=""){


			$headers .= 'From: '.get_option('adcenterName').' <'.get_option('adcenterEmail').'>' . "\r\n";
		}
		else
		{
			$headers .= 'From: Adcenter Admin <'.get_option( "admin_email" ).'>'."\r\n";
		}

		$campaign_list=$wpdb->get_results("SELECT camp.id as cid, camp.advertiser_id as adv_id, camp.name as cname,
			camp.start_date, camp.end_date,  adv.name as adv_name, adv.email as adv_email, adusrzn.user_id, 
			adusrzn.selected_zone, adusrzn.banner_size, adusrzn.package_id, adusrzn.uploaded_files, 
			pack.name as pname, pack.description,pack.m_cost, pack.duration, pack.i_cost, pack.impressions, adz.name as adzname, adz.description as adzdesc
			FROM ".$wpdb->prefix."campaign camp,".$wpdb->prefix."users usr,".$wpdb->prefix."advertiser adv,
			 ".$wpdb->prefix."aduserzones adusrzn, 
			wp_adpackage pack, wp_adzone adz
    		WHERE camp.status=1 AND camp.advertiser_id=adv.id AND camp.user_id=usr.ID
			 AND adusrzn.user_id=camp.user_id AND adusrzn.approved=1
			 AND adusrzn.package_id=pack.id AND pack.adzone_id=adz.id");
		for($i=0;$i<count($campaign_list);$i++)
		{
			$diff=date_diff(date_create($campaign_list[$i]->start_date),date_create($campaign_list[$i]->end_date))->format("%a");
			$current_diff=date_diff(date_create(date("Y-m-d")),date_create($campaign_list[$i]->end_date))->format("%a");
			$ratio=($current_diff*100)/$diff;
			if(5<$ratio && $ratio<=20){
				$message='<h3>Hi '.$campaign_list[$i]->adv_name.'</h3>';
				$message.='<p>Your ad campaign is going to expire soon</p>';
				$message.='<p>Your campaign will get over on '.$campaign_list[$i]->end_date.'</p>';
				$message.='<p>Here are the details: </p>';
				$message.='<p>Campaign Name : '.$campaign_list[$i]->cname.'</p>';
				$message.='<p>Start Date : '.$campaign_list[$i]->start_date.'</p>';
				$message.='<p>Days Remaining : '.$current_diff.'</p>';
				if(get_user_meta($campaign_list[$i]->user_id,"wpadcenter_notification",true)=="1"){
					if(get_user_meta($campaign_list[$i]->user_id,"wpadcenter_notification_mail",true)=="0"){
						wp_mail($campaign_list[$i]->adv_email, "Reminder Email From AdCenter", $message,$headers);
						update_user_meta($campaign_list[$i]->user_id, "wpadcenter_notification_mail", "1");
						sleep(5);
					}
				}
			}
			if(0<$ratio && $ratio<=5){
				$message='<h3>Hi '.$campaign_list[$i]->adv_name.'</h3>';
				$message.='<p>Your ad campaign is going to expire soon</p>';
				$message.='<p>Your campaign will get over on '.$campaign_list[$i]->end_date.'</p>';
				$message.='<p>Here are the details: </p>';
				$message.='<p>Campaign Name : '.$campaign_list[$i]->cname.'</p>';
				$message.='<p>Start Date : '.$campaign_list[$i]->start_date.'</p>';
				$message.='<p>Days Remaining : '.$current_diff.'</p>';
				if(get_user_meta($campaign_list[$i]->user_id,"wpadcenter_notification",true)=="1"){
					if(get_user_meta($campaign_list[$i]->user_id,"wpadcenter_notification_mail",true)=="1"){
						wp_mail($campaign_list[$i]->adv_email, "Reminder Email From AdCenter", $message,$headers);
						update_user_meta($campaign_list[$i]->user_id, "wpadcenter_notification_mail", "2");
						sleep(5);
					}
				}
			}
		}
		$impression_package_campaign_list=$wpdb->get_results("SELECT adsts.id,
				adsts.advertiser_id, adsts.campaign_id, adsts.banner_id, 
				adsts.date, adsts.clicks, adsts.impressions,adv.name as adv_name, 
				adv.email, camp.name as cname,camp.start_date, camp.end_date, 
				adusrzn.user_id, adusrzn.selected_zone, adusrzn.package_id, adusrzn.name as uname, 
				adusrzn.uploaded_files, pack.name pname, pack.description,
				pack.i_cost as imp_cost, pack.impressions as impr 
				FROM ".$wpdb->prefix."adstats adsts,".$wpdb->prefix."advertiser adv, 
				".$wpdb->prefix."campaign camp, ".$wpdb->prefix."aduserzones adusrzn, 
				".$wpdb->prefix."adpackage pack 
				WHERE adsts.advertiser_id=adv.id
				 AND adsts.campaign_id=camp.id
				 AND camp.status=1
				 AND camp.user_id=adusrzn.user_id
				 AND adusrzn.approved=1
				 AND adusrzn.package_id=pack.id");
		for($j=0;$j<count($impression_package_campaign_list);$j++){
			$received_impressions=$impression_package_campaign_list[$j]->impressions;
			$allocated_impressions=$impression_package_campaign_list[$j]->impr;
			$remaining_impressions=intval($impression_package_campaign_list[$j]->impr)-intval($impression_package_campaign_list[$j]->impressions);
			$impressions_ratio=($impression_package_campaign_list[$j]->impressions*100)/$impression_package_campaign_list[$j]->impr;
			if($impressions_ratio>=80 && $impressions_ratio<95){
				$message='<h3>Hi '.$impression_package_campaign_list[$j]->adv_name.'</h3>';
				$message.='<p>Your ad campaign is going to expire soon</p>';
				$message.='<p>Impressions Remaining '.$remaining_impressions.'</p>';
				$message.='<p>Here are the details: </p>';
				$message.='<p>Campaign Name : '.$impression_package_campaign_list[$j]->cname.'</p>';
				$message.='<p>Start Date : '.$impression_package_campaign_list[$j]->start_date.'</p>';
				$message.='<p>Impressions Received: '.$impression_package_campaign_list[$j]->impressions.'</p>';
				$message.='<p>Total Impressions : '.$impression_package_campaign_list[$j]->impr.'</p>';
				if(get_user_meta($campaign_list[$i]->user_id,"wpadcenter_notification",true)=="1"){
					if(get_user_meta($campaign_list[$i]->user_id,"wpadcenter_notification_mail",true)=="0"){
						wp_mail($impression_package_campaign_list[$j]->email, "Reminder Email From AdCenter", $message,$headers);
						update_user_meta($campaign_list[$i]->user_id, "wpadcenter_notification_mail", "1");
						sleep(5);
					}
				}
			}
			if($impressions_ratio>=95 && $impressions_ratio<100){
				$message='<h3>Hi '.$impression_package_campaign_list[$j]->adv_name.'</h3>';
				$message.='<p>Your ad campaign is going to expire soon</p>';
				$message.='<p>Impressions Remaining '.$remaining_impressions.'</p>';
				$message.='<p>Here are the details: </p>';
				$message.='<p>Campaign Name : '.$impression_package_campaign_list[$j]->cname.'</p>';
				$message.='<p>Start Date : '.$impression_package_campaign_list[$j]->start_date.'</p>';
				$message.='<p>Impressions Received: '.$impression_package_campaign_list[$j]->impressions.'</p>';
				$message.='<p>Total Impressions : '.$impression_package_campaign_list[$j]->impr.'</p>';
				if(get_user_meta($campaign_list[$i]->user_id,"wpadcenter_notification",true)=="1"){
					if(get_user_meta($campaign_list[$i]->user_id,"wpadcenter_notification_mail",true)=="1"){
						wp_mail($impression_package_campaign_list[$j]->email, "Reminder Email From AdCenter", $message,$headers);
						update_user_meta($campaign_list[$i]->user_id, "wpadcenter_notification_mail", "2");
						sleep(5);
					}
				}
			}
		}
	}

}
