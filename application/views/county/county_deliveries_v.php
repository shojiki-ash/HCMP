<SCRIPT LANGUAGE="Javascript" SRC="<?php echo base_url();?>Scripts/FusionCharts/FusionCharts.js"></SCRIPT>
<script type="text/javascript" language="javascript" src="<?php echo base_url(); ?>Scripts/jquery.dataTables.js"></script>

<style type="text/css" title="currentStyle">
  
  @import "<?php echo base_url(); ?>DataTables-1.9.3 /media/css/jquery.dataTables.css";

.leftpanel{
width: 22%;
height:auto;
float: left;
}
.multiple_chart_content{
float:left;
box-shadow: 0 0 5px #888888;
border-radius: 5px;
width:98%; 
height:40%; 
padding:0.2em;
margin-top:0.5em;
}
.main{
width: 76%;
min-height:500px;
float: right;
border-left: 1px solid #ccc;
margin-left:2em;
margin-bottom:5em;
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
	border-top: none;
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
		//tabs
		$('#tabs').tabs();

		$( "#dialog-form" ).dialog({
			    autoOpen: false,
				height: 500,
				width: 700,
				modal: true,
				buttons: {
				Close: function() {
					$( this ).dialog( "close" );
				}
				},
			});

		$( "#pop_up" )
		.click(function() {
		 	 var id  = $(this).attr("name");
		     var url = "<?php echo base_url().'stock_expiry_management/district_deliveries/'?>"+id;
		   
        $.ajax({
          type: "POST",
          data: {'district':  id},
          url: url,
          beforeSend: function() {

            $("#dialog-form").html("");
          },
          success: function(msg) {
          
          $("#dialog-form").html(msg);
          $( "#dialog-form" ).dialog( "open" );
             }
         });
         return false;
    });
	
	$(document).ready(function() {
	var chart = new FusionCharts("<?php echo base_url()."scripts/FusionWidgets/HLinearGauge.swf"?>", "ChartId", "100%", "50%", "0", "0");
    var url = '<?php echo base_url()."report_management/lead_time_chart"?>'; 
    chart.setDataURL(url);
    chart.render("chart1");
	
	});
 });

</script>
<div class="leftpanel"><h3 class="accordion" id="leftpanel">Deliveries<span></span></h3>
<div id="details"><table id="orderdetails" class="data-table">
	<tr><th>Order Status</th>
		<th>No. of Orders</th>
	</tr>
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

<div class="multiple_chart_content" id="chart1"></div></div>
<div id="main" class="main">
<table class="data-table">

			<?php foreach ($delivered as $item) {?>	
	<tr>
		<th>District Name</th>
		<th>No. of Facilities with Deliveries</th>
		<th>Order Value</th>
		<th>Action</th>
	</tr>			
		<tbody>
			<tr>
			<td><?php echo $item['district']; ?></td>
			<td><?php echo $item['facility_count']; ?></td>
			<td><?php echo $item['orderTotal']; ?></td>
			<td><a href="" id="pop_up" type='view-deliveries' name="<?php echo $item['district_id']?>" class="link">View</a></td>
			</tr>
			<tr><th>MFL Code</th>
				<th>Facility Name</th>
				<th>Order Value</th>
				<th>Action</th>
			</tr>
			<tr><td><?php echo $item['facility_code']; ?></td>
			<td><?php echo $item['facility_name']; ?></td>
			<td><?php echo $item['orderTotal']; ?></td>
			<td><a href="<?php echo site_url('order_management/moh_order_details/'.$item['id']);?>"class="link">View</a></td></tr>
			<tr><td></td><td></td><td></td><td></td></tr>
			<?php } ?>
			
		</tbody>		 
</table>

</div>
<div id="dialog-form"></div>
