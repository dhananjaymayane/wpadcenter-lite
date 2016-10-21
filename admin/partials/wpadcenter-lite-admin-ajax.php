<?php
add_action('wp_ajax_wpadl_get_campaigns','wpadl_get_campaigns');
add_action('wp_ajax_nopriv_wpadl_get_campaigns','wpadl_get_campaigns');

function wpadl_get_campaigns()
{
	ob_start();
	global $wpdb;
	
	$table_name = $wpdb->prefix . "campaign";

	if( isset( $_REQUEST['step'] ) && $_REQUEST['step']==1)
	{
		$sel = $wpdb->get_results($wpdb->prepare("SELECT * FROM ".$table_name." WHERE advertiser_id= %d",intval($_REQUEST['id'])));
		echo '<select id="campaignsListingUpd" name="campaignsListingUpd">';
		for($i=0;$i<count($sel);$i++)
		{
           echo '<option value='.$sel[$i]->id.'>'.$sel[$i]->name.'</option>';
		}
		echo '</select>';

	}
	else
	{
		$sel = $wpdb->get_results($wpdb->prepare("SELECT * FROM ".$table_name." WHERE advertiser_id= %d",intval($_REQUEST['id'])));
		echo '<select id="campaignsListing" name="campaignsListing">';
		for($i=0;$i<count($sel);$i++)
		{
           echo '<option value='.$sel[$i]->id.'>'.$sel[$i]->name.'</option>';
		}
		echo '</select>';
	}

	$output = ob_get_contents();
	ob_end_clean();
	echo $output;
	wp_die();
}

add_action('wp_ajax_wpadl_delete_Data','wpadl_delete_Data');
add_action('wp_ajax_nopriv_wpadl_delete_Data','wpadl_delete_Data');

function wpadl_delete_Data(){

	ob_start();
	global $wpdb;
	
	if($_REQUEST['val']=="delcamp")
	{
		$wpdb->delete($wpdb->prefix.'campaign',array('id' => intval($_REQUEST['id'])),array('%d'));
		$wpdb->delete($wpdb->prefix.'banner',array('campaign_id' => intval($_REQUEST['id'])),array('%d'));
		$wpdb->delete($wpdb->prefix.'adv_banner',array('campaign_id' => intval($_REQUEST['id'])),array('%d'));

		echo "campdeleted";

	}
	else if($_REQUEST['val']=="delbanner")
	{
		$wpdb->delete($wpdb->prefix.'banner',array('id' => intval($_REQUEST['id'])),array('%d'));
		$wpdb->delete($wpdb->prefix.'adv_banner',array('banner_id' => intval($_REQUEST['id'])),array('%d'));
		echo "bannerdeleted";

	}
	else if($_REQUEST['val']=="delzone")
	{
		$wpdb->delete($wpdb->prefix.'adzone',array('id' => intval($_REQUEST['id'])),array('%d'));
		$wpdb->delete($wpdb->prefix.'adv_banner', array('banner_id' => intval($_REQUEST['id'])),array('%d'));
		echo "zonedeleted";

	}
	
	else if($_REQUEST['val']=="delpackage")
	{

		$wpdb->delete($wpdb->prefix.'adpackage',array('id' => intval($_REQUEST['id'])),array('%d'));
		echo "packagedeleted";

	}
	if($_REQUEST['val']=="deluser")
	{	
		$wpdb->delete($wpdb->prefix.'aduserzones',array('id' => intval($_REQUEST['id'])),array('%d'));
		echo "userdeleted";

	}
	$output = ob_get_contents();
	ob_end_clean();
	echo $output;
	wp_die();
}

add_action('wp_ajax_wpadl_delete_Adv','wpadl_delete_Adv');
add_action('wp_ajax_nopriv_wpadl_delete_Adv','wpadl_delete_Adv');

function wpadl_delete_Adv(){
	
	ob_start();
	global $wpdb;

	if($_REQUEST['val']=="deladv" && isset($_REQUEST['name']))
	{
		$wpdb->delete($wpdb->prefix."advertiser",array('id' => intval($_REQUEST['id'])),array('%d'));
		$wpdb->delete($wpdb->prefix."campaign",array('advertiser_id' => intval($_REQUEST['id'])),array('%d'));
		$wpdb->delete($wpdb->prefix."banner",array('advertiser_id' => intval($_REQUEST['id'])),array('%d'));
		$wpdb->delete($wpdb->prefix."adv_banner",array('advertiser_id' => intval($_REQUEST['id'])),array('%d'));
		$wpdb->delete($wpdb->prefix."users",array('user_login' => sanitize_text_field(esc_attr($_REQUEST['name']))),array('%s'));
		echo "deleted";
	}

	$output = ob_get_contents();
	ob_end_clean();
	echo $output;
	wp_die();
}

?>