<script>
	$(function() {
		var chart = new FusionCharts("<?php echo base_url()."scripts/FusionCharts/Bar2D.swf"?>", "ChartId", "85%", "85%", "0", "0");
		var url = '<?php echo base_url()."report_management/get_stock_status/$option/$facility_code"?>'; 
		chart.setDataURL(url);
		chart.render("chart");
		
$("#filter-b" )
			.button()
			.click(function() {
				alert("JAck");
			})
	});
	</script>
		<div id="filter" align="center">
		<fieldset>
	<label>Select Facility</label>
	<select id="facilities">
		<option>--facilities--</option>
		<?php 
		foreach ($facilities as $counties) {
			$id=$counties->id;
			$county=$counties->facility_name;?>
			<option value="<?php echo $id;?>"><?php echo $county;?></option>
		<?php }
		?>
	</select>	
	<input style="margin-left: 10px" type="button" id="filter-b" value="filter" />
	</fieldset>
	</div><div id="chart-area" style="width: 100%; height: 100%">
	<div id="chart" >
		
	</div>
</div>

