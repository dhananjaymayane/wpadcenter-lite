<div class="wpa-section wpa-shadow wpa-spacing-top">
	<div class="wpa-logo-section clearfix">
		<span class="left"><img src="<?php echo plugins_url('images/logo.gif',__FILE__);?>" width="203" height="58" alt="wp adcenter" /></span>
		<h2>Packages</h2>
	</div>
	<?php if(!isset($_REQUEST['mode']) ||  $_REQUEST['mode']=="") {?>
	<div class="wpa-section clearfix">
		<h1 class="clearfix">
			<span class="close-icon" id="minus-btn"><span class="heading">Add a Package</span></span>
		</h1>
		
		<form action="" class="setting-section" name="addPackages" id="addPackages" method="post">
			<div class="advertisement-form">
                <div class="row1">
                    <div class="col1">Package Name</div>
                    <div class="col2">
                    <input type="text" class="textbox" name="packageName" id="packageName" />
                    </div>
                    <div class="clr"></div>
                </div>
			
                <div class="row1">
                    <div class="col1">Ad Zone </div>
                    <div class="col2">
                       <?php $totalZones = wpadl_totalZones('ORDER BY name ASC');?>
                        <select name="adZones" id="adZones">
						<option value="">Select Zone</option>
						<?php for($i=0;$i<count($totalZones);$i++){?>
                        	<option value="<?php echo $totalZones[$i]->id;?>"><?php echo $totalZones[$i]->name;?></option>
							<?php }?>
                        </select>
                    </div>
                    <div class="clr"></div>
                </div>
                <div class="clr"></div>
			</div>
            <div class="advertisement-form borderBottomNone">
                <div class="row1">
                    <div class="col1">Package Description </div>
                    <div class="col2">
                        <textarea class="textbox" rows="4" style="width: 300px;" name="description" id="description"></textarea>
                    </div>
                    <div class="clr"></div>
                </div>
                <div class="clr"></div>
			</div>
            <div class="wpa-section clearfix">
            	<h1 class="clearfix borderBottomNone">
                    <span class="open-icon" id="minus-btn1"><span class="heading">Set Time Package</span></span>
                   
                </h1>
            	<div class="advertisement-form borderBottomNone" id="monthlyPackage" style="display:none">
                    <div class="row1">
                    <div class="col1">Package Cost </div>
                    <div class="col2">
                         <input type="text" class="textbox" name="packCostMon" id="packCostMon" />
                    </div>
                    <div class="clr"></div>
                </div>
				
		<div class="row1">
                    <div class="col1">Duration</div>
                    <div class="col2">
                       <select name="duration" id="duration">
            				<option value="daily">1 Day</option>
            				<option value="weekly">1 Week</option>
                            <option value="monthly">1 Month</option>
                        </select>
                    </div>
                    <div class="clr"></div>
                </div>
                    <div class="clr"></div>
                </div>
            </div>
            <div class="wpa-section clearfix">
            	<h1 class="clearfix">
                    <span class="open-icon" id="minus-btn2"><span class="heading">Impressions Package </span></span>
                   
                </h1>
            	<div class="advertisement-form borderBottomNone" id="impressionPackage" style="display:none">
                    <div class="row1">
                        <div class="col1">Package Cost</div>
                        <div class="col2">
                            <input type="text" class="textbox" name="packCostImp" id="packCostImp" />
                        </div>						
                        <div class="clr"></div>
                    </div>
			<div class="row1">
                        <div class="col1">Impression</div>
                        <div class="col2">
                            <input type="text" class="textbox"  name="impression" id="impression"/><p>Max Limit 10,000</p>
                        </div>
                        <div class="col2">
                        <div class = "impression-warning" style="display:none">
                            Max Limit exceeded
                        </div>
                        </div>
                        <div class="clr"></div>
                    </div>
                    <div class="clr"></div>
                </div>
            </div>
			<input type="submit" name="SUBMIT" value="SAVE PACKAGE" class="btn-bg2"/>
			<input type="hidden" name="add" value="1"/>

</form>
        
	</div>
	<div id="loader"></div><div id="deleted" style="color:red"><p><b></b></p></div> 
	<div class="wpa-section clearfix">
	    <h1 class="clearfix">
        	<span class="open-icon" id="minus-btn4"><span class="heading">Current Packages </span></span>        
	    </h1>
	<?php $totalPackages = wpadl_totalPackages('ORDER BY name DESC');
	if(count($totalPackages)>0){
	?>
	<table cellpadding="0" cellspacing="0" border="0" id="Package" style="display:none">
    	<thead> 
            <tr>
    		<th width="818">Package Name </th>
                <th width="161">Type</th>
           	    <th width="150">Cost</th>
          		<th width="85">Delete </th>
           </tr>
        </thead>
	     <tbody>
		 <?php for($i=0;$i<count($totalPackages);$i++) {?>
        	<tr id="delpackage_<?php echo $i?>">
		<td><a href="?page=packages&mode=edit&id=<?php echo $totalPackages[$i]->id;?>" style="text-decoration:none;"><?php echo ucwords($totalPackages[$i]->name);?></a></td>
                <td><?php if($totalPackages[$i]->m_cost==""){ echo 'impressions';} else {echo $totalPackages[$i]->duration;}?></td>
            	<td><?php if($totalPackages[$i]->m_cost=="") {echo '$'.$totalPackages[$i]->i_cost;} else {echo '$'.$totalPackages[$i]->m_cost;}?></td>	
                <td><a onClick="wpadl_Delete(<?php echo $totalPackages[$i]->id;?>,'delpackage','delpackage_<?php echo $i?>')" style="text-decoration:none;"><input type="button" name="delete" class="deletebttn button1" /></a></td>	
        	</tr>
         <?php }?>
        </tbody>
    </table>
<?php } else {?>
<table cellpadding="0" cellspacing="0" border="0" id="Package"  style="display:none;">
    	<thead> 
            <tr>
    			<th>No Current Packages</th>
            </tr>
        </thead>
       
    </table>
 <?php }?>
  </div>   
	<?php }else {$packRec = !empty($_REQUEST['id'])? wpadl_updPackage(intval($_REQUEST['id'])):'';?>
	<div class="wpa-section clearfix">
		<h1 class="clearfix">
			<span class="close-icon" id="minus-btn"><span class="heading">Update Package</span></span>
		</h1>
		
		<form action="" class="setting-section" name="updatePackages" id="updatePackages" method="post">
			<div class="advertisement-form">
                <div class="row1">
                    <div class="col1">Package Name</div>
                    <div class="col2">
                         <input type="text" class="textbox" name="packageNameUpd" id="packageNameUpd" value="<?php echo !empty($packRec[0])?$packRec[0]->name:'';?>" />
                    </div>
                    <div class="clr"></div>
                </div>
			
                <div class="row1">
                    <div class="col1">Ad Zone </div>
                    <div class="col2">
                       <?php $totalZones = wpadl_totalZones('ORDER BY name ASC');?>
                        <select name="adZonesUpd" id="adZonesUpd">
			<option value="">Select Zone</option>
				<?php for($i=0;$i<count($totalZones);$i++){?>
                	<option value="<?php echo !empty($totalZones[$i])?$totalZones[$i]->id:'';?>" <?php if(isset($packRec[0]) && isset($totalZones[$i]) && $packRec[0]->adzone_id==$totalZones[$i]->id) {?> selected="selected"<?php }?>><?php echo $totalZones[$i]->name;?></option>
			<?php }?>
                        </select>
                    </div>
                    <div class="clr"></div>
                </div>
                <div class="clr"></div>
			</div>
            <div class="advertisement-form borderBottomNone">
                <div class="row1">
                    <div class="col1">Package Description </div>
                    <div class="col2">
                        <textarea class="textbox" rows="4" style="width: 300px;" name="descriptionUpd" id="descriptionUpd"><?php echo !empty($packRec[0])?$packRec[0]->description:'';?></textarea>
                    </div>
                    <div class="clr"></div>
                </div>                
                <div class="clr"></div>
	</div>
            
            <div class="wpa-section clearfix">
            	<h1 class="clearfix borderBottomNone">
                    <span class="open-icon" id="minus-btn1"><span class="heading">Monthly Package </span></span>           
                </h1>
            	<div class="advertisement-form borderBottomNone" id="monthlyPackage" style="display:none">
                    <div class="row1">
                    <div class="col1">Package Cost </div>
                    <div class="col2">
                       <input type="text" class="textbox" name="packCostMonUpd" id="packCostMonUpd" value="<?php echo !empty($packRec[0])?$packRec[0]->m_cost:'' ?>" />
                    </div>
                    <div class="clr"></div>
                </div>
				
	<div class="row1">
          <div class="col1">Duration</div>
            <div class="col2">
               <select name="durationUpd" id="durationUpd">
        		<option value="daily" <?php if(isset($packRec[0]) &&  $packRec[0]->duration=='daily'){?> selected="selected"<?php }?>>1 Day</option>
        		<option value="weekly" <?php if(isset($packRec[0]) && $packRec[0]->duration=='weekly'){?> selected="selected"<?php }?>>1 Week</option>
                <option value="monthly" <?php if(isset($packRec[0]) && $packRec[0]->duration=='monthly'){?> selected="selected"<?php }?>>1 Month</option>
               </select>
              </div>
                <div class="clr"></div>
             </div>
                <div class="clr"></div>
            </div>
           </div>
            <div class="wpa-section clearfix">
            	<h1 class="clearfix">
                    <span class="open-icon" id="minus-btn2"><span class="heading">Impressions Package </span></span>        
                </h1>
            	<div class="advertisement-form borderBottomNone" id="impressionPackage" style="display:none">
                    <div class="row1">
                        <div class="col1">Package Cost</div>
                        <div class="col2">
                            <input type="text" class="textbox" name="packCostImpUpd" id="packCostImpUpd" value="<?php echo !empty($packRec[0])?$packRec[0]->i_cost:''  ?>" />
                        </div>						
                        <div class="clr"></div>
                    </div>
					<div class="row1">
                        <div class="col1">Impression</div>
                        <div class="col2">
                            <input type="text" class="textbox"  name="impressionUpd" id="impressionUpd" value="<?php echo !empty($packRec[0])?$packRec[0]->impressions:'';?>"/>
                            <p>Max Limit 10,000</p>
                        </div>						
                        <div class="col2">
                        <div class = "impression-warning" style="display:none">
                            Max Limit exceeded
                        </div>
                        </div>
                        <div class="clr"></div>
                    </div>
                    <div class="clr"></div>
                </div>
            </div>
			<input type="submit" name="SUBMIT" value="UPDATE" class="btn-bg2"/>
			<input type="hidden" name="edit" value="1"/>

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
	jQuery('#addPackages').slideToggle('fast');
});
jQuery('#minus-btn1').click(function(){
	jQuery('#monthlyPackage').slideToggle('fast');
});
jQuery('#minus-btn2').click(function(){
	jQuery('#impressionPackage').slideToggle('fast');
});
jQuery('#minus-btn3').click(function(){
	jQuery('#htmlPaste').slideToggle('fast');
});
jQuery('#minus-btn4').click(function(){
	jQuery('#Package').slideToggle('fast');
});

jQuery('#impression').focusout(function() {
    var impression_val = jQuery('#impression').val();
    if( impression_val > 10000 ){
        jQuery('#impression').css('border-color','red');
        jQuery('.impression-warning').css('display','block');
        jQuery('#impression').val("");
    }
});
jQuery('#impressionUpd').focusout(function() {
    var impression_val = jQuery('#impressionUpd').val();
    if( impression_val > 10000 ){
        jQuery('#impressionUpd').css('border-color','red');
        jQuery('.impression-warning').css('display','block');
        jQuery('#impressionUpd').val("");
    }
});

</script>
