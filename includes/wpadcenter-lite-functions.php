<?php
/* FUNCTIONS FOR ADVERTISERS */  

function wpadl_totalAdvertiser($orderby = '')   //Function for finding total number of advertisers based on query
{ 
	global $wpdb;
	$totalAdvertisers = $wpdb->get_results("SELECT * FROM ".$wpdb->prefix."advertiser ".$orderby);

	return $totalAdvertisers;
}

function wpadl_updAdvertiser($id)				  //Function for gathering information of a particular record from advertiser table
{ 
	global $wpdb;

	$rec = $wpdb->get_results($wpdb->prepare("SELECT * FROM ".$wpdb->prefix."advertiser WHERE id = %d",$id));
		
    return $rec;
}

function wpadl_selAdvertiser($id)              //Function used when user want to add campaign from advertiser page 
{
	global $wpdb;
	$id= intval($id);

	$sel = $wpdb->get_results($wpdb->prepare("SELECT * FROM " . $wpdb->prefix ."advertiser WHERE id= %d",$id));

	return $sel;
	
}

function wpadl_showCampaignInAdvPage($id)      //Function for showing edit, stats link in advertiser page 
{
	global $wpdb;
	
	$sel = $wpdb->get_results($wpdb->prepare("SELECT * FROM wp_campaign where advertiser_id= %d",$id));
	return $sel;
}



function wpadl_addChkAdvertiser($arr)			 //Function for checking duplicate entry of advertisers if return false then insert record
{
	global $wpdb;
	$exist = $wpdb->get_var($wpdb->prepare("SELECT COUNT(*) FROM ".$wpdb->prefix."advertiser WHERE name = %s",$arr['name']));

	if( !$exist)
	{	
		/*	Advertiser is now also a new wp user
		*	Added by Kaustubh
		*/
		$username = $arr['name'];
		$email = $arr['email'];
		$random_password = wp_generate_password(12);
		$status = wp_create_user($username,$random_password,$email);
		if(is_wp_error($status))
		{
			$err = 1;
		}
		else{
			$err = 0;
			$wpdb->insert($wpdb->prefix . 'advertiser',array('name' => $arr['name'], 'email' => $arr['email']),array('%s','%s') );
		}
	}
	else
	{
		$err = 1;
	}
	return $err;
}


function wpadl_updChkAdvertiser($arr)				//Function for checking duplicate entry if return false then update record
{ 
	global $wpdb;
	$updcheck = $wpdb->get_results($wpdb->prepare("SELECT * FROM ".$wpdb->prefix."advertiser WHERE name!= %s",sanitize_text_field(esc_attr($_REQUEST['aname']))));

	$arrname = array();

	for($i=0;$i<count($updcheck);$i++)
	{
		$arrname[] = sanitize_text_field(esc_attr($updcheck[$i]->name));
	}
	$name = sanitize_text_field(esc_attr($_REQUEST['advertiser_nameupd']));
	if(in_array($name, $arrname))
	{ 
		$err = 1;
	}
	else
	{
	    $wpdb->update($wpdb->prefix .'advertiser',array( 'name' => $arr['name'],'email' => $arr['email'] ), array('id' => $arr['id']),array('%s','%s'));
		$err = 0;
	}
	
	return $err;
}


/* FUNCTIONS FOR SETTING */ 
 
function wpadl_addSetting($arr)            //FUNCTION FOR ADDING EMAIL
{ 
	global $wpdb;
	$autoroate=$arr['autorotate'];
	update_option("autorotate",$autoroate);
	$impressiondisplay=$arr['impression'];
	update_option("impression",$impressiondisplay);
	$adcenterEmail=$arr['adcenterEmail'];
	update_option("adcenterEmail",$adcenterEmail);
	$adcenterName=$arr['adcenterName'];
	update_option("adcenterName",$adcenterName);
	$email=$arr["email"];
	$currency=$arr["currency"];
								//Checking data already present or not//Added by Rajashri
						
	$table_setting = $wpdb->prefix . "adsetting";
	if(!$wpdb->get_var("SELECT * FROM $table_setting WHERE id='1'"))
	{
		$ins = $wpdb->insert($wpdb->prefix."adsetting",array('id' => 1));
	}

	$insSetting = $wpdb->update($wpdb->prefix."adsetting",array('emailPaypal' => $email,'currency' => $currency),array('id' => 1));
	return $insSetting;
	
}

function wpadl_totalMail()			//FUNCTION FOR FETCHING RECORD FROM SETTING TABLE
{
	global $wpdb;
	$sel = $wpdb->get_results('SELECT * FROM '.$wpdb->prefix.'adsetting ');
	
	return  $sel;
}


/* FUNCTIONS FOR CAMPAIGN */ 

function wpadl_addChkCampaign($arr)                    //Function for checking duplicate entry of campaigns if return false insert record
{  	
	global $wpdb;
	$check = $wpdb->get_var($wpdb->prepare('SELECT COUNT(*) FROM '.$wpdb->prefix.'campaign WHERE name = %s',$arr['name']));
	if( !$check )
	{
	
	
	// Create startdate
		$sdate = date("Y-m-d", strtotime($arr['sDate']));

		// Create enddate
		if( !empty( $arr['eDate'] ))
		{
			$edate = date("Y-m-d", strtotime($arr['eDate']));
		}
		$enddate = empty( $arr['eDate'] ) ? '0000-00-00' : $edate;
		$status = wpadl_campaignStatus( 1, $sdate, $enddate );		//added country_picker field in campaign by Rajashri

		$wpdb->insert($wpdb->prefix.'campaign',array('advertiser_id' => $arr['advertiserId'], 'name' => $arr['name'],'start_date' => $sdate,'end_date' => $enddate,'status' => $status,'user_id' => 0));

		$err = 0;
	}
	else
	{
		$err = 1;
	}
	return $err;
}

				
function wpadl_updChkCampaign($arr)				//Function for checking duplicate entry of campaigns if return false then update record						
{ 
	global $wpdb;
	$updcheck = $wpdb->get_results($wpdb->prepare('SELECT * FROM '.$wpdb->prefix.'campaign WHERE name!= %s',sanitize_text_field(esc_attr($_REQUEST['cname'])) ));
	

	$arrname = array();

	for($i=0;$i<=count($updcheck);$i++)
	{
		if(isset($updcheck[$i]))
		{
		$arrname[] = stripslashes($updcheck[$i]->name);
		}
	}
	$name = sanitize_text_field(esc_attr($_REQUEST['campaignNameUpd']));

	if(in_array($name, $arrname))
	{ 
		$err = 1;
	}
	else
	{
		// Create startdate
		$sdate = date("Y-m-d", strtotime($arr['sDate']));
		
		// Create enddate
		if( !empty( $arr['eDate'] ))
		{
			$edate = date("Y-m-d", strtotime($arr['eDate']));
		}
		$enddate = empty( $arr['eDate'] ) ? '0000-00-00' : $edate;
		$status = wpadl_campaignStatus( 1, $sdate, $enddate );			//added country_picker field in campaign by Rajashri

	    $wpdb->update($wpdb->prefix.'campaign',array('name' => $arr['name'], 'start_date' => $sdate, 'end_date' => $enddate,'status' => $status), array('id' => $arr['id']));

		$err = 0;
	}
	
	return $err;
}


function wpadl_campaignStatus( $status, $sdate, $edate )      //Function for setting status on the basis of date
{	
	$now = strtotime(date('Y-m-d'));
	$sdate = strtotime($sdate);
	$edate = strtotime($edate);
	$nodate=strtotime("0000-00-00");
	if( $now < $sdate )
	{	
		$status = 3;
	}
	elseif( !empty( $edate) && $nodate!=$edate && $now > $edate )
	{
	
		$status = 0;
	}
	return $status;
}


function wpadl_chkStatus( $status)			//Function for checking status of campiagns
{	
	
	global $wpdb;
	$checkStatus = $wpdb->get_results($wpdb->prepare('SELECT * FROM '.$wpdb->prefix.'campaign WHERE status = %d',intval($status)) );
	
	return $checkStatus;
}

function wpadl_updCampaign($id)
{ 
	global $wpdb;
	$rec = $wpdb->get_results($wpdb->prepare('SELECT * FROM '.$wpdb->prefix.'campaign WHERE id = %d',$id));

    return $rec;
}


function wpadl_getAdvertiser($name)
{
	global $wpdb;
	
	$val = $wpdb->get_results($wpdb->prepare('SELECT wp_advertiser.name FROM wp_advertiser join  wp_campaign on  wp_advertiser.id= wp_campaign.advertiser_id where wp_campaign.name = %s',sanitize_text_field(esc_attr($name))));

    return $val;
}

function wpadl_selectedCampaign($camp_id)
{
	global $wpdb;
	$sel = $wpdb->get_results($wpdb->prepare('SELECT * FROM wp_campaign WHERE id = %d LIMIT 1',intval($camp_id)));
	return $sel;
}

function wpadl_selCampaign($id)               //Function used when user want to add banner from Campaign page 
//Function used to show campaigns list of a particular advertiser (when want to edit campaign from advertiser page) 
										
{
	global $wpdb;
	$id = intval($id);
	
	$sel = $wpdb->get_results($wpdb->prepare('SELECT * FROM ' . $wpdb->prefix .'campaign WHERE advertiser_id=%d ORDER BY id DESC',$id));
	return $sel;
	
}


function wpadl_getCampaign()
										
{
	global $wpdb;
	

	$sel = $wpdb->get_results('SELECT * FROM ' . $wpdb->prefix .'campaign  ORDER BY id DESC');
	return $sel;
	
}

function wpadl_getCampaignCurrentUser($ID)
{
	global $wpdb;
	
	$get = $wpdb->get_results($wpdb->prepare('SELECT * FROM ' . $wpdb->prefix .'campaign  where user_id= %d ORDER BY id DESC',$ID));
	return $get;
}


function wpadl_countCurrentUser($ID)
{
	global $wpdb;
	
	$count = $wpdb->get_results($wpdb->prepare('SELECT count(user_id) FROM ' . $wpdb->prefix .'campaign  where user_id= %d ORDER BY id DESC',$ID));
	return $count;
}


function wpadl_getImpresionResult($campaignId,$sDate,$eDate)
{
	global $wpdb;
	
	$sel = $wpdb->get_results($wpdb->prepare('SELECT * FROM ' . $wpdb->prefix .'adstats where campaign_id= %d',$campaignId));

	for($i=0;$i<count($sel);$i++) 
	{  
		$StatsImprsn[] = unserialize(stripslashes($sel[$i]->impressions));
	}
		
	$StatsImprsn = subval_sort($StatsImprsn['0'],'date');
	
	/**   Final Array For Count Impression  **/	

	for($j=0;$j<count($StatsImprsn);$j++)
	{	
		if($sDate!='' && $eDate!='') 
			{
				if(strtotime($StatsImprsn[$j][date])>=strtotime($sDate) && strtotime($StatsImprsn[$j][date])<=strtotime($eDate))
					{
						$arr[$j] = $StatsImprsn[$j][date];
					}
			}
		else
			{
				$arr[$j] = $StatsImprsn[$j][date];
			}
		
	}
	
			$i=1;
			$arr2 = array();
			if(count($arr)>0)
			{
				foreach($arr AS $value)
				{
					 if(in_array($value,array_keys($arr2)))
					  $arr2[$value] = $arr2[$value]+1;
					 else
					 {
					  $arr2[$value] = 1;
					 }
				}
			}
			
			$a=0;
			foreach($arr2 AS $key=>$value)
			{
			 $narr[$a][0] = $key;
			 $narr[$a][1] = $value;
			 $a++;
			}
		
			return $narr;
}
		/*End  getImpresionResult Function */

function subval_sort($a,$subkey) {
	if(count($a)>0)
	{
		foreach($a as $k=>$v) {
			$b[$k] = strtolower($v[$subkey]);
		}
		asort($b);
	
		foreach($b as $key=>$val) {
			$c[] = $a[$key];
		}
		return $c;
	}
}


function wpadl_getCampaignResult($campaignId,$sDate,$eDate)
{
	global $wpdb;
	if(!empty($sDate) && !empty($eDate))
	{

	$sel = $wpdb->get_results($wpdb->prepare("SELECT * FROM ".$wpdb->prefix."adstats where campaign_id=%d and date >= %s and date <= %s order by date ASC",$campaignId,$sDate,$eDate));

	}	
	else
	{
		$sel = $wpdb->get_results($wpdb->prepare("SELECT * FROM ".$wpdb->prefix."adstats where campaign_id=%d order by date ASC",$campaignId));
	}
	$new=array();
	$unique_array=array();

	$new[0]['date']='';
	$new[0]['count']=0;
	$new[0]['impressions']=0;
	
	if( !empty($sel[0]->date) ){
		$unique_array[0]=$sel[0]->date;	
	}
	
	$k=0;
	for($i=0;$i<count($sel);$i++)
	{
		if (!(in_array($sel[$i]->date,$unique_array)))
		{
		 $k++;
		 $unique_array[$k]=$sel[$i]->date;
		}
		
	}

	/**   Final Array For Count And Impression  **/	
	
	for($i=0;$i<count($unique_array);$i++)
	{

	for($j=0;$j<(count($sel));$j++)
		{
		
			if($sel[$j]->date==$unique_array[$i])
			{
			$new[$i]['date']=$unique_array[$i];
			$new[$i]['count']=$new[$i]['count']+$sel[$j]->clicks;
			$new[$i]['impressions']=$new[$i]['impressions']+$sel[$j]->impressions;
			}
		}
	}
	
	return $new;	
	
			
}

/////FUNCTIONS FOR BANNER

function wpadl_limitBanner(){
	
	global $wpdb;

	$num = $wpdb->get_var('SELECT COUNT(*) from '.$wpdb->prefix.'banner');
	if($num >= 20 ){
		return 1;
	}
}

//Insertion of values in wp_banner ans wp_adv_banner table

function wpadl_addBanner($arr)
{ 
	global $wpdb;
	
	if( !empty( $arr['file']['url'] ) || !empty( $arr['banner_url'] ))
	{
		$url = !empty( $arr['file']['url'] ) ? $arr['file']['url'] : $arr['banner_url']; $sz = getimagesize( $url );$size = $sz['0'].'x'.$sz[1];
	}

	$wpdb->insert($wpdb->prefix.'banner',array('name' => $arr['name'],'url' => $arr['url'],'target' => $arr['target'],'file' => $arr['file']['url'],'ext_file' => $arr['banner_url'],'size' => $size,'html' => $arr['html'],'advertiser_id' => $arr['aid'],'campaign_id' => $arr['cid'],'adzone' => $arr['zones']),array('%s','%s','%s','%s','%s','%s','%s','%d','%d','%d'));
	$lastid = (int) $wpdb->insert_id;
	
	$wpdb->insert($wpdb->prefix.'adv_banner',array('advertiser_id'=> $_REQUEST['advertisersListing'],'campaign_id' => $_REQUEST['campaignsListing'],'banner_id' => $lastid,'adzone_id' => $_REQUEST['zones']),array('%d','%d','%d','%d'));
	$err = 0;
	return $err;
}


//Updation of values in wp_banner and wp_adv_banner table
function wpadl_updateBanner($arr)
{ 
 
	global $wpdb;

	if( empty( $arr['file']['url'] ) && empty( $arr['banner_url'] ) && empty( $arr['html'] ) )
	{
		$res = wpadl_totalBanner($arr['id']);
		$arr['file']['url'] = $res[0]->file;$arr['banner_url']  = $res[0]->ext_file;$arr['html']= $res[0]->html;
	}
	
	if( !empty( $arr['file']['url'] ) || !empty( $arr['banner_url'] ))
	{
		$url = !empty( $arr['file']['url'] ) ? $arr['file']['url'] : $arr['banner_url'];	$sz = getimagesize( $url );	$size = $sz['0'].'x'.$sz[1];
	}
	
	$wpdb->update($wpdb->prefix.'banner',array('name' => $arr['name'],'url' => $arr['url'],'target' => $arr['target'],'file' => $arr['file']['url'],'ext_file' => $arr['banner_url'], 'size' => $size,'html' => $arr['html'], 'adzone' => $arr['zones']),array('id' => $arr['id']));
	
	$wpdb->update($wpdb->prefix.'adv_banner',array('adzone_id' => $_REQUEST['zonesUpd']),array('banner_id' => $_REQUEST['id']),array('%d','%d'));		
	
}


function wpadl_selBanner($id)
{
	global $wpdb;

	$val = $wpdb->get_results($wpdb->prepare('SELECT ban.*, advban.adzone_id FROM '.$wpdb->prefix.'banner ban,'.$wpdb->prefix.'adv_banner advban WHERE advban.banner_id = 
	ban.id AND advban.adzone_id = %d ORDER BY ban.id DESC',$id));
	
	return $val;
}


function wpadl_totalBanner($id)
{
	global $wpdb;
	$id = intval($id);
	$total = $wpdb->get_results($wpdb->prepare('SELECT * FROM '.$wpdb->prefix.'banner WHERE id= %d LIMIT 1',$id));

    return $total;
}

/*	Function to Display All banners - Used on banners page
*	Added By kaustubh	
*/

function wpadl_displayAll_Banners(){	
	global $wpdb;

	$All_banners = $wpdb->get_results('SELECT * FROM '.$wpdb->prefix.'banner ORDER BY id DESC');

    return $All_banners;
}

function wpadl_showBanner( $url, $link = '', $target = '_blank', $id = '' )
{
	
	global $wpdb, $pluginUrl;
	
	if( !empty( $id ))
	{
		$banner = wpadl_totalBanner($id);
	}
	else{

		$banner = $wpdb->get_results('Select * from '.$wpdb->prefix.'banner');
	}
		
	$path_info = pathinfo( $url );

	if( $path_info['extension'] == 'swf' )
	{
		if( !empty( $banner[0]->size ))
		{
			$size = explode('x', $banner[0]->size);
		}
		else
		{
			$size = getimagesize( $url );
		}
		
		$res.= '<object width="'.$size[0].'" max-height="'.$size[1].'" style = "height: 100%;" >';
		$res.= '<param value="'.$url.'"></param>';
		$res.= '<param value="true"></param>';
		$res.= '<param value="always"></param>';
		$res.= '<param  value="transparent"></param>';
		$res.='<embed src="'.$url.'" type="application/x-shockwave-flash" width="'.$size[0].'" height="'.$size[1].'" allowscriptaccess="always" allowfullscreen="true" style = "height: 100%; max-width:100%;" >
		</embed></object>';
	}
	else
	{	
    	$res = '<img src="'.$url.'" alt="'.$banner[0]->name.'" style = "height:auto; max-width: 100%;" />'; // height: auto for responsiveness
    }
	
	if( !empty( $link ) )
	{	
		$res = '<a href="'.get_bloginfo('url').'?id='.$id.'&aid='.$banner[0]->advertiser_id.'&cid='.$banner[0]->campaign_id.'&move_to='.$link.'" target="'.$target.'" >'.$res.'</a>';
	}
	
	return $res;	
}

function wpadl_showSignUpBanner($link,$ht,$default_banner)
{
    $ht1 = $ht/2;
	global $wpdb, $pluginUrl;?>
    
	<script type="text/javascript">
		jQuery(document).ready(function(){
			
			// For vertical height
			var containerHeight = jQuery("#container1").height();
			var contentHeight 	= jQuery("#container1 .content1").height();
			var h = (containerHeight - contentHeight)/2;
			/* Commented by Prasada - As padding-top was getting applied for default image which was not getting displayed properly */
			//jQuery("#container1 .content1").css("padding-top", <?php echo $ht1;?>);
		});
	</script><?php
	echo '<style type="text/css">*{margin:0; padding:0;color:#000000;}#container1{text-align:center;}</style>';
	if($default_banner != NULL)
		$res = '<a href="'.$link.'" target="_blank" style=" text-decoration:none;"><div id="container1"><div class="content1"><img src="'.$default_banner.'" style = "height: 100%; max-width: 100%;" /></div></div></a>';
	else 
		$res = '<a href="'.$link.'" target="_blank" style=" text-decoration:none;"><div id="container1"><div class="content1">Advertise Here</div></div></a>';
	return $res;		
}

function wpadl_chkBannerType( $type )
{
	if( !empty( $type->file ))
	{
		$arr = array('file' => $type->file,'type' => 'file');
	}
	elseif( !empty( $type->ext_file ))
	{
		$arr = array('file' => $type->ext_file,'type' => 'ext_file');
	}
	elseif( !empty( $type->html ))
	{
		$arr = array('file' => $type->html,'type' => 'html');
	}
	
	return $arr;
}


function wpadl_showBannerToolTip( $url, $id, $link = '', $target = '_blank' )
{
	global $wpdb, $pluginUrl;
	
	if( !empty($id))
	{	
		$banner = wpadl_totalBanner($id->id);
	}
	
	$path_info = pathinfo($url);
	if( $path_info['extension'] == 'swf' )
	{
		if( !empty( $banner[0]->size ))
		{
			$size = explode('x', $banner[0]->size);
		}
		else
		{
			$size = getimagesize( $url );
		}
				
		$res.= '<object width="'.$size[0].'" height="'.$size[1].'">';
		$res.= '<param value="'.$url.'"></param>';
		$res.= '<param value="true"></param>';
		$res.= '<param value="always"></param>';
		$res.= '<param  value="transparent"></param>';
		$res.='<embed src="'.$url.'" type="application/x-shockwave-flash" width="'.$size[0].'" height="'.$size[1].'" allowscriptaccess="always" allowfullscreen="true">
		</embed></object>';
	}
	else
	{
    	$res = '<img src="'.$url.'" alt="'.$banner[0]->name.'" />';
    }
	
	if($link!="")
	{
		$res = '<a href="'.get_bloginfo('url').'?id='.$id.'&aid='.$banner[0]->advertiser_id.'&cid='.$banner[0]->campaign_id.'&move_to='.$link.'" target="'.$target.'">'.$res.'</a>';
	}
	
	return $res;	
}


/////FUNCTIONS FOR AD ZONES

function wpadl_addChkZones($arr)
{  	
	global $wpdb;
	$url = '';

	if( !empty( $arr['default_banner']['url'] ))
	{
		$url = $arr['default_banner']['url'] ; 
		$sz = getimagesize( $url );
		$size = $sz['0'].'x'.$sz[1];
	}
	
	$check = $wpdb->get_var($wpdb->prepare('SELECT COUNT(*) FROM '.$wpdb->prefix.'adzone WHERE name = %s',$arr['name']));

	if( !$check )
	{
		if($arr['size'] == 'custom')
		{
			$size = $arr['custwdth'].'x'.$arr['custhght'];
			$custom = 1;
		}
		else {$size = $arr['size']; $custom = 0;}
		if($arr['showadvert']=='on') $advert = 1; else $advert = 0;
        
         $wpdb->insert($wpdb->prefix.'adzone',array(
        	'name' => $arr['name'],
        	'size' => $size,
        	'description' => $arr['desc'],
        	'showsignuplink' => $advert,
        	'signuplink' => $arr['signupurl'],
        	'default_banner' => $url
        	),
        	array('%s','%s','%s','%d','%s','%s')
        );
		$err = 0;
	}
	else
	{
		$err = 1;
	}
	return $err;
}




function wpadl_updChkZones($arr)
{ 
	global $wpdb;
	$url = '';
	$updcheck = $wpdb->get_results($wpdb->prepare('SELECT * FROM '.$wpdb->prefix.'adzone WHERE name!= %s',sanitize_text_field(esc_attr($_REQUEST['zname']) ) ));

	if( !empty( $arr['default_bannerUpd']['url'] ))
	{
		$url = $arr['default_bannerUpd']['url'] ;
		$sz = getimagesize( $url );
		$size = $sz['0'].'x'.$sz[1];
	}
	
	$arrname = array();

	for($i=0;$i<count($updcheck);$i++)
	{
		$arrname[] = stripslashes($updcheck[$i]->name);
	}
	$name = sanitize_text_field(esc_attr($_REQUEST['zoneNameUpd']));
	if(in_array($name, $arrname))
	{ 
		$err = 1;
	}
	else
	{
	
		if($arr['size'] == 'custom')
		{
		$size = $arr['custwdth'].'x'.$arr['custhght'];
		$custom = 1;
		}
		else {$size = $arr['size']; $custom = 0;}
		if($arr['showadvert']=='on') $advert = 1; else $advert = 0;
	    $wpdb->update($wpdb->prefix .'adzone',array('name' => $arr['name'],'size' => $size,'description' => $arr['desc'],'showsignuplink' => $advert,'signuplink' => $arr['signupurl'],'default_banner' => $url),array('id' => $arr['id']));
		$err = 0;
	}
	
	return $err;
}

function wpadl_totalZones($orderby = '')
{ 
	global $wpdb;
	$totalZones = $wpdb->get_results('SELECT * FROM '.$wpdb->prefix.'adzone '.$orderby);

	return $totalZones;
}



function wpadl_totalZonesWithPrice()
{ 
	global $wpdb;
	$totalZonesPrice = $wpdb->get_results('SELECT * FROM '.$wpdb->prefix.'adzone ORDER BY name ASC');

	return $totalZonesPrice;
}


function wpadl_updZones($id)
{ 
	global $wpdb;
	$rec = $wpdb->get_results($wpdb->prepare('SELECT * FROM '.$wpdb->prefix.'adzone WHERE id = %d',$id));
    return $rec;
}


/////FUNCTIONS FOR PACKAGES

function wpadl_addPackages($arr)						//Function for Inserting Package record
{  
	global $wpdb;
	if($arr['monthcost']!="") $dur = $arr['duration'];
	else $dur = '';
		
	$ins = $wpdb->insert($wpdb->prefix .'adpackage',array('name' => $arr['name'],'adzone_id' => $arr['adzone_id'], 'description' => $arr['desc'],'m_cost' => $arr['monthcost'],'duration' => $dur,'i_cost' => $arr['impcost'],'impressions' => $arr['impression']));
		
	return $ins;
}


function wpadl_updPackages($arr)				//Function for updating packages
{ 
	global $wpdb;
	if($arr['monthcost']!="") $dur = $arr['duration'];
	else $dur = '';

	$upd =  $wpdb->update($wpdb->prefix .'adpackage',array(
		'name' => $arr['name'],
		'adzone_id' => $arr['adzone_id'],
		'description' => $arr['desc'],
		'm_cost' => $arr['monthcost'],
		'duration' => $dur,
		'i_cost' => $arr['impcost'],
		'impressions' => $arr['impression']
		),
		array('id' => $arr['id'])
	);
	
	return $upd;
}

function wpadl_totalPackages($orderby = '')
{ 
	global $wpdb;
	$totalPackages = $wpdb->get_results('SELECT * FROM '.$wpdb->prefix.'adpackage '.$orderby);

	return $totalPackages;
}

function wpadl_updPackage($id)					//Function for gathering information of a particular record from package table
{ 
	
	global $wpdb;
	$rec = $wpdb->get_results($wpdb->prepare("SELECT * FROM ".$wpdb->prefix."adpackage WHERE id = %d",$id));
    return $rec;
}


//  FUNCTIONS FOR STATISTICS
function wpadl_totalStats_fromRedirect( $Ad_id, $Camp_ID, $Banner_id, $date )    //For number of stats record based on Query
{
	global $wpdb;
	$record = $wpdb->get_results($wpdb->prepare('SELECT * FROM ' . $wpdb->prefix .'adstats WHERE advertiser_id = %d AND campaign_id = %d AND banner_id = %d AND date = %s LIMIT 1',$Ad_id, $Camp_ID, $Banner_id, $date));
	return $record;
}

function wpadl_totalStats_fromImpressions( $ad_adId, $camp_id, $ad_id, $date)    //For number of stats record based on Query
{
	global $wpdb;
	$record = $wpdb->get_results($wpdb->prepare('SELECT * FROM '. $wpdb->prefix .'adstats WHERE advertiser_id = %d AND campaign_id = %d AND banner_id = %d AND date = %s LIMIT 1',$ad_adId, $camp_id, $ad_id, $date ));
	return $record;
}

function wpadl_Impression( $advertise )			//FUNCTION FOR INSERTION OF IMPRESSION IF NOT EXIST AND UPDATE IF EXISTS
{
		/*	First checks for bots.
		*	If not then Impression Count is incremented.
		*/ 
		require_once ( WP_ADCENTER_ADMIN_DIR.'partials/check_bots.php');

		if( !wpadl_check_bot() ){	

			global $wpdb;
			$date=date('Y-m-d');	
			if(isset($advertise))
				$totalstats = wpadl_totalStats_fromImpressions($advertise->advertiser_id,$advertise->campaign_id,$advertise->id,$date);
			if(isset($totalstats))
			if( count( $totalstats ))
			{ 
				$impression_count = $wpdb->get_results($wpdb->prepare("SELECT impressions FROM " . $wpdb->prefix ."adstats WHERE id = %d",$totalstats[0]->id));

				if($impression_count[0]->impressions < 10000){

					$wpdb->query("UPDATE " . $wpdb->prefix . "adstats SET impressions = impressions+1  WHERE id = '".$totalstats[0]->id."'");
					//$wpdb->update($wpdb->prefix . "adstats",array('impressions' => COUNT('impressions') + 1 ),array('id' => $totalstats[0]->id));
				}
			}
			else
			{
				if($advertise)
				{
					$wpdb->insert($wpdb->prefix .'adstats', array(
								'advertiser_id' => $advertise->advertiser_id,
								'campaign_id' => $advertise->campaign_id,
								'banner_id' => $advertise->id,
								'date' => current_time( 'Y-m-d' ),
								'impressions' => 1,
								'clicks' => 0
								)
							);
				}
			}
		}
}


/*
 * CHECK FOR FINISHED CAMPAIGNS
*/
function wpadl_checkFinished()
{	
	global $wpdb;
	$camp = wpadl_getCampaign( "ORDER BY id DESC" );
	
	for( $i = 0; $i < count($camp); $i++ )
	{
		$status = wpadl_campaignStatus($camp[$i]->status,$camp[$i]->start_date,$camp[$i]->end_date);

		if($status==0 )
		{	
			// Update campaign
			$wpdb->update($wpdb->prefix.'campaign',array('status' => $status),array('id' => $camp[$i]->id) );
		}
	}
}


//FUNCTION FOR SHORTCODE IN THEME

function wpadl_getPrice($id)   //For Fetching Information From wp_package table
{
	global $wpdb;
	$val = $wpdb->get_results($wpdb->prepare("SELECT id,name,description,m_cost,duration,i_cost,impressions from ".$wpdb->prefix."adpackage where adzone_id= %d",$id));
	return $val;
}

function wpadl_getSelectedZones($id)  //For fetching information from wp_adzone table based on id	//added
{
	global $wpdb;
	$value = $wpdb->get_results($wpdb->prepare("SELECT * from ".$wpdb->prefix."adzone where id= %d",$id));
	
	return $value;
}


// FUNCTION FOR GETTING ID OF LAST CREATED USER

function wpadl_getNewUserCreated()
{
	global $wpdb;
	$id = $wpdb->get_var("SELECT ID FROM ".$wpdb->prefix."users order by ID DESC");
	
	return  $id;

}

function wpadl_impressionEndDate()    //FUNCTION FOR FINDING THE END DATE OF BANNER ON THE BASIS OF IMPRESSION
{	
	global $wpdb;
	$total = $wpdb->get_results('SELECT * FROM '. $wpdb->prefix . 'campaign where end_date="0000-00-00"');
		
	for($i=0;$i<count($total);$i++)
	{
		$userzone = $wpdb->get_results($wpdb->prepare('SELECT * FROM '. $wpdb->prefix . 'aduserzones where user_id = %d',$total[$i]->user_id));
		if(isset($userzone[0]))
		$pack = $wpdb->get_results($wpdb->prepare('SELECT * FROM '. $wpdb->prefix . 'adpackage where id = %d',$userzone[0]->package_id));
		$stats = $wpdb->get_results($wpdb->prepare('SELECT * FROM '. $wpdb->prefix . 'adstats where campaign_id = %d',$total[$i]->id));
		if(isset($pack[0]->impressions))
		{
			
			if($pack[0]->impressions<=($stats[0]->impressions))
			{	
				$wpdb->update($wpdb->prefix . 'campaign',array('status' => '0'),array('id' => $stats[0]->campaign_id));
			}
		}
	
	}
}

function wpadl_statsAdvertiserName($id)
{
	global $wpdb;
	$name = $wpdb->get_results('SELECT name FROM '. $wpdb->prefix . 'advertiser where id=(SELECT advertiser_id from '. $wpdb->prefix . 'campaign where id="'.$id.'" )');
	return $name;
	
}


function wpadl_statsCampaignName($id){

	global $wpdb;
	$name = $wpdb->get_results($wpdb->prepare('SELECT name FROM '. $wpdb->prefix . 'campaign where id= %d',$id));
	return $name;

}


function wpadl_userAdvertiserName()				  //Function for gathering advertiser name from advertiser table
{ 
	global $wpdb;
	$rec = $wpdb->get_results("SELECT name FROM ".$wpdb->prefix."advertiser");
	
	for($j=0;$j<count($rec);$j++)
	{
		$name[] = $rec[$j]->name;
	
	}
    return $name;
}
/*	Function to get Advertiser name, ID for Current Campaign
*	Adds campaign to selected Advertiser
*	Now Advertiser can see stats for all its Campaigns
*	- Added By Kaustubh
*/
function wpadl_checkAdvertiser($advertiser_Id,$campaignName){
	
	global $wpdb;

	$advertiser_name = $wpdb->get_results($wpdb->prepare("SELECT name FROM ".$wpdb->prefix."advertiser WHERE id = %d",$advertiser_Id));
	
	if( !empty($advertiser_name[0]->name) ){
	
		$userName = $wpdb->get_results($wpdb->prepare("SELECT ID,user_login FROM ".$wpdb->prefix."users WHERE user_login = %s",$advertiser_name[0]->name));
	
		/*	If Advertiser name is found in wp_users table then only 
		*	update campaign table user_id with that wp_users id
		*/

		if( !empty($userName) ){
			//$res1 = $wpdb->query("UPDATE ".$wpdb->prefix. "campaign SET user_id = ".$userName[0]->ID." where name = '".$campaignName."' ");
			$res1 = $wpdb->update($wpdb->prefix. "campaign",array('user_id' => $userName[0]->ID),array('name' =>$campaignName));		}
	}
}

?>
