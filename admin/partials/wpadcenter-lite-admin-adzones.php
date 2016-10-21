<div class="wpa-section wpa-shadow wpa-spacing-top">

	<div class="wpa-logo-section clearfix">
		<span class="left"><img src="<?php echo plugins_url('images/logo.gif',__FILE__);?>" width="203" height="58" alt="wp adcenter" /></span>
		<h2>Adzones</h2>
	</div>

	<?php if(!isset($_REQUEST['mode']) || $_REQUEST['mode']=="") {?>
	<div class="wpa-section clearfix">
		<h1 class="clearfix">
			<span class="close-icon" id="minus-btn"><span class="heading">Add an Ad Zone</span></span>
		</h1>
		
		<form class="setting-section" name="addZones" id="addZones" enctype="multipart/form-data" method="post">
			<div class="advertisement-form">
                <div class="row1">
                    <div class="col1">Zone Name</div>
                   <div class="col2">
                        <input type="text" class="textbox" name="zoneName" id="zoneName" />
                    </div>
                    <div class="clr"></div>
                </div>
			
                <div class="row1">
                    <div class="col1">Banner Size</div>
                    <div class="col2">
                        <select name="BannerSize" id="BannerSize" style="width:200px;">
                                    
                                        <option value="468x60">
                                        	IAB Full Banner (468 x 60)
                                        </option>
                                        <option value="728x90" >
                                        	IAB Leaderboard (728 x 90)
                                        </option>
                                        <option value="300x250">
                                        	IAB Medium Rectangle (300 x 250)
                                        </option>
                                        <option value="120x90" >
                                        	IAB Button 1 (120 x 90)
                                        </option>
                                        <option value="120x60" >
                                        	IAB Button 2 (120 x 60)
                                        </option>
                                        <option value="125x125">
                                        	IAB Square Button (125 x 125)
                                        </option>
                                        <option value="180x150">
                                        	IAB Rectangle (180 x 150)
                                        </option>
                               </select><br /><br />
				</div>
                    <div class="clr"></div>
                </div>
                <div class="clr"></div>
			</div>
            <div class="advertisement-form">
                <div class="row1" style="width: 700px;">
                    <div class="col1">Zone Description</div>
                    <div class="col2" style="width: 417px;">
                        <textarea class="textbox" rows="4" name="zoneDesc" id="zoneDesc"></textarea>
                        <span class="desc_text" style="font-size: 11px; padding-left: 25px; vertical-align: top;">
                            Describe the Ad Zone for advertiser
                        </span>
                    </div>
                    <div class="clr"></div>
                </div>
                <div class="clr"></div>
			</div>
              
            <div class="wpa-section clearfix">
                    <h1 class="clearfix">
                        <span class="open-icon" id="minus-btn1"><span class="heading">Multiple Banners</span></span>         
                    </h1>
                    <div class="advertisement-form" id="multipleBanner" style="display:none;">    
                        <p><i>Please Upgrade to Pro Version to avail this Feature </i></p>
                    </div>
            </div>
                       
            <div class="wpa-section clearfix">
                    <h1 class="clearfix">
                        <span class="open-icon" id="minus-btn3"><span class="heading">Extra Setting</span></span>            
                    </h1>
                    <div class="advertisement-form" id="extrasetting" style="display:none;">
                    <div class="row1">
                        <div class="col1">SignUp Page Link</div>
                        <div class="col2">
                            <input type="text" name="signup" id="signup" />
                        </div>
                        <div class="clr"></div>
                    </div>
                
                    <div class="row1">
                        <div class="col1">Enable Advertise Here</div>
                        <div class="col2">
                            <input type="checkbox" name="showadvert" id="showadvert"  style="margin:5px;"/>
                        </div>
                        <div class="clr"></div>
                    </div>

                    <div class="row1" style="width: 295px">
                        <div class="col1">Default Banner</div>
                        <div class="col2" style="width: 250px;">
                            <input type="file" name="default_banner" size="25" id="default_banner" />
                            <span style="font-size: 11px;">Formats expected : .gif .jpg .png .swf .bmp</span>
                            <span style="font-size: 11px;"><br>Note : Upload a default banner to display it in this AdZone instead of text message</span>
                        </div>
                        <div class="clr"></div>
                    </div>

                    <div class="clr"></div>
                </div>
            </div>            
		<input type="submit" name="SUBMIT" value="SAVE AD ZONE" class="btn-bg2"/>
		<input type="hidden" name="add" value="1" />
	    </form>
	        
	</div>
	
<div id="loader"></div><div id="deleted" style="color:red"><p><b></b></p></div>
	<div class="wpa-section clearfix">
	    <h1 class="clearfix">
		 <span class="open-icon" id="minus-btn2"><span class="heading">Current Ad Zones</span></span>        
    	    </h1>
	<?php $totalZones = wpadl_totalZones('ORDER BY name ASC');
	if(count($totalZones)>0){?>
	<table cellpadding="0" cellspacing="0" border="0" id="adzonesTable" style="display:none">
    	<thead> 
            <tr>
    		<th width="777">Ad Zone Name</th>
                <th width="130">Zone Code</th>
          	<th width="111">Size</th>
       	  	<th width="140">View Banner</th>
        	<th width="87">Delete </th>
          </tr>
        </thead>
        <tbody>
        	<?php 
		for($i=0;$i<count($totalZones);$i++) {
		?>
            <tr id="delzone_<?php echo $i?>">
        		<td><a href="?page=adzones&mode=edit&id=<?php echo $totalZones[$i]->id;?>&zname=<?php echo $totalZones[$i]->name;?>" style="text-decoration:none;"><?php echo $totalZones[$i]->name?></a></td>
                <td>
                    <a class="linked_c" id="linked_c_<?php echo $i; ?>"  lcode="<?php echo $i; ?>">
			<input type="button" name="view" id="viewlinked" value="" class="viewbttn button1" />
		    </a>
                </td>
                <td><?php echo $totalZones[$i]->size?></td>
            	<td>
			<a class="linked_b" id="linked_b_<?php echo $i; ?>"  lbanner="<?php echo $i; ?>">
			<input type="button" name="view" id="viewlinked" value="" class="viewbttn button1" />
			</a>
                </td>	
                <td>
			<a onClick="wpadl_Delete(<?php echo $totalZones[$i]->id;?>,'delzone','delzone_<?php echo $i?>')" style="text-decoration:none;"><input type="button" name="delete"class="deletebttn button1" /></a>
                </td>	
        	</tr>			
			<tr id="linked_banners_<?php echo $i; ?>"  style="display:none">
				<td colspan="5">
				 <?php
				 $banners = wpadl_selBanner($totalZones[$i]->id);
 				 for( $j = 0; $j < count( $banners ); $j++ )
					{
					$advertiser = wpadl_selAdvertiser($banners[$j]->advertiser_id);
                    $campaign   = wpadl_selectedCampaign( $banners[$j]->campaign_id ); ?>						   

			<div class="link" ><?php echo !empty($advertiser[0]->name); ?> <span class="txtOrange"> &raquo; </span> <?php echo $campaign[0]->name;?> <span 	
			class="txtOrange"> &raquo; </span> <?php echo $banners[$j]->name;?></div>

				<?php }?>
				</td>
			</tr>
			<tr id="linked_code_<?php echo $i; ?>"  style="display:none">
				<td colspan="5">
				<div title="<?php echo $totalZones[$i]->name?>">
                               <p>
                                    <strong>PHP Code for your Theme</strong>
                             	 <p style="font-size:13px; color:#333333">
                                  	To place this Ad Zone within your theme, paste the following code in any theme file:
                              </p>
                             <div>
                               	<textarea class="input" style="width:100%; height:50px; font-size:11px;"><?php echo htmlentities( "<?php if( function_exists( 'wpadl_displayAdzone' ) )    echo wpadl_displayAdzone( ".$totalZones[$i]->id." ); ?>" ); ?></textarea>
                                    </div>
                                </p>
                                <p>
                              <strong>Shortcode for Posts or Pages</strong>
                              <p style="font-size:13px; color:#333333">
                                    	To place this Ad Zone within a post, paste the following code in any post or page:
                              </p>
                                    <div><textarea class="input" style="width:100%; height:50px; font-size:11px;">[displayAdzone id="<?php echo $totalZones[$i]->id; ?>"]</textarea></div>

                            </div>
				</td>
			</tr>
			<?php }?>
        </tbody>
    </table>
	<?php  } else {?>
	<table cellpadding="0" cellspacing="0" border="0" id="adzonesTable"  style="display:none;">
    	<thead> 
            <tr>
    			<th>No Current AdZones</th>
          </tr>
        </thead>
       
    </table>
	<?php }?>
  </div>    
	<?php } else {
		
	if(isset($_REQUEST['id']))
	{
	$zonesRec =  wpadl_updZones(intval($_REQUEST['id'])) ;
	}
	else
	{
		$zonesRec="";
	}
	
	?>
	<div class="wpa-section clearfix">
		<h1 class="clearfix">
			<span class="close-icon" id="minus-btn"><span class="heading">Update Ad Zone</span></span>
		</h1>
		<form class="setting-section" name="updZones" id="updZones" enctype="multipart/form-data" method="post">
			<div class="advertisement-form">
                <div class="row1">
                   <div class="col1">Zone Name</div>
                   <div class="col2">
                        <input type="text" class="textbox" name="zoneNameUpd" id="zoneNameUpd" value="<?php echo  !empty($zonesRec[0])?$zonesRec[0]->name:"";?>"/>
                    </div>
                    <div class="clr"></div>
                </div>
			
                <div class="row1">
                    <div class="col1">Banner Size</div>
                    <div class="col2">
                        <select name="BannerSizeUpd" id="BannerSizeUpd" style="width:200px;">
                                    
                                        <option value="468x60" <?php if(isset($zonesRec[0]) && $zonesRec[0]->size=='468x60') {?> selected="selected"<?php }?>>
                                        	IAB Full Banner (468 x 60)
                                        </option>
                                        <option value="728x90" <?php if(isset($zonesRec[0]) && $zonesRec[0]->size=='728x90') {?> selected="selected"<?php }?>>
                                        	IAB Leaderboard (728 x 90)
                                        </option>
                                        <option value="300x250" <?php if(isset($zonesRec[0]) && $zonesRec[0]->size=='300x250') {?> selected="selected"<?php }?>>
                                        	IAB Medium Rectangle (300 x 250)
                                        </option>
                                        <option value="120x90" <?php if(isset($zonesRec[0]) && $zonesRec[0]->size=='120x90') {?> selected="selected"<?php }?>>
                                        	IAB Button 1 (120 x 90)
                                        </option>
                                        <option value="120x60" <?php if(isset($zonesRec[0]) && $zonesRec[0]->size=='120x60') {?> selected="selected"<?php }?>>
                                        	IAB Button 2 (120 x 60)
                                        </option>
                                        <option value="125x125" <?php if(isset($zonesRec[0]) && $zonesRec[0]->size=='125x125') {?> selected="selected"<?php }?>>
                                        	IAB Square Button (125 x 125)
                                        </option>
                                        <option value="180x150" <?php if(isset($zonesRec[0]) && $zonesRec[0]->size=='180x150') {?> selected="selected"<?php }?>>
                                        	IAB Rectangle (180 x 150)
                                        </option>
                              </select>
			<br /><br />
		<?php if(isset($zonesRec[0]) && $zonesRec[0]->custom=='1')
			{
			  $sze = explode('x',$zonesRec[0]->size);
			}
        ?>
                    </div>
                    <div class="clr"></div>
                </div>
                <div class="clr"></div>
	     </div>
            <div class="advertisement-form">
                <div class="row1" style="width: 700px;">
                    <div class="col1">Zone Description</div>
                    <div class="col2" style="width: 500px;">
                        <textarea class="textbox" rows="4" name="zoneDescUpd" id="zoneDescUpd"><?php echo !empty($zonesRec[0])? $zonesRec[0]->description:''?></textarea>
                        <span style="font-size: 11px; padding-left: 25px; vertical-align: top;">Describe the Ad Zone for advertiser</span>
                    </div>
                    <div class="clr"></div>
                </div>
                <div class="clr"></div>
			</div>                 
		
            <div class="wpa-section clearfix">
                    <h1 class="clearfix">
                        <span class="open-icon" id="minus-btn1"><span class="heading">Multiple Banners</span></span>
                    </h1>
                    <div class="advertisement-form" id="multipleBanner" style="display:none;">
                        <p><i>Please Upgrade to Pro Version to avail this Feature </i></p>
                    </div>
            </div>
            
            <div class="wpa-section clearfix">
                    <h1 class="clearfix">
                        <span class="open-icon" id="minus-btn3"><span class="heading">Extra Setting</span></span>
                    </h1>

                    <div class="advertisement-form" id="extrasetting" style="display:none;">
                    <div class="row1">
                        <div class="col1">SignUp Page Link</div>
                        <div class="col2">
                            <input type="text" name="signupUpd" id="signupUpd" value="<?php echo !empty($zonesRec[0])?$zonesRec[0]->signuplink:'';?>" />
                        </div>
                        <div class="clr"></div>
                    </div>
                
                    <div class="row1">
                        <div class="col1">Enable Advertise Here</div>
                        <div class="col2">
                            <input type="checkbox" name="showadvertUpd" id="showadvertUpd" <?php if(isset($zonesRec[0]) && $zonesRec[0]->showsignuplink=='1') {?> checked="checked"<?php }?> style="margin:5px;" />
                        </div>
                        <div class="clr"></div>
                    </div>
                   <div class="row1" style="width: 295px">
                        <div class="col1">Default Banner</div>
                        <div class="col2" style="width: 270px;">
                        <?php
                            if(!empty( $zonesRec[0]->default_banner )){
                                ?>
                                <div class="change-banner">
                                    <input type="button" id="upload-btn" value="Change Image" />
                                    <label id="default_bannerChange" style="font-weight: bold"> <?php echo basename($zonesRec[0]->default_banner); ?> </label>
                                    <input type="file" id="default_bannerUpd" name="default_bannerUpd" value="Upload" style="display:none;"/>
                                </div>
                                <script type="text/javascript">
                                    jQuery(document).ready(function(){
                                        jQuery('#upload-btn').click(function(){
                                            jQuery('#default_bannerUpd').click();
                                        });
                                        jQuery('#default_bannerUpd').change(function(){
                                            var newFile = jQuery('#default_bannerUpd').val().replace(/C:\\fakepath\\/i, '');
                                            jQuery('#default_bannerChange').html(newFile);
                                        });
                                    });
                                </script>
                                <?php
                            }
                            else{
                                ?>
                                <input type="file" id="default_bannerUpd" name="default_bannerUpd" value="Upload" style="display:block;"/>
                                <?php
                            }
                        ?>
                            <span style="font-size: 11px;">Formats expected : .gif .jpg .png .swf .bmp</span>
                            <span style="font-size: 11px;"><br>Note : Upload a default banner to display it in this AdZone instead of text message</span>
                        </div>
                        <div class="clr"></div>
                    </div>

                    <div class="clr"></div>
                </div>
            </div>
			<input type="submit" name="SUBMIT" value="UPDATE" class="btn-bg2"/>
			<input type="hidden" name="edit" value="1" />
		</form>
        
	</div>
	<?php }?>
  
</div>
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
	jQuery('#addZones').slideToggle('fast');
});
jQuery('#minus-btn1').click(function(){
	jQuery('#multipleBanner').slideToggle('fast');
});
jQuery('#minus-btn2').click(function(){
	jQuery('#adzonesTable').slideToggle('fast');
});
jQuery('#minus-btn3').click(function(){
	jQuery('#extrasetting').slideToggle('fast');
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