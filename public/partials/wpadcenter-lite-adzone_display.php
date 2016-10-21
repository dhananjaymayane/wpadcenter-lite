<?php
function wpadl_displaySingle( $id, $res, $advertise, $size )				// FUNCTION FOR DISPLAYING SINGLE AD BANNER
{  
$autorotatead=get_option('autorotate');

if($autorotatead=="1")
{
static $varcount;
	$con;
	/* Begin Code added By Prashant Walke for ad sliding 17-Jun-2014*/
	?><script>jQuery(document).ready(function(){

		jQuery('#slides<?php echo $varcount?>').cycle({
			fx: 'fade', 			
		

		});
	});
	
</script>
	
	<?php 
	$i=0;
	//	<!-- START of SLIDER -->
	if(count($advertise))
	{  $con = '<div class="main_ad_container ad_container_'.$id.'" style="width: 100%; max-width:'.$size[0].'px; height:auto;  background:#F4F4F4; overflow:hidden; ">';
		  $con.= '<div class="main_ad_adzone_'.$id.'_ad_'.$i.' adzone_ad_'.$id.'" style=" height: 100%">';
		
            $con.='<div id="slider">';
            	$con.='<div class="slides" id="slides'.$varcount.'">';
				
					 for( $i = 0; $i < count( $advertise ); $i++ )
	     	{
	     		if( !current_user_can('level_10') )	{ wpadl_Impression($advertise[$i]); }
			
			$ch_type = wpadl_chkBannerType($advertise[$i]);
			
			if( $ch_type['type'] != 'html' ){$file = wpadl_showBanner( $ch_type['file'], $advertise[$i]->url, $advertise[$i]->target, $advertise[$i]->id );}
	
			elseif( $ch_type['type'] == 'html' ){$file = $ch_type['file'];}

							$con.='<div class="slide" style="width:100%;">';
							 
								$con.= $file;
							$con.='</div>';
					 } 				   
				$con.='</div>';// <!-- end of .slides -->
				 $con.='<div id="slider-pager"></div>';
			$con.='</div>';//			<!-- END of SLIDER --><?
			$con.='</div>';
			$con.= '</div>';
				$varcount++;
	}
	else{
		
		$con = '<div class="main_ad_container ad_container_'.$id.'" style="width: 100%; max-width:'.$size[0].'px; height:auto;  background:#F4F4F4; overflow:hidden; ">';
		$file = '';
		if( empty($advertise) ) $file = wpadl_showSignUpBanner($res[0]->signuplink,$size[1]*2,$res[0]->default_banner);
		
		$con.= '<div class="main_ad_adzone_'.$id.'_ad_'.$i.' adzone_ad_'.$id.'" style=" height: 100%">';
		$con.= $file;
		$con.= '</div>';
		}	
}

else
{	
	$i=0;
	/* End Code added By Prashant Walke for ad sliding 17-Jun-2014*/
	
	/* Begin Code comment By Prashant Walke for ad sliding 17-Jun-2014*/
	if(count($advertise))
	{	// Changed height: auto to actual image fix height as banner images were getting displayed one below another.
		$con = '<div class="main_ad_container ad_container_'.$id.'" style="width: 100%; max-width:'.$size[0].'px; height:'.$size[1].'px;  background:#F4F4F4; overflow:hidden; ">';
		for( $i = 0; $i < count( $advertise ); $i++ )
		{
			if( !current_user_can('level_10') )	{ wpadl_Impression($advertise[$i]); }
			
			$ch_type = wpadl_chkBannerType($advertise[$i]);
			
			if( $ch_type['type'] != 'html' ){$file = wpadl_showBanner( $ch_type['file'], $advertise[$i]->url, $advertise[$i]->target, $advertise[$i]->id );}
	
			elseif( $ch_type['type'] == 'html' ){$file = $ch_type['file'];}
			
			$con.= '<div class="main_ad_adzone_'.$id.'_ad_'.$i.' adzone_ad_'.$id.'" style=" height: 100%">';
			$con.= $file;
			$con.= '</div>';
		}
	
		$con.= '<script type="text/javascript">jQuery(document).ready(function() { ';
		$con.= "jQuery('.main_ad_adzone_".$id."_ad_0').show(); var cur_ad = 0; var val_ads = ".count( $advertise )." - 1;}); </script></div> ";
	
	//}

	}
	else{
		
		$con = '<div class="main_ad_container ad_container_'.$id.'" style="width: 100%; max-width:'.$size[0].'px; height:auto;  background:#F4F4F4; overflow:hidden; ">';
		
		$file = '';
		if( empty($advertise)) $file = wpadl_showSignUpBanner($res[0]->signuplink,$size[1],$res[0]->default_banner);
		
		$con.= '<div class="main_ad_adzone_'.$id.'_ad_'.$i.' adzone_ad_'.$id.'" style=" height: 100%">';
		$con.= $file;
		$con.= '</div>';
	}
	
}	
	return $con;
}

?>