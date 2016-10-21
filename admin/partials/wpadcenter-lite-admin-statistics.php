<style type="text/css">#ui-datepicker-div { display: none}</style>
	<div class="wpa-section wpa-shadow wpa-spacing-top">
	<div class="wpa-logo-section clearfix">
		<span class="left"><img src="<?php echo WP_ADCENTER_ADMIN_URL.'images/logo.gif';?>" width="203" height="58" alt="wp adcenter" /></span>
		<h2>Statistics</h2>	
	</div>

	<div class="wpa-section clearfix">
		<h1 class="clearfix">
			<span class="close-icon" id="minus-btn"><span class="heading">View Statistics</span></span><br>
			<?php 
			if(!empty($_POST['STATS'])){
			echo '<p align="left" font size="40">All Statistics have been deleted successfully</p>';
			 }
			?>
		</h1>
	<?php 	
	    global $current_user,$wpdb;
		
		$comData = wpadl_getCampaign();
		$data = wpadl_getCampaignCurrentUser($current_user->ID);
		if(!current_user_can('level_10'))
		{ 
            $name = $wpdb->get_results($wpdb->prepare('SELECT * FROM wp_campaign WHERE user_id= %d',$current_user->ID));
			if(count($name)>0) {
				$campaignId = $_REQUEST['campaign'];}
			else{
			
				$campaignId = $name[0]->id;
			}
			//$campaignId = $name[0]->id;
		}
		else 
		{	
			$campaignId = !empty($_REQUEST['campaign'])?$_REQUEST['campaign']:'';
			
		}
		
		$statsAdvertiserName = wpadl_statsAdvertiserName($campaignId);
		$statsCampaignName = wpadl_statsCampaignName($campaignId);

		     $sDate =!empty($_REQUEST['statsStartDate'])? $_REQUEST['statsStartDate']:'';
		     $eDate = !empty($_REQUEST['statsEndDate'])?$_REQUEST['statsEndDate']:'';
		$sql = wpadl_getCampaignResult($campaignId,$sDate,$eDate);

		for($i=0;$i<count($sql);$i++)
		  {
		  $impr[]=$sql[$i]['impressions'];
		  $click[]=$sql[$i]['count'];
		  $graphdate[]=$sql[$i]['date'];
		  }
		  if(!empty($_POST['SUBMIT']))
		  {
		  	$graphValue=$_POST['SUBMIT'];
		  }
		  else
		  {
		  	$graphValue='view';
		  }
		  if(!empty($_POST['STATS']))
		  {
		        $table_stats = $wpdb->prefix ."adstats"; 
		        $wpdb->query("delete from $table_stats ");
		  }?>
		  <script type="text/javascript">
		  jQuery(function(){
			  jQuery('#clear-stats').click(function(e){
				  var x = confirm("Are you sure you want to delete?");
				   if(x == true){
					}else{
						e.preventDefault();
					}
				});  
		});
		  
		 </script>
				  			
		<form class="setting-section" id="viewStatistics" name="viewStatistics" method="post">
			<div class="advertisement-form">
			<?php if(current_user_can('level_10')) {?>
                <div class="row1">
                    <div class="col1">Campaign</div>
                    <div class="col2">
                         <select name="campaign" id="campaign">
						 <option value="">--Select--</option>
                        <?php for($i=0;$i<count($comData);$i++) {?>	
	                           <option value="<?php echo !empty($comData[$i])?$comData[$i]->id:''?>" <?php if( (!empty($_REQUEST['campaign']) ? $_REQUEST['campaign'] : '' ) == $comData[$i]->id) {?> selected="selected"<?php }?>><?php echo $comData[$i]->name?></option>
						<?php } ?>
                        </select>
                    </div>
                    <div class="clr"></div>
                </div>
		<?php }?>
                
                <?php if(!current_user_can('level_10')&&(count($name)>0)) {?>
                <div class="row1">
                    <div class="col1">Campaign</div>
                    <div class="col2">
                         <select name="campaign" id="campaign">
				<option value="">--Select--</option>
                        <?php for($i=0;$i<count($data);$i++) {?>	
		<option value="<?php echo $data[$i]->id?>" <?php if($_REQUEST['campaign']==$data[$i]->id) {?> selected="selected"<?php }?>><?php echo $data[$i]->name?></option>
			<?php } ?>
                        </select>
                    </div>
                    <div class="clr"></div>
                </div>
		<?php }?>
			
                <div class="row1">
                    <div class="col1">Start Date</div>
                    <div class="col2">
                         <input type="text" class="textbox" name="statsStartDate" id="statsStartDate" value="<?php echo !empty($_REQUEST['statsStartDate'])?$_REQUEST['statsStartDate']:'';?>"/>
                    </div>
                    <div class="clr"></div>
                </div>
			
                <div class="row1">
                    <div class="col1">End Date</div>
                    <div class="col2">
                         <input type="text" class="textbox" name="statsEndDate" id="statsEndDate"  value="<?php echo !empty($_REQUEST['statsEndDate'])?$_REQUEST['statsEndDate']:'';?>"/>
                    </div>
                    <div class="clr"></div>
                </div>
                <div class="clr"></div>
			</div>			
			<!-- <div class="statisticsImg" id="chartImage"> -->
<?php $_REQUEST['campaign'] = $campaignId; 
?>

<?php if(!empty($_REQUEST['campaign']) && isset($_POST['SUBMIT']) && $_POST['SUBMIT']==$graphValue ) : 
	$impression=get_option('impression');
	?>
    <div style="text-align: center;">
        <span style="color: #4572A7;">Advertiser Name :    </span> <span style="color: #aa4643;"><?php echo ucfirst($statsAdvertiserName[0]->name); ?></span><br>
        <span style="color: #4572A7;">Campaign Name :      </span> <span style="color: #aa4643;"><?php echo ucfirst($statsCampaignName[0]->name);?></span><br>
        <p style="float:right;color: #4572A7;"> - Impressions</p><div class="clr"></div><p style="color: #aa4643;float:right;"> - Clicks</p>
    </div>
    <canvas id="canvas" class="statisticsImg" style="width: 800px; height: 350px; margin: 0 auto"></canvas>
    <script type="text/javascript">

        var impression_display=<?php echo $impression;?>;

        var impr=new Array();
        impr= <?php echo json_encode($impr); ?>;

        var clicks=new Array();
        clicks= <?php echo json_encode($click); ?>;

        var date=new Array();
        date= <?php echo json_encode($graphdate); ?>;

        var lineChartData = {
            labels : date,
            datasets : [
                {
                    label: "Impressions",
                    fillColor : "rgba(220,220,220,0.5)",
                    strokeColor : "rgba(220,220,220,1)",
                    pointColor : "rgba(220,220,220,0.5)",
                    pointStrokeColor : "#fff",
                    pointHighlightFill : "#fff",
                    pointHighlightStroke : "rgba(220,220,220,1)",
                    data : impr
                },
                {
                    label: "Clicks",
                    fillColor : "#aa4643",
                    strokeColor : "rgba(151,187,205,1)",
                    pointColor : "#aa4643",
                    pointStrokeColor : "#fff",
                    pointHighlightFill : "#fff",
                    pointHighlightStroke : "rgba(151,187,205,1)",
                    data : clicks
                }
            ]
        }

        window.onload = function(){
            var ctx = document.getElementById("canvas").getContext("2d");
            window.myLine = new Chart(ctx).Line(lineChartData, {
                responsive: true
            });
        }
  	</script>
<?php
endif;
?>

	<input type="submit" name="SUBMIT" value="View Graph" id="graph" class="btn-bg2"/>
	<?php if(current_user_can('level_10')){ ?>
		<input type="submit" name="STATS" value="Clear All Statistics" id="clear-stats" class="btn-bg2" />
 	<?php } ?>

	</form>    
	</div>
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
	jQuery('#viewStatistics').slideToggle('fast');
});
</script>
