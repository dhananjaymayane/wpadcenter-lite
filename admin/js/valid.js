jQuery(document).ready(function() {
	
jQuery("#addAdvertiser").validate({
	rules: {
		advertiser_name: "required",
		advertiser_mail: {// compound rule 
		  email: true 
				}
	},
	messages: {
		advertiser_name: "Please Enter Name",
		advertiser_mail: "Enter Valid Email ID"
	}
});


});

jQuery(document).ready(function() {
	
jQuery("#updAdvertiser").validate({
	rules: {
		advertiser_nameupd: "required",
		advertiser_mailupd: {// compound rule 
		  email: true 
				}
	},
	messages: {
		advertiser_nameupd: "Please Enter Name",
		advertiser_mailupd: "Enter Valid Email ID"
	}
});


});

jQuery(document).ready(function() {
	
jQuery("#settingForm").validate({
	rules: {
		paypalEmail: {// compound rule 
		required:true,
		  email: true 
				}
	},
	messages: {
		paypalEmail: "Enter Valid Email ID"
	}
});


});

jQuery(document).ready(function() {
	
jQuery("#addCampaign").validate({
	rules: {
		campaignName: "required",
		advertiserList: "required",
		campaignStartDate: "required"
	},
	messages: {
		campaignName: "Enter Campaign Name",
		advertiserList: "Select Advertiser Name",
		campaignStartDate: "Enter Start Date"
	}
});


});

jQuery(document).ready(function() {
	
jQuery("#editCampaign").validate({
	rules: {
		campaignNameUpd: "required",
		advertiserListUpd: "required",
		campaignStartDateUpd: "required"
	},
	messages: {
		campaignNameUpd: "Enter Campaign Name",
		advertiserListUpd: "Select Advertiser Name",
		campaignStartDateUpd: "Enter Start Date"
	}
});


});


jQuery(document).ready(function() {
	
jQuery("#addBanner").validate({
	rules: {
		advertisersListing: "required",
		campaignsListing: "required",
		bannerName: "required",
		zones: "required"
	},
	messages: {
		advertisersListing: "Select Advertiser Name",
		campaignsListing: "No Campaign For This Advertiser.",
		bannerName: "Enter Banner Name",
		zones: "Please Add Ad zones."
	}
});


});

jQuery(document).ready(function() {
	
jQuery("#updateBanner").validate({
	rules: {
		advertisersListingUpd: "required",
		campaignsListingUpd: "required",
		bannerNameUpd: "required",
		zones: "required"
		
	},
	messages: {
		advertisersListingUpd: "Select Advertiser Name",
		campaignsListingUpd: "There Is No Campaign For This Advertiser.",
		bannerNameUpd: "Enter Banner Name",
		zonesUpd: "Please Add Ad zones."

	}
});

});

jQuery(document).ready(function() {
	
jQuery("#addZones").validate({
	rules: {
		zoneName: "required"
	},
	messages: {
		zoneName: "Enter Zone Name"
	}
});

});


jQuery(document).ready(function() {
	
jQuery("#updZones").validate({
	rules: {
		zoneNameUpd: "required"
	},
	messages: {
		zoneNameUpd: "Enter Zone Name"
	}
});

});


jQuery(document).ready(function() {
	
jQuery("#addPackages").validate({
	rules: {
		packageName: "required",
		adZones: "required"
	},
	messages: {
		packageName: "Enter Package Name",
		adZones: "Please Select Zone"
	}
});

});


jQuery(document).ready(function() {
	
jQuery("#pricing1").validate({
	rules: {
		userName: "required",
		userMail: {// compound rule 
		  required: true, 
		  email: true 
				},
		userPrice: "required",
		file: "required",
		userWeburl: 
		{
		  required: true, 
		  url: true
		},
		userAltText : "required"
	},
	messages: {
		userName: "Please Enter Your Full Name",
		userMail: "Enter Valid Email ID",
		userPrice: "Please Select Another Zone",
		file:"Please Upload Banner",
		userWeburl: "Please Enter valid Url",
		userAltText: "Please Enter Alternate Text"
	}
});


});

/*$(function(){
    $('#adAdv').click(function(){
    	$('#adAdv').hide();
    });
});*/

/*jQuery('#addAdvertiser').submit(function() { alert('asdfasdf');
    $.ajax({
        url: '/whatever.php',
        beforeSend: function() { $('#loader').show(); },
        complete: function() { $('#loader').hide(); }
    });
    return false;
});*/


//jQuery(document).ready(function() {
//	
//jQuery("#updZones").validate({
//	rules: {
//		zoneNameUpd: "required"
//	},
//	messages: {
//		zoneNameUpd: "Enter Zone Name"
//	}
//});
//
//});
//jQuery.fn.wp_display_notices = function(options) {
//  options = jQuery.extend({
//                              message_item: "",
//                              default_class: ""
//                          }, options);
//  var $this_form = this;
//  if(options.message_item != "") {
//    var $message_item = jQuery(options.message_item);
//   // $this_form.parent().find(".wpt-display-notices").remove();
//    $this_form.before($message_item);
//  }
//}
//
//var $loader = jQuery('<div class="wpt-loader"><table>\
//  <tr>\
//    <td><span class="wpt-loading-icon"></span><span class="wpt-loading-text">Loading...</span></td>\
//  </tr>\
//</table></div>');
//
//
//jQuery(function() {
//  
//  function position_loader($loader) {
//    var window_height = jQuery(window).height();
//    var loader_height = $loader.outerHeight(true);
//
//    var loader_top = jQuery(window).scrollTop() + (window_height - loader_height)/2;
//    $loader.offset({ top: loader_top });
//  }
//  
//  jQuery("form.setting-section input:submit").live("click", function(){ 
//    var $form = jQuery(this).parents("form:first");
//    var $local_loader = $loader.clone();
//    jQuery(".wpt-section:first").before($local_loader);
//    position_loader($local_loader);
//
//    var form_submission_data = (jQuery(this).attr("name")) ? "&"+jQuery(this).attr("name")+"="+jQuery(this).val() : "";
//    var form_data = $form.serialize()+"&ajax=true"+form_submission_data;
//    jQuery.ajax({
//      url: ajaxurl,
//      type: 'POST',
//      data: form_data,
//      dataType: "json",
//      success: function (response_data) {
//        $form.wp_display_notices({
//          message_item: response_data.notice
//        });
//        $local_loader.remove();
//      }
//    });
//    return false;
//  });
//  
//
//});
