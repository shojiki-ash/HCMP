<SCRIPT LANGUAGE="Javascript" SRC="<?php echo base_url();?>Scripts/FusionCharts/FusionCharts.js"></SCRIPT>
		<script type="text/javascript" charset="utf-8">
			
			$(document).ready(function() {

		var chart = new FusionMaps("<?php echo base_url()."scripts/FusionMaps/FCMap_KenyaCounty.swf"?>","ChartId", "100%", "100%", "0", "1" );
		var url = '<?php echo base_url()."rtk_management/kenya_county_map"?>'; 
		chart.setDataURL(url);
		chart.render("chart");

	});
	</script>
	<style>
	.chart_content{
		margin:0 auto;
		margin-left: 0px;
	}
	.multiple_chart_content{
		float:left; 
	}
</style>

	<div class="chart_content" style="width:100%;height: 130%">
		
	<div class="multiple_chart_content" style="width:100%; height: 100%"  id="chart"></div>
	
	</div>

	
 
 