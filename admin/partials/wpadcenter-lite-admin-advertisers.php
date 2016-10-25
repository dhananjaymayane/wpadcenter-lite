<div class="wpa-section wpa-shadow wpa-spacing-top">

	<div class="wpa-logo-section clearfix">
		<span class="left"><img src="<?php echo WP_ADCENTER_ADMIN_URL.'images/logo.gif';?>" width="203" height="58" alt="wp adcenter" /></span>
		<h2>Advertiser</h2>
	</div>
	<?php if( !isset($_REQUEST['mode']) || $_REQUEST['mode']=="" ) {?>
	<div class="wpa-section clearfix">
		<h1 class="clearfix">
		<span class="close-icon" id="minus-btn"><span class="heading" style="margin-left:35px;">Add a New Advertiser</span></span>
		</h1>
		<form action="<?php echo !empty($action_url)?$action_url:'' ?>" name="addAdvertiser" id="addAdvertiser" method="post" class="setting-section">
			<div class="advertisement-form">
                <div class="row1">
				
                    <div class="col1">Advertiser Name</div>
                    <div class="col2">
                        <input type="text" class="textbox" name="advertiser_name" />
                    </div>
                    <div class="clr"></div>
                </div>
			
                <div class="row1">
                    <div class="col1">Advertiser Email</div>
                    <div class="col2">
                        <input type="text" class="textbox" name="advertiser_mail"/>
                    </div>
                    <div class="clr"></div>
                </div>
                <div class="clr"></div>
			</div>
			<input type="submit" name="SUBMIT" value="ADD ADVERTISER" id="adAdv" class="btn-bg2"/>
			<input type="hidden" name="add" value="1" />
		</form>
        
	</div>
	 <div id="loader"></div><div id="deleted" style="color:red"><p><b></b></p></div>	
   <div class="wpa-section clearfix">
    <h1 class="clearfix">
        <span class="open-icon" id="current-advertiser"><span class="heading" style="padding-left:35px">Current Advertiser</span></span>
        
    </h1>
<?php $totadv = wpadl_totalAdvertiser("ORDER BY name ASC");
	if(count($totadv)>0){?>
	<table cellpadding="0" cellspacing="0" border="0" id="adverTable" style="display:none">
    	<thead> 
		  <tr>
    			<th width="287">Advertiser Name</th>
        		<th width="282">Advertiser  Email</th>
                <th width="241">Add a Campaign</th>
           	    <th width="227">Delete Advertiser</th>
          </tr>
        </thead>
        <tbody>
		<?php 
		for($i=0;$i<count($totadv);$i++) {
		?>
        	<tr id="deladv_<?php echo $i?>">
        		<td><a href="?page=advertisement&mode=edit&id=<?php echo $totadv[$i]->id;?>&aname=<?php echo $totadv[$i]->name;?>" style="text-decoration:none;"><?php echo ucwords($totadv[$i]->name);?></a></td>
        		<td><?php if($totadv[$i]->email!="") $email=$totadv[$i]->email; else $email = "NA"; echo $email;?></td>
            	<td>
                	<a href="?page=campaigns&aid=<?php echo $totadv[$i]->id;?>" style="text-decoration:none;"><input type="button" name="add" value="" class="addbttn button1" /></a>
                </td>
                <td>
				<a onClick="wpadl_delete_Adv(<?php echo $totadv[$i]->id;?>,'<?php echo $totadv[$i]->name;?>','deladv','deladv_<?php echo $i?>')" style="text-decoration:none;"><input type="button" name="delete"class="deletebttn button1" /></a>
                	
                </td>	
        	</tr>
           <?php }?>
        </tbody>
    </table>
<?php }else {?><table cellpadding="0" cellspacing="0" border="0" id="adverTable"  style="display:none;">
    	<thead> 
            <tr>
    			<th>No Current Advertisers</th>
          </tr>
        </thead>
       
    </table>
<?php }?>
  </div>
	<?php } else {
	$advertiserRec = wpadl_updAdvertiser(intval($_REQUEST['id']));
	?>
	<div class="wpa-section clearfix" id="updAdvertiser1">
		<h1 class="clearfix">
			<span class="close-icon" id="minus-btn1">
				<span class="heading" style="padding-left:35px;">Update Advertiser</span>
			</span>
			
		</h1>

		<form action="<?php echo !empty($action_url)?$action_url:'' ?>" name="updAdvertiser" id="updAdvertiser" method="post" class="setting-section">
			<div class="advertisement-form">
                <div class="row1">
				
                    <div class="col1">Advertiser Name</div>
                    <div class="col2">
                        <input type="text" class="textbox" name="advertiser_nameupd" value="<?php echo $advertiserRec[0]->name;?>" />
                    </div>
                    <div class="clr"></div>
                </div>
			
                <div class="row1">
                    <div class="col1">Advertiser Email</div>
                    <div class="col2">
                        <input type="text" class="textbox" name="advertiser_mailupd" value="<?php echo $advertiserRec[0]->email;?>"/>
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
</div>

<script type="text/javascript">
jQuery(".open-icon, .close-icon").click(function(){
              
    if(jQuery(this).hasClass("open-icon"))
    {
     jQuery(this).removeClass("open-icon");
     jQuery(this).toggleClass("close-icon").next().slideToggle("slow")
    }
    else
    {
     jQuery(this).removeClass("close-icon");
     jQuery(this).toggleClass("open-icon").next().slideToggle("slow")
    }         
 });
 
 
jQuery('#minus-btn').click(function(){
	jQuery('#addAdvertiser').slideToggle();
});

jQuery('#minus-btn1').click(function(){
	jQuery('#updAdvertiser').slideToggle();
});


jQuery('#current-advertiser').click(function(){
	jQuery('#adverTable').slideToggle();
});


</script>