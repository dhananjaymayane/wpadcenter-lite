<div class="wpa-section wpa-shadow wpa-spacing-top">

	<div class="wpa-logo-section clearfix">
		<span class="left"><img src="<?php echo WP_ADCENTER_ADMIN_URL.'images/logo.gif';?>" width="203" height="58" alt="wp adcenter" /></span>
		<h2>User Status</h2>
	</div>
	<div id="loader"></div><div id="deleted" style="color:red"><p><b></b></p></div>
   <div class="wpa-section clearfix">
    <h1 class="clearfix">
        <span class="close-icon" id="current-advertiser"><span class="heading" style="padding-left:35px">Users</span></span>
        
    </h1>

	<div cellpadding="0" cellspacing="0" border="0" id="adverTable">
    	<p>Status of users, who wish to advertise on your site Adzone can be managed from here.<br><br>
    		<i>Currently this feature is only available in Pro Version</i>
    	</p>

    </div>
  </div>
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
