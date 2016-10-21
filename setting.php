<div class="wpa-section wpa-shadow wpa-spacing-top">
<div style="line-height: 2.4em;">
<a href="http://club.wpeka.com/product/wpadcenter" target="_blank">
<img src="<?php echo plugins_url('/images/AdCenter.png',__FILE__); ?>">
</a>
</div>

<h3>You are using the lite version of WP Adcenter Lite. Upgrade to <u><a href="http://wpadcenter.com/">Pro version</a></u> to get updates and support!<h3>
</div>	<div style="clear:both;"></div>

	<div class="wpa-logo-section clearfix">
		<span class="left"><img src="<?php echo plugins_url('images/logo.gif',__FILE__);?>" width="203" height="58" alt="wp adcenter" /></span>
		<h2>Settings</h2>
	</div>
	
	<div class="wpa-section clearfix">
		<h1 class="clearfix">
			<span class="setting-icon"></span>
			<span class="heading">Settings</span>
		</h1>
		<?php $mail = wpadl_totalMail(); ?>
		<form class="setting-section" name="settingForm" id="settingForm" action="" method="post">
			
			<div class="row clearfix">
				<div class="col1">Your Paypal Email</div>
				<div class="col2">
					<input type="text" class="textbox" name="paypalEmail" id="paypalEmail" value="<?php echo $mail[0]->emailPaypal;?>" maxlength="40" size="22" />
				</div>
			</div>
			
			<div class="row clearfix">
				<div class="col1">Currency</div>
				<div class="col2">
					<select name="currency" id="currency">
						<option value="AUD" <?php if($mail[0]->currency=="AUD") {?> selected="selected"<?php }?>>AUD</option>
						<option value="BRL" <?php if($mail[0]->currency=="BRL") {?> selected="selected"<?php }?>>BRL</option>
						<option value="CAD" <?php if($mail[0]->currency=="CAD") {?> selected="selected"<?php }?>>CAD</option>
						<option value="CZK" <?php if($mail[0]->currency=="CZK") {?> selected="selected"<?php }?>>CZK</option>
						<option value="DKK" <?php if($mail[0]->currency=="DKK") {?> selected="selected"<?php }?>>DKK</option>
						<option value="EUR" <?php if($mail[0]->currency=="EUR") {?> selected="selected"<?php }?>>EUR</option>
						<option value="HKD" <?php if($mail[0]->currency=="HKD") {?> selected="selected"<?php }?>>HKD</option>
						<option value="HUF" <?php if($mail[0]->currency=="HUF") {?> selected="selected"<?php }?>>HUF</option>
						<option value="ILS" <?php if($mail[0]->currency=="ILS") {?> selected="selected"<?php }?>>ILS</option>
						<option value="JPY" <?php if($mail[0]->currency=="JPY") {?> selected="selected"<?php }?>>JPY</option>
						<option value="MYR" <?php if($mail[0]->currency=="MYR") {?> selected="selected"<?php }?>>MYR</option>
						<option value="MXN" <?php if($mail[0]->currency=="MXN") {?> selected="selected"<?php }?>>MXN</option>
						<option value="NOK" <?php if($mail[0]->currency=="NOK") {?> selected="selected"<?php }?>>NOK</option>
						<option value="NZD" <?php if($mail[0]->currency=="NZD") {?> selected="selected"<?php }?>>NZD</option>
						<option value="PHP" <?php if($mail[0]->currency=="PHP") {?> selected="selected"<?php }?>>PHP</option>
						<option value="PLN" <?php if($mail[0]->currency=="PLN") {?> selected="selected"<?php }?>>PLN</option>
						<option value="GBP" <?php if($mail[0]->currency=="GBP") {?> selected="selected"<?php }?>>GBP</option>
						<option value="SGD" <?php if($mail[0]->currency=="SGD") {?> selected="selected"<?php }?>>SGD</option>
						<option value="SEK" <?php if($mail[0]->currency=="SEK") {?> selected="selected"<?php }?>>SEK</option>
						<option value="CHF" <?php if($mail[0]->currency=="CHF") {?> selected="selected"<?php }?>>CHF</option>
						<option value="TWD" <?php if($mail[0]->currency=="TWD") {?> selected="selected"<?php }?>>TWD</option>
						<option value="THB" <?php if($mail[0]->currency=="THB") {?> selected="selected"<?php }?>>THB</option>
						<option value="TRY" <?php if($mail[0]->currency=="TRY") {?> selected="selected"<?php }?>>TRY</option>
						<option value="USD" <?php if($mail[0]->currency=="USD") {?> selected="selected"<?php }?>>USD</option>
					</select>
				</div></div>
				    <?php $adcenter_autoroatead=get_option('autorotate'); ?>
				 <div class="row clearfix">
				<div class="col1">Auto Refresh Ad</div>
				<div class="col2">
					<select name="autorotate" id="autorotate">
					 
						<option value="1"<?php if($adcenter_autoroatead=="1") {?>   selected="selected"<?php }?>>Yes</option>
						<option value="0"<?php if($adcenter_autoroatead=="0") {?>  selected="selected"<?php }?>>No</option>
						
					</select>
					<div class="desc_text">Enable / disable to auto refresh your ads on page.</div>
					
				</div>
				</div>
				<?php $adcenter_impressions=get_option('impression'); ?>
				<div class="row clearfix">
				<div class="col1">Enable Impressions</div>
				<div class="col2">
					<select name="impression" id="impression">
					 
						<option value="1"<?php if($adcenter_impressions=="1") {?>   selected="selected"<?php }?>>Yes</option>
						<option value="0"<?php if($adcenter_impressions=="0") {?>  selected="selected"<?php }?>>No</option>
 						
					</select>
					<div class="desc_text">Enable / disable Impression count for Ads.</div>
				</div>
				</div>

				<div class="row clearfix">
				<div class="col1">Paypal Sandbox</div>
				<div class="col2">
					<select name="adcenter_sandbox" id="autorotate" disabled>		
					</select>
					<div class="desc_text"><i>Currently, this feature is only available for Pro version !</i></div>
				</div>
				</div>
			<?php $adcenteremail = get_option('adcenterEmail');?>
			
			<div class="row clearfix">
			<div class="col1">From Email ID</div>					
			<div class="col2">
			<input type="email" class="textbox" name="adcenterEmail" id="adEmail" value="<?php echo $adcenteremail; ?>" maxlength="40" >
			<div class="desc_text">All automated notifications will be sent via this Mail id.</div>
			</div>
			</div>
			<?php $adcentername = get_option('adcenterName');?>
			
			<div class="row clearfix">
			<div class="col1">From Name </div>					
			<div class="col2">
			<input type="text" class="textbox" name="adcenterName" id="adName" value="<?php echo $adcentername; ?>" maxlength="40" >
			<div class="desc_text">All automated notifications will be sent via this Name</div>
			</div>
			</div>

			<div class="geolocation-section row clearfix">
			<div class="col1">Enable Geolocation</div>
				<div class="col2">
				<Input type = 'Radio' Name ='adcenterGeolocation' value= 'adzone' disabled>
				Adzone level
				</div>
				<div class="col2">
				<Input type = 'Radio' Name ='adcenterGeolocation' value= 'campaign' disabled>
				Campaign level
				</div>
				<div class="col2">
				<Input type = 'Radio' Name ='adcenterGeolocation' value= 'none' checked='checked'>
				None
				<div class="desc_text"><i>Currently, this feature is only available for Pro version.</i></div>
				</div>
			</div>

			<input type="submit" name="SUBMIT" value="SAVE OPTIONS" class="btn-bg2";/>
			<input type="hidden" name="add" value="1" />
			
		</form>
		
	</div>
</div>
