<?php

/**
 * Fired during plugin activation
 *
 * @link       http://example.com
 * @since      1.0.0
 *
 * @package    Plugin_Name
 * @subpackage Plugin_Name/includes
 */

/**
 * Fired during plugin activation.
 *
 * This class defines all code necessary to run during the plugin's activation.
 *
 * @since      1.0.0
 * @package    Plugin_Name
 * @subpackage Plugin_Name/includes
 * @author     Your Name <email@example.com>
 */
class WPAcenter_Lite_Activator {

	/**
	 * Short Description. (use period)
	 *
	 * Long Description.
	 *
	 * @since    1.0.0
	 */
	public static function activate() {
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

}
