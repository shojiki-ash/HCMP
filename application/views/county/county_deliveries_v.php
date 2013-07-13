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
		.button()
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
<div id="dialog-form"></div>
<div class="leftpanel"><h3 class="accordion" id="leftpanel">Deliveries<span></span></h3>
<div class="multiple_chart_content" id="chart1"></div></div>
<div id="main" class="main">
<table class="data-table">	
	<tr>
		<th>District Name</th>
		<th>No. of Facilities with Deliveries</th>
		<th>Order Value</th>
		<th>Action</th>
	</tr>			
		<tbody>
			<?php foreach ($delivered as $item) {?>
			<tr>
			<td><?php echo $item['district']; ?></td>
			<td><?php echo $item['facility_count']; ?></td>
			<td><?php echo $item['orderTotal']; ?></td>
			<td><a href="" id="pop_up" type='view-deliveries' name="<?php echo $item['district_id']?>" class="link">View</a></td>
			</tr>
			<?php } ?>
		</tbody>		 
</table>
</div>