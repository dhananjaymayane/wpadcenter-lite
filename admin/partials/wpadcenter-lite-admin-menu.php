<?php

/**
 * The admin menu functionality of the plugin.
 *
 * Defines the functions that creates the settings pages 
 * in admin.
 *
 * @package    WPAdcenter_Lite
 * @subpackage WPAdcenter_Lite/admin
 */

if( !class_exists( 'WPAcenter_Admin_Menu' ) ){

	class WPAdcenter_Admin_Menu{

		function __construct(){

		}

		///////////////FUNCTIONS FOR MENU'S START HERE ////////////
		function wpadl_setting()
		{
			global $wpdb;

			if ( isset($_POST['add']) )
			{
				$arr = array('email'  => stripslashes(sanitize_email($_POST['paypalEmail'])),'currency' => sanitize_text_field($_POST['currency']),'autorotate' => sanitize_text_field($_POST['autorotate']), 'adcenterEmail' => sanitize_email($_POST['adcenterEmail']), 'adcenterName' => sanitize_text_field($_POST['adcenterName']),'impression'=>sanitize_text_field($_POST['impression']) );

				$table_setting = $wpdb->prefix . "adsetting";   //checking adcenterGeolocation column available or not//Added by Rajashri

				$inserted = wpadl_addSetting($arr);
				if($inserted)
				echo '<div class="updated fade" style="color:red"><p><b>Data Updated successfully.</b></p></div>';

			}
			include(WP_ADCENTER_ADMIN_DIR.'partials/wpadcenter-lite-admin-setting.php');
		}

		function wpadl_advertiser()
		{
			global $wpdb;

			if ( isset($_POST['add']) )
			{

				$arr = array('name'  => sanitize_text_field($_POST['advertiser_name']),'email' => sanitize_email($_POST['advertiser_mail']));

				$already_exist = wpadl_addChkAdvertiser($arr);
					
				if(!$already_exist)
				{
					echo '<div class="updated fade" style="color:red"><p><b>Data saved successfully.</b></p></div>';
					echo "<script>window.location='?page=advertisement'</script>";
				}
				else
				{
					echo '<div class="updated fade" style="color:red"><p><b>Advertiser or User Name,Email ID Already Exist.</b></p></div>';
				}
			}

			if ( isset($_POST['edit']) )
			{
				$arr = array('name'  => sanitize_text_field($_POST['advertiser_nameupd']),'email' => sanitize_email($_POST['advertiser_mailupd']),'id'=>!empty($_REQUEST['id']) ? intval($_REQUEST['id']) : '');
				$already_exist = wpadl_updChkAdvertiser($arr);
					
				if(!$already_exist)
				{
			 	echo '<div class="updated fade" style="color:red"><p><b>Data Updated successfully.</b></p></div>';
			 	echo "<script>window.location='?page=advertisement'</script>";
				}
				else
				{
					echo '<div class="updated fade" style="color:red"><p><b>Advertiser Name Already Exist.</b></p></div>';
				}
			}
			include(WP_ADCENTER_ADMIN_DIR.'partials/wpadcenter-lite-admin-advertisers.php');
		}

		function wpadl_campaign()
		{
			global $wpdb;

			if ( isset($_POST['add']) )
			{
				$arr = array('name'  => sanitize_text_field($_POST['campaignName']),'advertiserId' => intval($_POST['advertiserList']),'sDate' => sanitize_text_field($_POST['campaignStartDate']),'eDate' => sanitize_text_field($_POST['campaignEndDate']));

				$already_exist = wpadl_addChkCampaign($arr);

				if(!$already_exist)
				{
					/*	Function to assign campaign to user	which is created from FrontEnd.
					 *	If no user is found in wp_users table the function has no impact.
					 *	Added By Kaustubh.
					 */

					wpadl_checkAdvertiser($arr['advertiserId'],$arr['name']);
					echo '<div class="updated fade" style="color:red"><p><b>Data saved successfully.</b></p></div>';
					echo "<script>window.location='?page=campaigns'</script>";
				}

				else
				{
					echo '<div class="updated fade" style="color:red"><p><b>Campaign Name Already Exist.</b></p></div>';
				}
			}


			if ( isset($_POST['edit']))
			{
				$arr = array('name'  => sanitize_text_field($_POST['campaignNameUpd']),'advertiserId' =>isset($_POST['advertiserListUpd'])?intval($_POST['advertiserListUpd']):'','sDate' => sanitize_text_field($_POST['campaignStartDateUpd']),'eDate' => sanitize_text_field($_POST['campaignEndDateUpd']),'id'=>isset($_REQUEST['id'])?intval($_REQUEST['id']):'');

					
				$already_exist = wpadl_updChkCampaign($arr);

				if(!$already_exist)
				{
					echo '<div class="updated fade" style="color:red"><p><b>Data Updated successfully.</b></p></div>';
					echo "<script>window.location='?page=campaigns'</script>";
				}
				else
				{
					echo '<div class="updated fade" style="color:red"><p><b>Campaign Name Already Exist.</b></p></div>';
				}
			}

			include(WP_ADCENTER_ADMIN_DIR.'partials/wpadcenter-lite-admin-campaigns.php');
		}

		function wpadl_banner()
		{

			if ( isset($_POST['add']) )
			{
				if( !empty( $_FILES['file']['name'] ) || !empty( $_POST['url'] ) || !empty( $_POST['bannerHtml'] ))
				{

					if( !empty( $_FILES['file']['name'] ))
					{
						$img = wp_handle_upload( $_FILES['file'], array( 'test_form' => false ) );
							
						$filename = $img['file'];
						$wp_filetype = wp_check_filetype(basename($filename), null );
						$attachment = array(
					'post_mime_type' => $wp_filetype['type'],
					'post_title' => preg_replace('/\.[^.]+$/', '', basename($filename)),
					'post_content' => '',
					'post_status' => 'inherit'
					);
					$attach_id = wp_insert_attachment( $attachment, $filename );
					}

					$adzone_html = isset($_POST['bannerHtml']) ? $_POST['bannerHtml'] : '';
					$adzone_html = wp_kses($adzone_html, array(
										'a' => array(
												'href' => array(),
												'title' => array()
					),
										'br' 	=> array(),
										'em' 	=> array(),
										'strong'=> array(),
										'img' 	=> array(
													'src' => array(),
													'width' => array(),
													'height' => array()),
										'class'	=> array(),
										'div'	=> array(),
										'span'	=> array(),
										'style'	=> array(),
										'object' => array(
													'classid' => array(),
													'codebase' => array()),
										'param'	=>array('name' => array(),
														'value' => array()),
										'embed'	=> array(
														'src' => array(),
														'quality' => array(),
														'type' => array())
					));

					$arr = array('name'  => esc_attr(sanitize_text_field($_POST['bannerName'])),'url' => esc_url($_POST['bannerLink']),'target' => sanitize_text_field($_POST['target']),'file' =>$img,'banner_url' => esc_url($_POST['url']),'html' => $adzone_html,'aid' => intval($_POST['advertisersListing']),'cid' => intval($_POST['campaignsListing']),'zones'=>sanitize_text_field($_POST['zones']) );

					$limit_exceed = wpadl_limitBanner();

					if(!$limit_exceed){
						$already_exist = wpadl_addBanner($arr);
						if(!$already_exist)
						{
							echo '<div class="updated fade" style="color:red"><p><b>New Banner Added.</b></p></div>';
							echo "<script>window.location='?page=banners'</script>";
						}
					}
					else{
						echo '<div class="error fade" style="color:red"><p><b>You have Exceeded the Banner Limit of 10.</b></p></div>';
					}
				}
				else
				{
					echo '<div class="updated fade" style="color:red"><p><b>Choose A Banner Type.</b></p></div>';
					echo "<script>window.location=?page=banners</script>";
				}
			}


			if ( isset($_POST['edit']) )
			{


				if( !empty( $_FILES['fileUpd']['name'] ))
				{
					$img1 = wp_handle_upload( $_FILES['fileUpd'], array( 'test_form' => false ) );
					$filename = $img1['url'];
					$wp_filetype = wp_check_filetype(basename($filename), null );
					$attachment = array(
				'post_mime_type' => $wp_filetype['type'],
				'post_title' => preg_replace('/\.[^.]+$/', '', basename($filename)),
				'post_content' => '',
				'post_status' => 'inherit'
				);
				$attach_id = wp_insert_attachment( $attachment, $filename );
				}

				$adzone_htmlUpd = isset($_POST['bannerHtmlUpd']) ? $_POST['bannerHtmlUpd'] : '';
				$adzone_htmlUpd = wp_kses($adzone_htmlUpd, array(
										'a' => array(
												'href' => array(),
												'title' => array()
				),
										'br' 	=> array(),
										'em' 	=> array(),
										'strong'=> array(),
										'img' 	=> array(
													'src' => array(),
													'width' => array(),
													'height' => array()),
										'class'	=> array(),
										'div'	=> array(),
										'span'	=> array(),
										'style'	=> array(),
										'object' => array(
													'classid' => array(),
													'codebase' => array()),
										'param'	=>array('name' => array(),
														'value' => array()),
										'embed'	=> array(
														'src' => array(),
														'quality' => array(),
														'type' => array())
				));


				$arr = array('name'  => sanitize_text_field($_POST['bannerNameUpd']),'url' => esc_url($_POST['bannerLinkUpd']),'target' =>
				sanitize_text_field($_POST['targetUpd']),'file' =>!empty($img1)?$img1:'','banner_url' => esc_url($_POST['urlUpd']),'html' => $adzone_htmlUpd,'id'=>isset($_REQUEST['id'])? intval($_REQUEST['id']):'','zones'=>sanitize_text_field($_POST['zonesUpd']) );

					
				$already_exist = wpadl_updateBanner($arr);

				if(!$already_exist)
				{
					echo '<div class="updated fade" style="color:red"><p><b>Banner Updated.</b></p></div>';
					echo "<script>window.location='?page=banners'</script>";
				}

				else echo "Error";
			}


			include(WP_ADCENTER_ADMIN_DIR.'partials/wpadcenter-lite-admin-banners.php');
		}

		function wpadl_adzones()
		{

			global $wpdb;
			$img = '';

			if ( isset($_POST['add']) )
			{
				if( !empty( $_FILES['default_banner']['name'] ))
				{
					$img = wp_handle_upload( $_FILES['default_banner'], array( 'test_form' => false ) );

					$filename = $img['url'];
					$wp_filetype = wp_check_filetype(basename($filename), null );
					$attachment = array(
					'post_mime_type' => $wp_filetype['type'],
					'post_title' => preg_replace('/\.[^.]+$/', '', basename($filename)),
					'post_content' => '',
					'post_status' => 'inherit'
					);
					$attach_id = wp_insert_attachment( $attachment, $filename );
				}

				$arr = array('name'  => esc_attr(sanitize_text_field($_POST['zoneName'])),'size' => sanitize_text_field($_POST['BannerSize']),'desc'=>sanitize_text_field($_POST['zoneDesc']),'signupurl'=>esc_url($_POST['signup']),'showadvert'=>!empty($_POST['showadvert'])?intval($_POST['showadvert']):'' , 'default_banner' =>$img);

				$already_exist = wpadl_addChkZones($arr);

				if(!$already_exist)
				{
					echo '<div class="updated fade" style="color:red"><p><b>Data saved successfully.</b></p></div>';
					echo "<script>window.location='?page=adzones'</script>";
				}
				else
				{
					echo '<div class="updated fade" style="color:red"><p><b>Zone Name Already Exist.</b></p></div>';
				}
			}



			if ( isset($_POST['edit']) )
			{
				if( !empty( $_FILES['default_bannerUpd']['name'] ))
				{
					$img = wp_handle_upload( $_FILES['default_bannerUpd'], array( 'test_form' => false ) );
					$filename = $img['url'];
					$wp_filetype = wp_check_filetype(basename($filename), null );
					$attachment = array(
					'post_mime_type' => $wp_filetype['type'],
					'post_title' => preg_replace('/\.[^.]+$/', '', basename($filename)),
					'post_content' => '',
					'post_status' => 'inherit'
					);
					$attach_id = wp_insert_attachment( $attachment, $filename );
				}

				$arr = array('name'  => esc_attr(sanitize_text_field($_POST['zoneNameUpd'])),'size' => sanitize_text_field($_POST['BannerSizeUpd']),'desc'=>sanitize_text_field($_POST['zoneDescUpd']),'signupurl'=>esc_url($_POST['signupUpd']),'showadvert'=>!empty($_POST['showadvertUpd'])?intval($_POST['showadvertUpd']):'','id'=>!empty($_REQUEST['id'])?intval($_REQUEST['id']):'' , 'default_bannerUpd' =>$img );
				$already_exist = wpadl_updChkZones($arr);

				if(!$already_exist)
				{
					echo '<div class="updated fade" style="color:red"><p><b>Data Updated successfully.</b></p></div>';
					echo "<script>window.location='?page=adzones'</script>";
				}
				else
				{
					echo '<div class="updated fade" style="color:red"><p><b>Zone Name Already Exist.</b></p></div>';
				}
			}

			include(WP_ADCENTER_ADMIN_DIR.'partials/wpadcenter-lite-admin-adzones.php');
		}
		function wpadl_package()
		{
			global $wpdb;

			if ( isset($_POST['add']) )
			{
				if($_REQUEST['packCostMon']!='' || $_REQUEST['packCostImp']!='')
				{
					$arr = array('name'  => sanitize_text_field($_POST['packageName']),'adzone_id' => intval($_POST['adZones']),'desc'=>sanitize_text_field($_POST['description']),'monthcost'=>intval($_POST['packCostMon']),'duration'=>sanitize_text_field($_POST['duration']),'impcost'=>intval($_POST['packCostImp']),'impression'=>intval($_POST['impression']));
					wpadl_addPackages($arr);

					echo '<div class="updated fade" style="color:red"><p><b>Data saved successfully.</b></p></div>';
					echo "<script>window.location='?page=packages'</script>";
				}
				else
				{
					echo '<div class="updated fade" style="color:red"><p><b>Please Select One Of The Package.</b></p></div>';
					echo "<script>window.location=?page=packages</script>";
				}
			}


			if ( isset($_POST['edit']) )
			{
				if($_REQUEST['packCostMonUpd']!='' || $_REQUEST['packCostImpUpd']!='')
				{

					$arr = array('name'  => sanitize_text_field($_POST['packageNameUpd']),'adzone_id' => intval($_POST['adZonesUpd']),'desc'=>sanitize_text_field($_POST['descriptionUpd']),'monthcost'=>intval($_POST['packCostMonUpd']),'duration'=>sanitize_text_field($_POST['durationUpd']),'impcost'=>intval($_POST['packCostImpUpd']),'impression'=>intval($_POST['impressionUpd']),'id'=>intval($_REQUEST['id']) );

					wpadl_updPackages($arr);

					echo '<div class="updated fade" style="color:red"><p><b>Data Updated successfully.</b></p></div>';
					echo "<script>window.location='?page=packages'</script>";
				}
				else
				{
					echo '<div class="updated fade" style="color:red"><p><b>Please Select One Of The Package.</b></p></div>';
					echo "<script>window.location=?page=packages</script>";
				}

			}

			include(WP_ADCENTER_ADMIN_DIR.'partials/wpadcenter-lite-admin-packages.php');
		}

		function wpadl_statistics()
		{
			include(WP_ADCENTER_ADMIN_DIR.'partials/wpadcenter-lite-admin-statistics.php');
		}

		function wpadl_status()
		{
			include(WP_ADCENTER_ADMIN_DIR.'partials/wpadcenter-lite-admin-clientStatus.php');
		}


		function wpadl_email_notification(){
			$user_ID = get_current_user_id();
			if(get_user_meta($user_ID,"wpadcenter_notification",true)=="1"){
				update_user_meta($user_ID, "wpadcenter_notification", "0");
			}
			else{
				update_user_meta($user_ID, "wpadcenter_notification", "1");
			}
			echo get_user_meta($user_ID,"wpadcenter_notification",true);
			wp_redirect($_SERVER['HTTP_REFERER']);
		}
		
	}
}