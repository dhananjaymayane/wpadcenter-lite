<?php
global $wpdb;
$d=date('Y-m-d');
if($_REQUEST['id'] !="")
{	
	$totalstats = wpadl_totalStats_fromRedirect($_REQUEST['aid'], $_REQUEST['cid'], $_REQUEST['id'], $d );
	
	//$arr_of_click = array('date'=> date('Y-m-d'),'clicks'=> 1);
		
	if( count($totalstats))
	{
		//$arr = unserialize(stripslashes($totalstats[0]->clicks));
		//$arr[] = $arr_of_click;
	
		$wpdb->query("UPDATE " . $wpdb->prefix . "adstats SET clicks = clicks+1 WHERE id = '".$totalstats[0]->id."'");
		
	}
	else
	{
		//$arr[] = $arr_of_click;
					
		$wpdb->insert($wpdb->prefix."adstats",array('advertiser_id' => intval($_REQUEST['aid']),'campaign_id' => intval($_REQUEST['cid']),'banner_id' => intval($_REQUEST['id']),'date' => $d,'clicks' => 1,'impressions' => 0));
	}
}

//This will redirect user to the location which is defined in banner link url
header('Location: '. $_GET['move_to']);
exit;
?>