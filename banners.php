<div class="wpa-section wpa-shadow wpa-spacing-top">
	<div class="wpa-logo-section clearfix">
		<span class="left"><img src="<?php echo plugins_url('images/logo.gif',__FILE__);?>" width="203" height="58" alt="wp adcenter" /></span>
		<h2>Banners</h2>
	</div>
	<?php if(!isset($_REQUEST['mode']) || $_REQUEST['mode']=="") {?>
	<div id="imgloader" style="padding-right:10px" align="center"></div>
	<div class="wpa-section clearfix">
		<h1 class="clearfix">
			<span class="close-icon" id="minus-btn"><span class="heading" style="padding-left:35px;">Add a Banner</span></span>
		</h1>
		
		<form class="setting-section" name="addBanner" id="addBanner" enctype="multipart/form-data" method="post">
			<div class="advertisement-form">
                <div class="row1">
                    <div class="col1">Advertiser Name</div>
                    <div class="col2">
					<?php $totadv = wpadl_totalAdvertiser("ORDER BY name ASC"); 
					
						 if(isset($_REQUEST['advid']))
						{
						  $selectedAdv = wpadl_selAdvertiser(intval($_REQUEST['advid']));
					    }
					?>
                    <select id="advertisersListing" name="advertisersListing" onchange="wpadl_showCampaign(this.value)";>
                      <option value="">Select Advertiser</option>
                      <?php for($i=0;$i<count($totadv);$i++){?>
                      <option value="<?php echo !empty($totadv[$i])?$totadv[$i]->id:'';?>"<?php   if(isset($totadv[$i]) && isset($selectedAdv[0])) if($totadv[$i]->id==$selectedAdv[0]->id) {?> selected="selected"<?php }?>>
                        <?php echo !empty($totadv[$i])?$totadv[$i]->name:'';?>
                      </option>
                      <?php }?>
                    </select>
                    </div>
                    <div class="clr"></div>
                </div>
			
                <div class="row1">
                    <div class="col1">Campaign Name</div>
                    <div class="col2" id="CampaignDiv">
						<?php if(isset($_REQUEST['advid'])) 
						{
						$selCam = wpadl_selCampaign(intval($_REQUEST['advid']));?>
						<select id="campaignsListing" name="campaignsListing">
						<?php for($j=0;$j<count($selCam);$j++) 
							  {?>
                        		<option value="<?php echo !empty($selCam[$j])?$selCam[$j]->id:''?>"><?php echo !empty($selCam[$j])?$selCam[$j]->name:''?></option>
						<?php }?>
                        </select>
						<?php 
						 } else 
						 {?>
                        <select id="campaignsListing" name="campaignsListing">
							<option value="">Select Campaign</option>
							<option></option>
						</select>

						<?php }?>
                    </div>
                    <div class="clr"></div>
                </div>
                <div class="clr"></div>
			</div>
            <div class="advertisement-form">
                <div class="row1">
                    <div class="col1">Banner Name</div>
                    <div class="col2">
                        <input type="text" class="textbox" name="bannerName" id="bannerName" />
                    </div>
                    <div class="clr"></div>
                </div>
			
                <div class="row1">
                    <div class="col1">Ad Zone</div>
                    <div class="col2">
					<?php $totalZones = wpadl_totalZones('ORDER BY name ASC');?>
                        <select name="zones" id="zones">
						<option value="">Select Zone</option>
						<?php for($i=0;$i<count($totalZones);$i++){?>
                        	<option value="<?php echo !empty($totalZones[$i])?$totalZones[$i]->id:'';?>"><?php echo !empty($totalZones[$i])?$totalZones[$i]->name:'';?></option>
							<?php }?>
                        </select>
                    </div>
                    <div class="clr"></div>
                </div>
                <div class="clr"></div>
			</div>
            <div class="advertisement-form">
                <div class="row1">
                    <div class="col1">Link URL</div>
                    <div class="col2">
                        <input type="text" class="textbox" name="bannerLink" />
                    </div>
                    <div class="clr"></div>
                </div>
			
                <div class="row1">
                    <div class="col1">Target1</div>
                    <div class="col2">
                        <select name="target" id="target">
                        	<option value="_blank">_blank</option>
				<option value="_self">_self</option>
				<option value="_parent">_parent</option>
				<option value="_top">_top</option>
                        </select>
                    </div>
                    <div class="clr"></div>
                </div>
                <div class="clr"></div>
			</div>
			<div>
				<h3>Choose A Banner Type</h3>
			</div>
            <div class="wpa-section clearfix">
            	<h1 class="clearfix">
                    <span class="open-icon" id="minus-btn1"> <span class="heading">Upload from Computer</span></span>
                   
                </h1>
            	<div class="advertisement-form" id="uploadDiv" style="display:none">
                    <div class="row1" style="width: 700px;">
                        <div class="col1">File</div>
                        <div class="col2" style="width: 500px;">
                            <input type="file" name="file" size="25" id="file" />
                            <span style="font-size: 11px; padding-left: 25px;">Formats expected: .gif .jpg .png .swf .bmp</span>
                        </div>
                        <div class="clr"></div>
                    </div>
                    <div class="clr"></div>
                </div>
            </div>
            <div class="wpa-section clearfix">
            	<h1 class="clearfix">
				 <span class="open-icon" id="minus-btn2"> <span class="heading">Link to external file</span></span>
                   
                </h1>
            	<div class="advertisement-form" id="externalLink" style="display:none">
                    <div class="row1">
                        <div class="col1">URL</div>
                        <div class="col2">
                            <input type="text" class="textbox" name="url" />
                        </div>
                        <div class="clr"></div>
                    </div>
                    <div class="clr"></div>
                </div>
            </div>
            <div class="wpa-section clearfix">
            	<h1 class="clearfix">
                    <span class="open-icon" id="minus-btn3"> <span class="heading">Paste Ad code</span></span>
                   
                </h1>
            	<div class="advertisement-form" id="htmlPaste" style="display:none">
                    <div class="row1" style="width: 700px;">
                        <div class="col1">Code</div>
                        <div class="col2" style="width: 500px;">
                            <textarea class="textbox" rows="4" name="bannerHtml"></textarea>
                            <span style="font-size: 11px; padding-left: 25px; vertical-align: top;">HTML or Javascript code</span>
                        </div>
                        <div class="clr"></div>
                    </div>
                    <div class="clr"></div>
                </div>
            </div>
			<input type="submit" name="SUBMIT" value="SAVE BANNER" class="btn-bg2"/>
			<input type="hidden" name="add" value="1" />

		</form>
        
	</div>
	<div id="loader"></div><div id="deleted" style="color:red"><p><b></b></p></div>
<div class="wpa-section clearfix">
    <h1 class="clearfix">
        <span class="open-icon" id="minus-btn4"><span class="heading">Current Banners </span></span>
        
    </h1>
	<?php $totalBanner = wpadl_displayAll_Banners();
	if(count($totalBanner)>0){
	?>
	<table cellpadding="0" cellspacing="0" border="0" id="finishedCampaign" style="display:none">
    	<thead> 
            <tr>
    			<th width="917">Banner</th>
                <th width="106">Size</th>
           	    <th width="129">View Banner</th>
          		<th width="88">Delete </th>
            </tr>
        </thead>
        <tbody>
		<?php 
			for($i=0;$i<count($totalBanner);$i++) {
			$file = wpadl_chkBannerType( $totalBanner[$i] );
			
		?>
        	<tr id="delbanner_<?php echo $i?>">
        		<td><a href="?page=banners&mode=edit&aid=<?php echo $totalBanner[$i]->advertiser_id;?>&cid=<?php echo $totalBanner[$i]->campaign_id;?>&id=<?php echo $totalBanner[$i]->id?>"><?php echo ucwords($totalBanner[$i]->name);?></a></td>
                <td><?php
							if( $file['type'] != 'html' ){ $size = getimagesize( $file['file'] );echo $size[0].'x'.$size[1];}
												  else	 { echo 'unknown';}
					 ?>
				</td>
            	<td><?php
							if( $file['type'] != 'html' ){$file = wpadl_showBannerToolTip( $file['file'], $totalBanner[$i] );}
												  else	 {$file = $file['file'];}
					?>
				<a class="preview_banner_<?php echo $i; ?>">
                    <input type="button" name="view" value="" class="viewbttn button1" />
				 </a>
				<script type="text/javascript">
				jQuery(function(){
					jQuery(".preview_banner_<?php echo $i; ?>").tipTip({defaultPosition: 'right', maxWidth: '1000px', edgeOffset: 5, content: '<?php echo $file; ?>'});
				});
				</script>
                </td>	
                <td>
                	<a onClick="wpadl_Delete(<?php echo $totalBanner[$i]->id;?>,'delbanner','delbanner_<?php echo $i?>')" style="text-decoration:none;"><input type="button" name="delete"class="deletebttn button1" /></a>
                </td>	
        	</tr>
          <?php }?>
        </tbody>
    </table>
	<?php } else {?>
	<table cellpadding="0" cellspacing="0" border="0" id="finishedCampaign"  style="display:none;">
    	<thead> 
            <tr>
    			<th>No Current Banners</th>
          </tr>
        </thead>
       
    </table>
	<?php }?>
  </div>    
    
	<?php } else {
		if(isset($_REQUEST['id']))
	$sel = wpadl_totalBanner(intval($_REQUEST['id']));
	?>
		<div id="imgloader" style="padding-right:10px" align="center"></div>
	<div class="wpa-section clearfix">
		<h1 class="clearfix">
			<span class="close-icon" id="minus-btn"><span class="heading" style="padding-left:35px;">Update Banner</span></span>
		</h1>
		
		<form class="setting-section" name="updateBanner" id="updateBanner" enctype="multipart/form-data" method="post">
            <div class="advertisement-form">
                <div class="row1">
                    <div class="col1">Banner Name</div>
                    <div class="col2">
                        <input type="text" class="textbox" name="bannerNameUpd" id="bannerNameUpd" value="<?php echo !empty($sel[0])?$sel[0]->name:'';?>"/>
                    </div>
                    <div class="clr"></div>
                </div>
			
                <div class="row1">
                    <div class="col1">Ad Zone</div>
                    <div class="col2">
                       <?php $totalZones = wpadl_totalZones('ORDER BY name ASC');?>
                        <select name="zonesUpd" id="zonesUpd">
                        <?php for($i=0;$i<count($totalZones);$i++){
                                ?>
                                <option value="<?php echo !empty($totalZones[$i])?$totalZones[$i]->id:'';?>"
                                    <?php if( (!empty($sel[0]) ? $sel[0]->adzone : '') == (!empty($totalZones[$i]) ? $totalZones[$i]->id:'')) {
                                        ?>
                                            selected = "selected"
                                        <?php
                                        } ?>
                                        >
                                        <?php echo !empty($totalZones[$i])?$totalZones[$i]->name:'';?>
                                </option>
                                <?php } ?>
                        </select>
                    </div>
                    <div class="clr"></div>
                </div>
                <div class="clr"></div>
			</div>
            <div class="advertisement-form">
                <div class="row1">
                    <div class="col1">Link URL</div>
                    <div class="col2">
                        <input type="text" class="textbox" name="bannerLinkUpd" id="bannerLinkUpd" value="<?php echo !empty($sel[0])?$sel[0]->url:''?>" />
                    </div>
                    <div class="clr"></div>
                </div>
			
                <div class="row1">
                    <div class="col1">Target</div>
                    <div class="col2">
                        <select name="targetUpd" id="targetUpd">
                        	<option value="_blank" <?php if(isset($sel[0]) && $sel[0]->target=="_blank") {?> selected="selected"<?php }?>>_blank</option>
				<option value="_self" <?php if(isset($sel[0]) &&  $sel[0]->target=="_self") {?> selected="selected"<?php }?>>_self</option>
				<option value="_parent" <?php if(isset($sel[0]) &&  $sel[0]->target=="_parent") {?> selected="selected"<?php }?>>_parent</option>
				<option value="_top" <?php if(isset($sel[0]) &&  $sel[0]->target=="_top") {?> selected="selected"<?php }?>>_top</option>
                        </select>
                    </div>
                    <div class="clr"></div>
                </div>
                <div class="clr"></div>
			</div>
			<div>
				<h3>Choose A Banner Type</h3>
			</div>
            <div class="wpa-section clearfix">
			 <div>
				<?php 
				if( !empty( $sel[0]->file ) )
				{
					echo wpadl_showBanner( $sel[0]->file, $sel[0]->url ); 
				}
				?>
			</div>
			<br />
            	<h1 class="clearfix">
                    <span class="open-icon" id="minus-btn1"> <span class="heading">Upload from Computer</span></span>
                   
                </h1>
            	<div class="advertisement-form" id="uploadDiv" style="display:none">
                    <div class="row1" style="width: 700px;">
                        <div class="col1">File</div>
                        <div class="col2" style="width: 500px;">
                            <input type="file" name="fileUpd" size="25" id="file"/>
                            <span style="font-size: 11px; padding-left: 25px;">Formats expected: .gif .jpg .png .swf .bmp</span>
                        </div>
                        <div class="clr"></div>
                    </div>
                    <div class="clr"></div>
                </div>
            </div>
            <div class="wpa-section clearfix">
			 <div>
				<?php 
				if( !empty( $sel[0]->file ) && !empty( $sel[0]->ext_file ) )
				{
					echo wpadl_showBanner( $sel[0]->ext_file, $sel[0]->url ); 
				}
				?>
			</div>
			<br />
            	<h1 class="clearfix">
				 <span class="open-icon" id="minus-btn2"> <span class="heading">Link to external file</span></span>
                   
                </h1>
            	<div class="advertisement-form" id="externalLink" style="display:none">
                    <div class="row1">
                        <div class="col1">URL</div>
                        <div class="col2">
                            <input type="text" class="textbox" name="urlUpd" value="<?php echo !empty($sel[0])?$sel[0]->ext_file:'';?>" />
                        </div>
                        <div class="clr"></div>
                    </div>
                    <div class="clr"></div>
                </div>
            </div>
            <div class="wpa-section clearfix">
			 
			<div>
				<?php 
				if( !empty( $sel[0]->html ) )
				{
					echo $sel[0]->html; 
				}
				?>
			</div>
			<br />
            	<h1 class="clearfix">
                    <span class="open-icon" id="minus-btn3"> <span class="heading">Paste Ad code</span></span>
                   
                </h1>
            	<div class="advertisement-form" id="htmlPaste" style="display:none">
                    <div class="row1" style="width: 700px;">
                        <div class="col1">Code</div>
                        <div class="col2" style="width: 500px;">
                            <textarea class="textbox" rows="4" name="bannerHtmlUpd"><?php echo !empty($sel[0])?$sel[0]->html:'';?></textarea>
                            <span style="font-size: 11px; padding-left: 25px; vertical-align: top;">HTML or Javascript code</span>
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
	jQuery('#addBanner').slideToggle('fast');
});
jQuery('#minus-btn1').click(function(){
	jQuery('#uploadDiv').slideToggle('fast');
});
jQuery('#minus-btn2').click(function(){
	jQuery('#externalLink').slideToggle('fast');
});
jQuery('#minus-btn3').click(function(){
	jQuery('#htmlPaste').slideToggle('fast');
});
jQuery('#minus-btn4').click(function(){
	jQuery('#finishedCampaign').slideToggle('fast');
});
jQuery('#minus-btn').click(function(){
	jQuery('#updateBanner').slideToggle('fast');
});

</script>
