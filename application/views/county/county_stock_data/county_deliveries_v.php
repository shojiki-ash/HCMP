
<script type="text/javascript" language="javascript" src="<?php echo base_url(); ?>Scripts/jquery.dataTables.js"></script>
    <style type="text/css" title="currentStyle">
      
      @import "<?php echo base_url(); ?>DataTables-1.9.3 /media/css/jquery.dataTables.css";
.leftpanel{
width: 17%;
height:auto;
float: left;
padding-left: 1em;
}

 .dash_main{
    width: 80%;
    min-height:100%;
    height:600px;
    float: left;
       -webkit-box-shadow: 2px 2px 6px #888;
	box-shadow: 2px 2px 6px 2px #888; 
    margin-left:0.75em;
    margin-bottom:0em;
    
    }
.accordion {
margin: 0;
padding:5%;
height:15px;
border-top:#f0f0f0 1px solid;
background: #cccccc;
font:normal 1.3em 'Trebuchet MS',Arial,Sans-Serif;
text-decoration:none;
text-transform:uppercase;
background: #29527b; /* Old browsers */
border-radius: 0.5em;
color: #fff; }
table.data-table {
  margin: 10px auto;
  }
  
table.data-table th {
  color:#036;
  text-align:center;
  font-size: 13.5px;
  max-width: 600px;
  }
table.data-table td, table th {
  padding: 4px;
  }
table.data-table td {
  height: 30px;
  width: 130px;
  font-size: 12.5px;
  margin: 0px;
  }
</style>

<script type="text/javascript">
	$(function() {
		
		$('#expiry').dataTable( {
					"bJQueryUI": true,
					"bPaginate": false
				} );
		
     var chart = new FusionCharts("<?php echo base_url()."scripts/FusionWidgets/AngularGauge.swf"?>", "ChartId5", "100%", "80%", "0", "0");
    var url = '<?php echo base_url()."report_management/cummulative_fill_rate_chart"?>'; 
    chart.setDataURL(url);
    chart.render("chart8");

       var chart = new FusionCharts("<?php echo base_url()."scripts/FusionWidgets/HLinearGauge.swf"?>", "ChartId8", "100%", "20%", "0", "0");
    var url = '<?php echo base_url()."report_management/lead_time_chart_county"?>'; 
    chart.setDataURL(url);
    chart.render("chart9");
    });
       

	
</script>

<div class="leftpanel">
<h3 class="accordion" id="leftpanel">Deliveries<span></span></h3>
<div id="details">
	<table  class="data-table">
		<thead>
<tr>
	    <th>Order Status</th>
		<th>No. of Orders</th>
	</tr>
	</thead>
	<tbody>
		<?php foreach ($order_counts as $item) {
			$pending_orders=$item['pending_orders'];
			$approved_orders=$item['approved_orders'];
			$delivered_orders=$item['delivered_orders'];

		} ?>

		<tr><td>Pending Approval</td><td><?php echo $pending_orders; ?></td></tr>
			<tr><td>Pending Delivery</td><td><?php echo $approved_orders; ?></td></tr>
			<tr><td>Delivered</td><td><?php echo $delivered_orders; ?></td></tr>
			
			
	</tbody>
</table>

</div>
<div class='label label-info'>Orders Fill Rate</div>
<div id="chart8"></div>
<div class='label label-info'>Orders Lead Time</div>
<div id="chart9"></div>
</div>


<div class="dash_main" style="overflow: scroll">
	<div class='label label-info'> Below are deliveries made for orders placed</div>
	<table width="100%" id="expiry">
		<thead>
		<tr>
			<th>District</th>
			<th>Health Facility</th>
			<th>MLF No.</th>
			<th>Year</th>
			<th>Order Value (KSH)</th>
			<th>Received Value (KSH)</th>
			<th>Fill Rate %</th>
			<th>Lead Time</th>
			<th>Action</th>
		</tr>
		</thead>
		<?php
		foreach($delivered as $delivered_details):
			$mfl=$delivered_details['facility_code'];
			$name=$delivered_details['facility_name'];
			$order_date=$delivered_details['orderDate'];
			$district=$delivered_details['district'];
			$year=$delivered_details['mwaka'];
			$order_total=$delivered_details['orderTotal'];
			$order_total=number_format($order_total, 2, '.', ',');
			$delivery_total=$delivered_details['total_delivered'];
			$delivery_total=number_format($delivery_total, 2, '.', ',');
			$fill_rate=$delivered_details['fill_rate'];
			$link=base_url().'order_management/moh_order_details/'.$delivered_details['id'];
		echo <<<HTML_DATA
<tr>
<td>$district</td>
<td>$name</td>
<td>$mfl</td>
<td>$year</td>
<td>$order_total</td>
<td>$delivery_total</td>
<td>$fill_rate</td>
<td></td>
<td><a href='$link' class='link'>View</a></td>
</tr>
HTML_DATA;
			
			endforeach;
		
		
		?>
		
		<tbody>
			
		</tbody>
		
	</table>


</div>

