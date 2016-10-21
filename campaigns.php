<style type="text/css">#ui-datepicker-div { display: none}</style>
<div class="wpa-section wpa-shadow wpa-spacing-top">

	<div class="wpa-logo-section clearfix">
		<span class="left"><img src="<?php echo plugins_url('images/logo.gif',__FILE__);?>" width="203" height="58" alt="wp adcenter" /></span>
		<h2>Campaign</h2>
	</div>
	<?php if(!isset($_REQUEST['mode']) ||  $_REQUEST['mode']=="") {?>
	<div class="wpa-section clearfix">
		<h1 class="clearfix">
			<span class="close-icon" id="minus-btn"><span class="heading" style="padding-left:35px;">Add a Campaign</span></span>
		</h1>
		
		<form class="setting-section" name="addCampaign" id="addCampaign" method="post" action="<?php echo !empty($action_url) ? $action_url : "" ?>">
			<div class="advertisement-form">
                <div class="row1">
                    <div class="col1">Campaign Name</div>
                    <div class="col2">
                        <input type="text" class="textbox" name="campaignName" id="campaignName" />
                    </div>
                    <div class="clr"></div>
                </div>
			
                <div class="row1">
                    <div class="col1">Advertiser</div>
                    <div class="col2">
					<?php $totadv = wpadl_totalAdvertiser("ORDER BY name ASC");
					    if(isset($_REQUEST['aid']))
						{
							$selectedAdv = selAdvertiser(intval($_REQUEST['aid']));

						}?>
                        <select id="advertiserList" name="advertiserList">
						<?php for($i=0;$i<count($totadv);$i++){?>
                        	<option value="<?php echo isset($totadv[$i])?$totadv[$i]->id:'';?>" <?php if(isset($totadv[$i]) && isset($selectedAdv[0]) ) if($totadv[$i]->id==$selectedAdv[0]->id) {?> selected="selected"<?php }?>><?php echo !empty($totadv[$i])?$totadv[$i]->name:'';?></option>
							<?php }?>
                        </select>
                    </div>
                    <div class="clr"></div>
                </div>
                <div class="clr"></div>
			</div>

            <div class="advertisement-form">
                <div class="row1">
                    <div class="col1">Starting Date</div>
                    <div class="col2">
                        <input type="text" class="textbox" name="campaignStartDate" id="campaignStartDate" />
                    </div>
                    <div class="clr"></div>
                </div>
			
                <div class="row1">
                    <div class="col1">End Date</div>
                    <div class="col2">
                        <input type="text" class="textbox" name="campaignEndDate" id="campaignEndDate" />
                    </div>
                    <div class="clr"></div>
                </div>
                <div class="clr"></div>
	</div>
			<input type="submit" name="SUBMIT" value="SAVE CAMPAIGNS" class="btn-bg2"/>
			<input type="hidden" name="add" value="1" />	

		</form>
        
	</div>
	 <div id="loader"></div><div id="deleted" style="color:red"><p><b></b></p></div>
   <div class="wpa-section clearfix">
    <h1 class="clearfix">
        <span class="open-icon" id="minus-btn1"><span class="heading" style="padding-left:35px;">Running Campaign</span></span>
       
    </h1>
	<?php $statusCamp = wpadl_chkStatus(1);
	if(count($statusCamp)>0){?>
 
	<table cellpadding="0" cellspacing="0" border="0" id="runningCampaign" width="100%" style="display:none;">
    	<thead> 
        <tr>
          <form action="admin.php?page=campaigns" method="post"> 
	    <th  style="background-color:#FFFFFF" width="458">Campaign Expires in <input id="expindays" value="" type="text" name="expindays"> Days</th>
	    <th  style="background-color:#FFFFFF" ><input class="btn-bg2" type="submit" value="Fetch" name="SUBMIT"></th>
	  </form>

    <form action="admin.php?page=campaigns" method="post"> 
	  <th  style="background-color:#FFFFFF" ><input class="btn-bg2" type="submit" value="Show All Campaigns" name="SUBMIT"></th>
    </form>
  </tr>  
    	
            <tr>
    		<th width="458">Campaign</th>
    		<th width="458">Start Date</th>
    		<th width="458">End Date</th>
    		<th width="458">Expires in Days</th>
                <th width="138">Add a Banner</th>
                <th width="119">Pause</th>
        	<th width="124">Delete </th>
          </tr>  
 
        </thead>
      <tbody>
  
	<?php
           for($i=0;$i<count($statusCamp);$i++) {
	        $now = strtotime($statusCamp[$i]->start_date);
            $your_date = strtotime($statusCamp[$i]->end_date);
            $datediff = $your_date -$now;
            $duration = floor($datediff/(60*60*24));
            $expindays_var = '';
            isset($_POST['expindays']) ? $expindays_var = $_POST['expindays'] : '';
            if ($duration == $expindays_var || empty($expindays_var) ){
        ?>
        	 <tr id="delruncamp_<?php echo $i?>">
        		<td><a href="?page=campaigns&mode=edit&id=<?php echo $statusCamp[$i]->id;?>&cname=<?php echo $statusCamp[$i]->name;?>" style="text-decoration:none;"><?php echo $statusCamp[$i]->name;?></a>
                    <?php
                        $impression_count_limit = $wpdb->get_results($wpdb->prepare('SELECT impressions FROM '. $wpdb->prefix .'adstats WHERE campaign_id = %d',$statusCamp[$i]->id));
                        if( !empty($impression_count_limit[0]->impressions) && $impression_count_limit[0]->impressions > 10000){
                            ?>
                                <div class="impression-alert"></div>
                                <div id ="hover-message">
                                    This Campaign has exceeded the count of Impressions available in Lite version.<br>Please Upgrade to Pro Version.
                                </div>
                            <?php
                        }
                    ?>
                </td>
	            <td><?php echo $statusCamp[$i]->start_date;?></td>	
	            <td><?php echo $statusCamp[$i]->end_date;?></td>
	            <td><?php echo $duration ?></td>
                <td>
			<a href="?page=banners&advid=<?php echo $statusCamp[$i]->advertiser_id;?>" style="text-decoration:none;"><input type="button" name="add" value="" class="addbttn button1" /></a>
                	
                </td>
                <td>
                	<a onclick="alert('Feature available in Pro Version !');" style="text-decoration:none;"><input type="button" name="add" value="" class="pausebttn button1" /></a>
                </td>
                <td>
			<a onClick="wpadl_Delete(<?php echo $statusCamp[$i]->id;?>,'delcamp','delruncamp_<?php echo $i?>')" style="text-decoration:none;"><input type="button" name="delete" class="deletebttn button1" /></a>
                	
                </td>	
        	</tr>
           <?php } }?> 
        </tbody>
    </table>
	<?php } else {?>
	<table cellpadding="0" cellspacing="0" border="0" id="runningCampaign" width="100%"  style="display:none;">
    	<thead> 
            <tr>
    			<th>No Running Campaigns</th>
          </tr>
        </thead>
       
    </table>
	<?php }?>
  </div>
  <div class="wpa-section clearfix">
    <h1 class="clearfix">
        <span class="open-icon" id="minus-btn2"><span class="heading" style="padding-left:35px;">Paused Campaign</span></span>
    </h1>
	<div cellpadding="0" cellspacing="0" border="0" id="pausedCampaign"  style="display:none;">
    	<p><i>Please Upgrade to Pro Version to avail this Feature </i></p>
    </div>
  </div>    
    
<div class="wpa-section clearfix">
    <h1 class="clearfix">
		 <span class="open-icon" id="minus-btn3"><span class="heading" style="padding-left:35px;">Finished Campaign</span></span>
        
    </h1>
	<?php $statusCamp = wpadl_chkStatus(0);
	if(count($statusCamp)>0){?>
	<table cellpadding="0" cellspacing="0" border="0" id="finishedCampaign" style="display:none;">
    	<thead> 
            <tr>
    			<th width="930">Campaign</th>
          		<th width="118">Delete </th>
          </tr>
        </thead>
        <tbody>
		<?php for($i=0;$i<count($statusCamp);$i++) {?>
        	<tr id="delfincamp_<?php echo $i?>">
        		<td><a style="text-decoration:none;"><?php echo $statusCamp[$i]->name;?></a></td>
            	
                <td>
                	<a onClick="wpadl_Delete(<?php echo $statusCamp[$i]->id;?>,'delcamp','delfincamp_<?php echo $i?>')" style="text-decoration:none;"><input type="button" name="delete" class="deletebttn button1" /></a>
                </td>	
        	</tr>
            <?php }?>
        </tbody>
    </table>
	<?php } else {?>
	<table cellpadding="0" cellspacing="0" border="0" id="finishedCampaign"  style="display:none;">
    	<thead>
            <tr>
    			<th>No Finished Campaigns</th>
          </tr>
        </thead>
       
    </table>
	<?php }?>
  </div>    

	<?php }  else {
		$campaignRec = isset($_REQUEST['id'])? wpadl_updCampaign(intval($_REQUEST['id'])):'';
		$advertiserName = isset($_REQUEST['cname'])? wpadl_getAdvertiser(sanitize_text_field(esc_attr($_REQUEST['cname']))):'';
	 ?>
	<div class="wpa-section clearfix">
		<h1 class="clearfix">
			<span class="close-icon" id="minus-btn4"><span class="heading" style="padding-left:35px;">Edit Campaign</span></span>
			
		</h1>
		
		<form class="setting-section" name="editCampaign" id="editCampaign" method="post" action="<?php echo !empty($action_url)?$action_url:'' ?>">
			<div class="advertisement-form">
                <div class="row1">
                    <div class="col1">Campaign Name</div>
                    <div class="col2">
                        <input type="text" class="textbox" name="campaignNameUpd" id="campaignNameUpd" value="<?php echo !empty($campaignRec[0])?$campaignRec[0]->name:'';?>" />
                    </div>
                    <div class="clr"></div>
                </div>
			
                <div class="clr"></div>
			</div>
            <div class="advertisement-form">
                <div class="row1">
                    <div class="col1">Starting Date</div>
                    <div class="col2">
					<?php
						$sdate = date('d-m-Y', strtotime($campaignRec[0]->start_date));
						if($campaignRec[0]->end_date=='0000-00-00'){$edate='';}
						else {$edate = date('d-m-Y', strtotime($campaignRec[0]->end_date));}
					?>
                        <input type="text" class="textbox" name="campaignStartDateUpd" id="campaignStartDateUpd" value="<?php echo $sdate;?>"  />
                    </div>
                    <div class="clr"></div>
                </div>
			
                <div class="row1">
                    <div class="col1">End Date</div>
                    <div class="col2">
                        <input type="text" class="textbox" name="campaignEndDateUpd" id="campaignEndDateUpd" value="<?php echo $edate;?>"  />
                    </div>
                    <div class="clr"></div>
                </div>
                <div class="clr"></div>
			</div>
   
			<input type="submit" name="SUBMIT" value="UPDATE" class="btn-bg2"/>
			<input type="hidden" name="edit" value="1" />
		</form>
	</div>
<?php }?>
   

<script type="text/javascript">
jQuery(".open-icon, .close-icon").click(function(){
              
    if(jQuery(this).hasClass("open-icon"))
    {
     jQuery(this).removeClass("open-icon");
     jQuery(this).toggleClass("close-icon").next().slideToggle("fast")
    }
    else
    {
     jQuery(this).removeClass("close-icon");
     jQuery(this).toggleClass("open-icon").next().slideToggle("fast")
    }         
 });
 
jQuery('#minus-btn').click(function(){
	jQuery('#addCampaign').slideToggle('fast');
});
jQuery('#minus-btn1').click(function(){
	jQuery('#runningCampaign').slideToggle('fast');
});
jQuery('#minus-btn2').click(function(){
	jQuery('#pausedCampaign').slideToggle('fast');
});
jQuery('#minus-btn3').click(function(){
	jQuery('#finishedCampaign').slideToggle('fast');
});

jQuery('#minus-btn4').click(function(){
	jQuery('#editCampaign').slideToggle();
});


jQuery('.linked_b').click(function(){
	var lb = jQuery('#' + this.id).attr('lbanner');
	jQuery('#linked_banners_' + lb).slideToggle();
});

jQuery('.linked_c').click(function(){
	var lb = jQuery('#' + this.id).attr('lcode');
	jQuery('#linked_code_' + lb).slideToggle();
});



</script>