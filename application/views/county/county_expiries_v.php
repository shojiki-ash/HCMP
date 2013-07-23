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
box-shadow: 0 0 5px #888888;
border-radius: 5px;
width:98%; 
height:80%; 
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
         	  var name=$(this).attr("type");

         	  if(name=='view-potential'){
              var url = "<?php echo base_url().'stock_expiry_management/district_potential_expiries/'?>"+id;
         	  }

         	  if(name=='view-expiries'){
            var url = "<?php echo base_url().'stock_expiry_management/district_expiries/'?>"+id;
         	  }

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


      
    var chart = new FusionCharts("<?php echo base_url()."scripts/FusionCharts/Bar2D.swf"?>","ChartId", "100%", "50%", "0", "1" );
    var url = '<?php echo base_url()."report_management/expired_commodities_chart"?>'; 
    chart.setDataURL(url);
    chart.render("chart1");

    var chart = new FusionCharts("<?php echo base_url()."scripts/FusionCharts/Line.swf"?>", "ChartId2", "100%", "50%", "0", "0");
    var url = '<?php echo base_url()."report_management/cost_of_expired_commodities_chart"?>'; 
    chart.setDataURL(url);
    chart.render("chart2");
 });
	
			
    $("#3months").click(function(){
      var url = "<?php echo base_url().'stock_expiry_management/county_get_potential_expiries'?>";
      var id  = $(this).attr("id");
      //alert (id);
        $.ajax({
          type: "POST",
          data: {'id':  $(this).attr("id"),},
          url: url,
          beforeSend: function() {
            $(".tab-1 tbody").html("");
          },
          success: function(msg) {
            $(".tab-1 tbody").html(msg);
            
             }
         });
    });
    $("#6months").click(function(){
      var url = "<?php echo base_url().'stock_expiry_management/county_get_potential_expiries'?>";
      var id  = $(this).attr("id");
      //alert (id);
        $.ajax({
          type: "POST",
          data: {'id':  $(this).attr("id"),},
          url: url,
          beforeSend: function() {
            $(".tab-1 tbody").html("");
          },
          success: function(msg) {
            $(".tab-1 tbody").html(msg);
            
             }
         });
    });
    $("#12months").click(function(){
      var url = "<?php echo base_url().'stock_expiry_management/county_get_potential_expiries'?>";
      var id  = $(this).attr("id");
      //alert (id);
        $.ajax({
          type: "POST",
          data: {'id':  $(this).attr("id"),},
          url: url,
          beforeSend: function() {
            $(".tab-1 tbody").html("");
          },
          success: function(msg) {
            $(".tab-1 tbody").html(msg);
            
             }
         });
    });
       

	
</script>

<div id="dialog-form"></div>

<div class="leftpanel"><h3 class="accordion" id="leftpanel">Expiries<span></span></h3>
<div class="multiple_chart_content" id="chart1"></div>
<div class="multiple_chart_content" id="chart2"></div></div>

<div id="tabs" class="main">
	<ul>
		<li>
			<a href="#tab-2">Expired Commodities</a>
		</li>
		<li>		
			<a href="#tab-1">Potential Expiries</a>
		</li>		
	</ul>
<?php if (count($potential_expiries>0)) :?>

<div id="tab-1">	 
<fieldset>
	<h2>Commodities Expiring in the Next:</h2>  
	<button id="3months" class="awesome blue" style="margin-left:1%; margin-top: 0.5em;";> Next 3 Months</button> 
	<button id="6months" class="awesome blue" style="margin-left:1%; margin-top: 0.5em;";> Next 6 Months</button>
	<button id="12months" class="awesome blue" style="margin-left:1%; margin-top: 0.5em;";> Next 12 Months</button>  
</fieldset>
	
<table class="data-table">	

  <?php foreach ($potential_expiries as $item) {?>
	<tr>
		<th>District Name</th>
		<th>No. of Facilities with Potential Expiries</th>
		<th>Cost of Potential Expiries</th>
		<th>Action</th>
	</tr>			
		<tbody>
			<tr>
			<td><?php echo $item['district']; ?></td>
			<td><?php echo $item['facility_count']; ?></td>
			<td><?php echo $item['balance']; ?></td>
			<td><a href="" id="pop_up" type='view-potential' name="<?php echo $item['district_id']?>" class="link">View</a></td>
			</tr>
       <tr>
    <th>MFL Code</th>
    <th>Facility Name</th>
    <th>Cost of Expiries</th>
    <th>Action</th>
  </tr>
  <tr><td><?php echo $item['facility_code'];?></td>
      <td><?php echo $item['facility_name'];?></td>
      <td><?php echo $item['balance'];?></td>
      <td><a href=".site_url('stock_expiry_management/county_potential_expiries/'.$item['facility_code'])." class='link'>View</a></td>
      </tr>
			<?php } ?>
		</tbody>
		 
</table>
</div>
<?php else:
  	echo "<div id='notification'>No Records Found</div>";
  endif;
  ?>
  <?php if (count($expired2>0)) :?>
<div id="tab-2">
	<table class="data-table">

  <?php foreach ($expired2 as $item) {?>	
	<tr>
		<th>District Name</th>
		<th>No. of Facilities with Expired Stock</th>
		<th>Cost of Expiries</th>
		<th>Action</th>
	</tr>			
		<tbody>
			<tr>
			<td><?php echo $item['district']; ?></td>
			<td><?php echo $item['facility_count']; ?></td>
			<td><?php echo $item['balance']; ?></td>
			<td><a href="" id="pop_up" type='view-expiries' name='<?php echo $item['district_id']?>' class="link">View</a></td>
			</tr>
      <tr>
    <th>MFL Code</th>
    <th>Facility Name</th>
    <th>Cost of Expiries</th>
    <th>Action</th>
  </tr> 
			<tr>
      <td><?php echo $item['facility_code'];?></td>
      <td><?php echo $item['facility_name'];?></td>
      <td><?php echo $item['balance'];?></td>
      <td><a href=".site_url('stock_expiry_management/expired/'.$item['facility_code'])." class='link'>View</a></td>
      </tr>
      <tr><td></td><td></td><td></td><td></td></tr>
       <?php } ?>
		</tbody>		 
</table>
</div>
</div>
<?php 
 else:
  	echo "<div id='notification'>No Records Found</div>";
  endif;?>
