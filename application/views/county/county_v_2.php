<style>
  .dash_container {
		width: 100%;
		height:650px;
		padding-top:1%;
		
	}

.column-left { margin-left:5px;margin-top:10px;width: 25%;height:100%; float:left;  }   
.column-center {margin-top:10px; width: 25%;height:100%; float: left; }   
.column-right { margin-right:2px;width: 49%; height:650px; float: left; }



 .div-row{	
   	margin:auto;
   
   }

.left-div{
	margin-top:10px;
	height:20em;
   	width:48%;
   	float:left;
   	border:1px solid #ddd;
   	vertical-align:top;
	display:inline-block;
	
   }
   
 .right-div{
 	margin-top:10px;
    height:20em;
 	width:48%;
   	float:left;
   	border:1px solid #ddd;
   	vertical-align:top;
	display:inline-block;
 } 
 .div-full{
	margin-top:10px;
	height:20em;
   	width:96%;
   	border:1px solid #ddd;
   	vertical-align:top;
	display:inline-block;
   } 
 .border{
 	border:1px solid #ddd;
 }
 
 h3{
   	padding:5px;
   	margin-top:0;
   	background:#ddd;
   	font-size:1.5em;
   	margin-bottom:0;
   }

</style>
  <script type="text/javascript" charset="utf-8">
      
      $(document).ready(function() {
  
		var url = "<?php $year=date('Y'); echo base_url()."report_management/get_stock_status_ajax/consumption" ?>";			
		 div="#chart_1";
		
		ajax_request(url,div);
		
		    	//ajax reuest for the graphs
        var url = "<?php echo base_url()."report_management/get_stock_status_ajax/ajax-request_county"?>";			
		var div="#chart_2";
        ajax_request (url,div);
        
		var url = "<?php echo base_url().'report_management/get_costofexpiries_chart_ajax/county/'?>"
		var div="#chart_3";
		
		ajax_request (url,div);	
		
		$('#desc').change(function() {
         var div="#chart_2";
	
		if($(this).val() =='default') {
			var url = "<?php echo base_url()."report_management/get_stock_status_ajax/ajax-request_county"?>";	
		}else{
		var url = "<?php echo base_url()."report_management/get_stock_status_ajax/ajax-request_county"?>";		
		url=url+"/"+$(this).val();
		}
		ajax_request (url,div)
		
		});
		
		$('#consumption').change(function() {
         var div="#chart_1";

		
		if($(this).val() =='default') {
			var url = "<?php echo base_url()."report_management/get_stock_status_ajax/consumption"?>";		
		}else{
			var url = "<?php echo base_url()."report_management/get_stock_status_ajax/consumption"?>";		
		url=url+"/"+$(this).val();
		
		}
		ajax_request (url,div)
		
		});
		
		
		function ajax_request (url,div){
	var url =url;
	var loading_icon="<?php echo base_url().'Images/loader.gif' ?>";
	 $.ajax({
          type: "POST",
          url: url,
          beforeSend: function() {
            $(div).html("");
            
             $(div).html("<img style='margin-top:-10%;' src="+loading_icon+">");
            
          },
          success: function(msg) {
          $(div).html("");
            $(div).html(msg);           
          }
        }); 
}
    

            var chart = new FusionCharts("<?php echo base_url()."scripts/FusionCharts/Line.swf"?>", "ChartId4", "100%", "80%", "0", "0");
    var url = '<?php echo base_url()."report_management/generate_costofordered_County_chart"?>'; 
    chart.setDataURL(url);
    chart.render("chart_4");

      
     var chart = new FusionCharts("<?php echo base_url()."scripts/FusionWidgets/HLinearGauge.swf"?>", "ChartId8", "100%", "20%", "0", "0");
    var url = '<?php echo base_url()."report_management/lead_time_chart_county"?>'; 
    chart.setDataURL(url);
      chart.render("chart_5");
  });
  </script>
<div class="dash_container">

 
	<div class="column-left border" style="overflow: auto;">
		<h3>Consumption for year <?php echo $year ?></h3>
			<select  class="drop" id="consumption">
			<option value="default">Select Category</option>
      <?php echo $drug_category; ?>
			
	</select>
			<div id="chart_1"></div>
	</div>
 
	<div class="column-center border" style="overflow: auto;">
		<h3>Stock Status as at <?php
		$fechaa = new DateTime($max_date[0]['date_']);
		$today=new DateTime();
        $datea= $fechaa->format(' d  M Y h:i:s A');
		echo $datea;
		?></h3>
			<select id="desc" name="desc" class="drop">
     <option value="default">Select Category</option>
    <?php echo $drug_category; ?>
			
	</select>
	<div id="chart_2"></div>
	</div>
 
	<div class="column-right">
		<div class="div-row">
		<div class="left-div" >
		<h3>Expired Commodities - Trend <?php echo $year ?></h3>
			<div id="chart_3"></div>	
		</div>
		<div class="right-div" style="overflow: auto;">
			<h3>Notifications</h3>
			<?php echo $stats; ////// ?>
		</div>
		</div>
		<div class="div-row">
		<div class="left-div" >
		<h3>Order Analysis Cost</h3>
			<div id="chart_4"></div>	
		</div>
		<div class="right-div" >
			<h3>Lead Time</h3>
			<div id="chart_5" ></div>
		</div>
		</div>
		
		<div class="div-row" >
			<div class="div-full" style="overflow: auto">
				<h3>System coverage</h3>
			<?php echo $coverage_data;  ?>
			</div>
			</div>
			
	</div>
  

</div>