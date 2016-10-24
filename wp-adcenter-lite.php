<?php
/**
 Plugin Name: WP AdCenter Lite
 Version: 1.2
 Plugin URI: http://wpadcenter.com
 Description: Advertising management plugin for WordPress
 Author:  WPEka Team
 Author URI: http://club.wpeka.com
 **/

//	**** Require functions and display zone files ****//
define( 'WP_ADCENTER_LITE_PLUGIN_DIR', plugin_dir_path( __FILE__ ) );
define( 'WP_ADCENTER_PUBLIC_DIR', WP_ADCENTER_LITE_PLUGIN_DIR.'public/' );
define( 'WP_ADCENTER_ADMIN_DIR', WP_ADCENTER_LITE_PLUGIN_DIR.'admin/' );
define( 'WP_ADCENTER_LITE_PLUGIN_URL', plugin_dir_url( __FILE__ ) );
define( 'WP_ADCENTER_PUBLIC_URL', WP_ADCENTER_LITE_PLUGIN_URL.'public/' );
define( 'WP_ADCENTER_ADMIN_URL', WP_ADCENTER_LITE_PLUGIN_URL.'admin/' );
$pluginUrl = WP_PLUGIN_URL.'/'.str_replace(basename( __FILE__),"",plugin_basename(__FILE__));

require_once(WP_ADCENTER_LITE_PLUGIN_DIR.'includes/wpadcenter-lite-ajax.php');
require_once(WP_ADCENTER_LITE_PLUGIN_DIR.'plugin-name.php');
function wpadl_menu_function()
{

}

///////////////FOR MENU END//////////////////

/*
 *FUNCTION FOR  DISPLAY AD ZONE
 */
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
	extract( shortcode_atts( array('id' => 1), $atribute ) ); return wpadl_displayAdzone( esc_attr($id) );
}

// Function For Redirecting To The Link Url

function wpadl_clickOnBanner()
{
	if ( isset($_GET['move_to']) ){ require_once(WP_ADCENTER_ADMIN_DIR.'partials/redirect.php');}
}


function wpadl_showCampaignName()
{
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

function wpadl_createtables()
{
	global $wpdb;

	$table_advertisers = $wpdb->prefix . "advertiser";          ///////////      Advertiser Table  /////////////
	if($wpdb->get_var("show tables like '$table_advertisers'") != $table_advertisers) {

		$sql_advertisers = "CREATE TABLE " . $table_advertisers . " (
		id mediumint(9) NOT NULL AUTO_INCREMENT,
	    name varchar(200) NOT NULL,
	    email varchar(200) NOT NULL,
	    UNIQUE KEY id (id)
	);";

		require_once(ABSPATH . 'wp-admin/includes/upgrade.php');
		dbDelta($sql_advertisers); }


		//$table_setting =$wpdb->prefix . "adsetting";

		$table_setting = $wpdb->prefix . "adsetting";          ///////////      Setting Table added new column for geolocation by Rajashri/////////////

		if($wpdb->get_var("show tables like '$table_setting'") != $table_setting)
		{
			$sql_setting = "CREATE TABLE " . $table_setting . " (
		id int(11) DEFAULT  NULL,
		emailPaypal varchar(200) DEFAULT NULL,
		currency varchar(200) DEFAULT NULL,
		adcenterGeolocation varchar(100) DEFAULT NULL,			
		PRIMARY KEY (`id`));";

			require_once(ABSPATH . 'wp-admin/includes/upgrade.php');
			dbDelta($sql_setting);
		}

		$table_campaign = $wpdb->prefix . "campaign";          ///////////      Campaign table  added new column for geolocation by Rajashri/////////////
		if($wpdb->get_var("show tables like '$table_campaign'") != $table_campaign) {

			$sql_campaigns = "CREATE TABLE " . $table_campaign . " (
		id mediumint(9) NOT NULL AUTO_INCREMENT,
	    advertiser_id mediumint(9) NOT NULL,
	    name varchar(200) NOT NULL,
		start_date date NOT NULL,
	    end_date date NOT NULL,
		status varchar(50) NOT NULL,
		user_id int(11) DEFAULT NULL,
	    UNIQUE KEY id (id)
	);";

			require_once(ABSPATH . 'wp-admin/includes/upgrade.php');
			dbDelta($sql_campaigns); }


			$table_banner = $wpdb->prefix . "banner";          ///////////      Banner table  /////////////
			if($wpdb->get_var("show tables like '$table_banner'") != $table_banner) {

				$sql_banner = "CREATE TABLE " . $table_banner . " (
		id mediumint(9) NOT NULL AUTO_INCREMENT,
	    advertiser_id mediumint(9) NOT NULL,
	    campaign_id mediumint(9) NOT NULL,
		name varchar(200) NOT NULL,
		file varchar(300) NOT NULL,
		ext_file varchar(300) NOT NULL,
		size varchar(100) NOT NULL,
		html text NOT NULL,
		url text NOT NULL,
		target varchar(50) NOT NULL,
		adzone varchar(200),
	    UNIQUE KEY id (id)
	);";

				require_once(ABSPATH . 'wp-admin/includes/upgrade.php');
				dbDelta($sql_banner); }


				$table_zone = $wpdb->prefix . "adzone";          			///////////      Adzone table  /////////////
				if($wpdb->get_var("show tables like '$table_zone'") != $table_zone) {

					$sql_zones = "CREATE TABLE " . $table_zone . " (
		id mediumint(9) NOT NULL AUTO_INCREMENT,
	    name varchar(200) NOT NULL,
	    size varchar(100) NOT NULL,
		description text NOT NULL,
		horizontal varchar(50) NOT NULL,
	    vertical varchar(50) NOT NULL,
		custom int(11) NOT NULL,
		showsignuplink int(11) NOT NULL,                 
        signuplink text, 
		default_banner varchar(300),
	    UNIQUE KEY id (id)
	);";

					require_once(ABSPATH . 'wp-admin/includes/upgrade.php');
					dbDelta($sql_zones);
				}
				else {
					$sql_default_banner = "SHOW COLUMNS FROM ".$table_zone." LIKE 'default_banner'";
					if(!$wpdb->get_var($sql_default_banner)){
						$sql2='ALTER TABLE '.$table_zone.' ADD default_banner varchar(300)';
						$wpdb->query($sql2);
					}
				}

				if($wpdb->get_var("show tables like '$table_zone'") == $table_zone) {

					$sql_zones_alter = "CREATE TABLE " . $table_zone . " (
		showsignuplink int(11) NOT NULL,                 
        signuplink text
	);";

					require_once(ABSPATH . 'wp-admin/includes/upgrade.php');
					dbDelta($sql_zones_alter); }


					$table_showbanner = $wpdb->prefix . "adv_banner";          ///////////      Ad Banner table  /////////////
					if($wpdb->get_var("show tables like '$table_showbanner'") != $table_showbanner) {

						$sql_showbanner = "CREATE TABLE " . $table_showbanner . " (
		id mediumint(9) NOT NULL AUTO_INCREMENT,
	    advertiser_id mediumint(9) NOT NULL,
		campaign_id mediumint(9) NOT NULL,
		banner_id mediumint(9) NOT NULL,
		adzone_id mediumint(9) NOT NULL,
	    UNIQUE KEY id (id)
	);";

						require_once(ABSPATH . 'wp-admin/includes/upgrade.php');
						dbDelta($sql_showbanner); }

						$table_package = $wpdb->prefix ."adpackage";          ///////////      Ad Package table  /////////////
						if($wpdb->get_var("show tables like '$table_package'") != $table_package) {

							$sql_package = "CREATE TABLE " .$table_package . " (
		id mediumint(9) NOT NULL AUTO_INCREMENT,
	    name varchar(255) NOT NULL,
		adzone_id mediumint(9) NOT NULL,
		description text,
		m_cost varchar(255),
		duration varchar(255),
		i_cost varchar(255),
		impressions varchar(255),
	    UNIQUE KEY id (id)
	);";

							require_once(ABSPATH . 'wp-admin/includes/upgrade.php');
							dbDelta($sql_package); }

							$table_stats = $wpdb->prefix ."adstats";          ///////////      Stats table  /////////////
							//comented the below if condition to stop table being deleted after activation of plugin. ( by Prachi)
							/*if($wpdb->get_var("show tables like '$table_stats'") == $table_stats)
							 {
							 $wpdb->query("drop table $table_stats ");
							 }*/
							if($wpdb->get_var("show tables like '$table_stats'") != $table_stats) {

								$sql_stats = "CREATE TABLE " .$table_stats . " (
		id int(11) NOT NULL AUTO_INCREMENT,
	    advertiser_id int(11) DEFAULT NULL,
		campaign_id int(11) DEFAULT NULL,
		banner_id int(11) DEFAULT NULL,
		   `date` date DEFAULT NULL,                              
              `clicks` int(11) DEFAULT NULL,                         
              `impressions` int(11) DEFAULT NULL,  
	    UNIQUE KEY id (id)
	);";

								require_once(ABSPATH . 'wp-admin/includes/upgrade.php');
								dbDelta($sql_stats); }


								$table_aduserzones = $wpdb->prefix ."aduserzones";          ///////////      Aduserzones table  ///////inserted country coulmn by Rajashri//////
								if($wpdb->get_var("show tables like '$table_aduserzones'") != $table_aduserzones) {

									$sql_aduserzones = "CREATE TABLE " .$table_aduserzones . " (
		id int(11) NOT NULL AUTO_INCREMENT,
	    user_id int(11) DEFAULT NULL,
		selected_zone varchar(255) DEFAULT NULL,
		banner_size varchar(255) DEFAULT NULL,
		name varchar(255) DEFAULT NULL,
		password varchar(255) DEFAULT NULL,
		email varchar(255) DEFAULT NULL,
		package_id int(11) DEFAULT NULL,
		uploaded_files varchar(255) DEFAULT NULL,
		website_url varchar(255) DEFAULT NULL,
		alt_text varchar(255) DEFAULT NULL,
		approved int(11) DEFAULT NULL,
	    UNIQUE KEY id (id)
	);";

									require_once(ABSPATH . 'wp-admin/includes/upgrade.php');
									dbDelta($sql_aduserzones ); }

}

// This function loads JQuery in our theme
function wpadl_loadJqueryForTheme() {

	global $pluginUrl;
	wp_register_script( 'validjs', WP_ADCENTER_PUBLIC_URL.'js/valid.js', $deps = array(), $ver = '1.5.0', $media = 'all');
	wp_register_script( 'validatejs', WP_ADCENTER_PUBLIC_URL.'js/jquery.validate.js', $deps = array(), $ver = '1.5.0', $media = 'all');
	wp_register_script('sliderjs',WP_ADCENTER_PUBLIC_URL.'js/slider.js',array( 'jquery' ), $ver = '1.5.0');

	wp_enqueue_script( 'sliderjs');
	wp_enqueue_script( 'validatejs');
	wp_enqueue_script( 'validjs');
	wpadl_checkFinished();
	wpadl_impressionEndDate();

}

function wpadl_loadWidgets() {

	register_widget('ADWidget_lite');
}

if( !class_exists('ADWidget_lite')){

	class ADWidget_lite extends WP_Widget {
		function ADWidget_lite() {
			//Constructor
			parent::__construct(false, $name = 'WP Adcenter', array('description' => 'Widget For AdCenter Plugin.'));
		}


		function widget($args, $instance) {
			// outputs the content of the widget
			extract( $args );
			$category = (is_numeric($instance['category']) ? (int)$instance['category'] : '');
			$title = empty($instance['title']) ? ' ' : apply_filters('widget_title', $instance['title']);
			 
			echo $before_widget;
			if ( !empty( $title ) ) { echo $before_title . $title . $after_title; };
			if ( $category )
			{if( function_exists( 'wpadl_displayAdzone' ) )    echo wpadl_displayAdzone( $category );}
				
			/* After widget (defined by themes). */
			echo $after_widget;
		}

		function update($new_instance, $old_instance) {
			//update and save the widget

			return $new_instance;
		}
		function form($instance) {
			//widgetform in backend
			global $wpdb;
			$totalZones = wpadl_totalZones('ORDER BY name ASC');

			$category = !empty($instance) ? esc_attr($instance['category']):'';

			$title = !empty($instance) ? strip_tags($instance['title']):'';
			// Get the existing categories and build a simple select dropdown for the user.
			$categories = $totalZones;
			$cat_options = array();
			$cat_options[] = '<option value="BLANK">Select one...</option>';
			for($i=0;$i<count($categories);$i++) {
				$selected = $category === $categories[$i]->id ? ' selected="selected"' : '';
				$cat_options[] = '<option value="' . $categories[$i]->id .'"' . $selected . '>' . $categories[$i]->name . '</option>';
			}
			?>
<p>

	<label for="<?php echo $this->get_field_id('title'); ?>">Title: </label>
	<input class="widefat" id="<?php echo $this->get_field_id('title'); ?>"
		name="<?php echo $this->get_field_name('title'); ?>" type="text"
		value="<?php echo $instance['title']; ?>" />
</p>
<p>
	<label for="<?php echo $this->get_field_id('category'); ?>"> <?php _e('Select Ad Zone:'); ?>
	</label> <select id="<?php echo $this->get_field_id('category'); ?>"
		class="widefat"
		name="<?php echo $this->get_field_name('category'); ?>">
		<?php echo implode('', $cat_options); ?>
	</select>
</p>

		<?php }
	}
}


add_action('wp_loaded','wpadl_clickOnBanner');
register_activation_hook( __FILE__, 'wpadl_createtables');


register_activation_hook( __FILE__, 'wpadcenter_activation_lite' );
/**
 * On activation, set a time, frequency and name of an action hook to be scheduled.
 */
function wpadcenter_activation_lite() {
	wp_schedule_event( time(), 'daily', 'wpadcenter_daily_event_hook' );
}




add_action( 'wpadcenter_daily_event_hook', 'wpadcenter_do_this_daily_lite' );
/**
 * On the scheduled action hook, run the function.
 */
function wpadcenter_do_this_daily_lite() {
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


register_deactivation_hook( __FILE__, 'wpadcenter_deactivation_lite' );
/**
 * On deactivation, remove all functions from the scheduled action hook.
 */
function wpadcenter_deactivation_lite() {
	wp_clear_scheduled_hook( 'wpadcenter_daily_event_hook' );
}


add_action('admin_head', 'wpadl_showCampaignName');
add_shortcode('displayAdzone', 'wpadl_displayAdzoneFunction');

add_action( 'widgets_init', 'wpadl_loadWidgets' );

/*	Check if Pro Version is Active
 *	'plugins_loaded' hooks gets called when plugin loads
 */

add_action( 'plugins_loaded', 'wpadl_force_deactivation' );

function wpadl_force_deactivation(){

	if(defined('WP_ADCENTER_PLUGIN_DIR')){

		// if plugin is found active then display errors message
		add_action('admin_notices' , 'wpadl_forced_deactivation_notice');
	}
	else{
		// else include the files
		require_once(WP_ADCENTER_LITE_PLUGIN_DIR.'includes/wpadcenter-lite-functions.php');
		require_once(WP_ADCENTER_PUBLIC_DIR.'partials/wpadcenter-lite-adzone_display.php');
		add_action('init', 'wpadl_loadJqueryForTheme');
	}
}

function wpadl_forced_deactivation_notice(){
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
?>
