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
              <input class="widefat" id="<?php echo $this->get_field_id('title'); ?>" name="<?php echo $this->get_field_name('title'); ?>" type="text" value="<?php echo $instance['title']; ?>" /></p>
            <p>
                <label for="<?php echo $this->get_field_id('category'); ?>">
                    <?php _e('Select Ad Zone:'); ?>
                </label>
                <select id="<?php echo $this->get_field_id('category'); ?>" class="widefat" name="<?php echo $this->get_field_name('category'); ?>">
                    <?php echo implode('', $cat_options); ?>
                </select>
            </p>
            
            <?php }
	}
}
  





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


add_action( 'widgets_init', 'wpadl_loadWidgets' );

/*	Check if Pro Version is Active 	
*	'plugins_loaded' hooks gets called when plugin loads
*/





?>
