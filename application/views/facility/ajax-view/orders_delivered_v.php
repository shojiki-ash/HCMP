<SCRIPT LANGUAGE="Javascript" SRC="<?php echo base_url();?>Scripts/FusionCharts/FusionCharts.js"></SCRIPT>
<script type="text/javascript" language="javascript" src="<?php echo base_url(); ?>Scripts/jquery.dataTables.js"></script>
		<style type="text/css" title="currentStyle">
			
			@import "<?php echo base_url(); ?>DataTables-1.9.3 /media/css/jquery.dataTables.css";
	</style>
<style>
	.multiple_chart_content{
    float:left;
    width:33%; 
    height:22em; 
    padding:0.2em
    background-color:#0E90D2;
    
    
  }
  .multiple_chart_content h2 {
		background: #b6b6b6; /* Old browsers */
		padding: 5px;
		text-align: center;
		margin: 0 0 0.625em 0;
		border-right-style: inset;
		
	}
	.multiple_chart_content label{
		font-size:12px;
	}

		</style>

		<script type="text/javascript">
		var chart = new FusionCharts("<?php echo base_url()."scripts/FusionCharts/Line.swf"?>", "Chart1", "85%", "80%", "0", "0");
		var url = '<?php echo base_url()."report_management/generate_facilitycostoforders_chart"?>'; 
		chart.setDataURL(url);
		chart.render("costoforderschart");

		</script>


	<div style = "margin-left:40em" class="multiple_chart_content">
<h2 >Cost of Ordered Commodities</h2>
<div id="costoforderschart" style = "float:center"></div>
</div>			
<table id="main" width="100%">
	<thead>
			<tr>
				<th><strong>Facility Order No </strong></th>
				<th><strong>KEMSA Order No </strong></th>
				<th><strong>Order Total Ksh</strong></th>
				<th><strong>Date Ordered</strong></th> 
				<th><strong>Date Reviewed (DPF) </strong></th> 
				<th><strong>Lead Time</strong></th>
				<th><strong>Date Dispatched (KEMSA)</strong></th> 
				<th><strong>Date Received (facility)</strong></th>
				<th><strong>Lead Time</strong></th>
				<th><strong>Average Lead Time</strong></th>
				<th>Action</th>
			</tr>
			</thead>
			<tbody>
			<?php foreach($received as $d1):?>
			<tr>
				<?php echo "<td>$d1->id</td>
				<td>$d1->kemsaOrderid</td>
				<td>$d1->orderTotal</td>";
				 
	
		$orderDate = new DateTime(date($d1->orderDate));
        $dated= $orderDate->format('d  M Y');
		echo "<td>".$dated."</td>";
				
		$date_approval = new DateTime(date($d1->approvalDate));
        $dateb_approval= $date_approval->format('d  M Y');
		echo "<td>".$dateb_approval."</td>";
		
		//$date_diff=$myClass->getWorkingDays($orderDate,$date_approval,0);
         $dDiff = $orderDate->diff($date_approval);
         $date_diff= $dDiff->days;
        echo "<td>".$date_diff." day(s)"."</td>";

		$dispatchDate = new DateTime(date($d1->dispatchDate));
        $datebd= $dispatchDate->format(' d  M Y');
		echo "<td>".$datebd."</td>";
	
		$deliverDate = new DateTime(date($d1->deliverDate));
        $datebd1= $deliverDate->format(' d  M Y');
		echo "<td>".$datebd1."</td>";
		
	    //$date_diff=$myClass->getWorkingDays($dispatchDate,$deliverDate,0);
	     $dDiff = $dispatchDate->diff($deliverDate);
         $date_diff= $dDiff->days;
        echo "<td>".$date_diff." day(s)"."</td>";
        
       // $date_diff=$myClass->getWorkingDays($orderDate,$deliverDate,0);
       	  $dDiff = $orderDate->diff($deliverDate);
         $date_diff= $dDiff->days;
        echo "<td>".$date_diff." day(s)</td>";
        
        echo '<td><a href="'.site_url('order_management/moh_order_details/'.$d1->id.'/'.$d1->kemsaOrderid).'"class="link">View</a></td></tr>';

endforeach;
	?>
	
	</tbody>
		</table>
			
		<script type="text/javascript" charset="utf-8">
			
			$(document).ready(function() {
				/* Build the DataTable with third column using our custom sort functions */
				$('#main').dataTable( {
					"bJQueryUI": true,
					"bPaginate": false
				} );
				} );
	</script>