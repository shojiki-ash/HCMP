<script type="text/javascript" language="javascript" src="<?php echo base_url();  ?>Scripts/jquery.dataTables.js"></script>
		<style type="text/css" title="currentStyle">
			
			@import "<?php echo base_url(); ?>DataTables-1.9.3 /media2/css/jquery.dataTables.css";
		</style>	
		<style>

			.warning2 {
	background: #FEFFC8 url('<?php echo base_url()?>Images/pdf-icon.jpg') 20px 50% no-repeat;
	border: 1px solid #F1AA2D;
	}
		</style>
<script>
/******************************************data-table set up*********************/
/* Define two custom functions (asc and desc) for string sorting */
			jQuery.fn.dataTableExt.oSort['string-case-asc']  = function(x,y) {
				return ((x < y) ? -1 : ((x > y) ?  1 : 0));
			};
			
			jQuery.fn.dataTableExt.oSort['string-case-desc'] = function(x,y) {
				return ((x < y) ?  1 : ((x > y) ? -1 : 0));
			};

	   $(document).ready(function() {
//[ [0,'asc'], [1,'asc'] ]
    	$('#main1').dataTable( {
    		"bSort": false,
					"bJQueryUI": true,
                   "bPaginate": false
				} );
    
});
</script>
<?php
$table_body="";
$total_fill_rate=0;
$order_value =0;

   $dStart = new DateTime(date($dates["orderDate"]));
   $dEnd  = new DateTime(date($dates["deliverDate"]));
   $dDiff = $dStart->diff($dEnd);
  // echo $dDiff->format('%R'); // use for point out relation: smaller/greater
   $date_diff= $dDiff->days;

 $tester= count($detail_list);

      if($tester==0){
      	
      }
	  else{
	  	

      
		foreach($detail_list as $rows){
			//setting the values to display
			 $received=$rows->quantityRecieved;
			 $price=$rows->price;
			 $ordered=$rows->quantityOrdered;
			 $code=$rows->kemsa_code;
			 
			 $total=$price* $ordered;
			 
			 
			 
		     if($ordered==0){
				$ordered=1;
			}
		    $fill_rate=round(($received/$ordered)*100,0,PHP_ROUND_HALF_UP);
	        $total_fill_rate=$total_fill_rate+$fill_rate;
		 
		
		 foreach($rows->Code as $drug) {
		 	
			 $drug_name=$drug->Drug_Name;
			 $kemsa_code=$drug->Kemsa_Code;
			 $unit_size=$drug->Unit_Size;
			 
			foreach($drug->Category as $cat){
				
			$cat_name=$cat;		
			}	 
		}
		 switch ($fill_rate) {
		case $fill_rate==0:
		 $table_body .="<tr style=' background-color: #FBBBB9;'>";
		 $table_body .= "<td>$cat_name</td>";
	     $table_body .= '<td>'.$drug_name.'</td><td>'. $kemsa_code.'</td>'.'<td>'.$unit_size.'</td>';
		 $table_body .='<td>'. $price.'</td>';
		 $table_body .='<td>'.$ordered.'</td>';
		 $table_body .='<td>'.number_format($total, 2, '.', ',').'</td>';
		 $table_body .='<td>'.$received.'</td>';	
		 $table_body .='<td>'.$fill_rate .'% '.'</td>';
		 $table_body .='</tr>'; 
				 break;  	
				 
		 case $fill_rate<=60:
		 $table_body .="<tr style=' background-color: #FAF8CC;'>";
		 $table_body .= "<td>$cat_name</td>";
	     $table_body .= '<td>'.$drug_name.'</td><td>'. $kemsa_code.'</td>'.'<td>'.$unit_size.'</td>';
		 $table_body .='<td>'. $price.'</td>';
		 $table_body .='<td>'.$ordered.'</td>';
		 $table_body .='<td>'.number_format($total, 2, '.', ',').'</td>';
		 $table_body .='<td>'.$received.'</td>';	
		 $table_body .='<td>'.$fill_rate .'% '.'</td>';
		 $table_body .='</tr>'; 
				 break;  
				 
				 case $fill_rate==100.01 || $fill_rate>100.01:
		 $table_body .="<tr style=' background-color: #FBBBB9;'>";
		 $table_body .= "<td>$cat_name</td>";
	     $table_body .= '<td>'.$drug_name.'</td><td>'. $kemsa_code.'</td>'.'<td>'.$unit_size.'</td>';
		 $table_body .='<td>'. $price.'</td>';
		 $table_body .='<td>'.$ordered.'</td>';
		 $table_body .='<td>'.number_format($total, 2, '.', ',').'</td>';
		 $table_body .='<td>'.$received.'</td>';	
		 $table_body .='<td>'.$fill_rate .'% '.'</td>';
		 $table_body .='</tr>'; 
				 break;
				  
			 case $fill_rate==100:
		 $table_body .="<tr style=' background-color: #C3FDB8;'>";
		 $table_body .= "<td>$cat_name</td>";
	     $table_body .= '<td>'.$drug_name.'</td><td>'. $kemsa_code.'</td>'.'<td>'.$unit_size.'</td>';
		 $table_body .='<td>'. $price.'</td>';
		 $table_body .='<td>'.$ordered.'</td>';
		 $table_body .='<td>'.number_format($total, 2, '.', ',').'</td>';
		 $table_body .='<td>'.$received.'</td>';	
		 $table_body .='<td>'.$fill_rate .'% '.'</td>';
		 $table_body .='</tr>'; 
				 break;
				 
				 default :
		 $table_body .="<tr>";
		 $table_body .= "<td>$cat_name</td>";
	     $table_body .= '<td>'.$drug_name.'</td><td>'. $kemsa_code.'</td>'.'<td>'.$unit_size.'</td>';
		 $table_body .='<td>'. $price.'</td>';
		 $table_body .='<td>'.$ordered.'</td>';
		 $table_body .='<td>'.number_format($total, 2, '.', ',').'</td>';
		 $table_body .='<td>'.$received.'</td>';	
		 $table_body .='<td>'.$fill_rate .'% '.'</td>';
		 $table_body .='</tr>'; 
				 break;
			
		 }
		 
				  } 
	
	$order_value  = round(($total_fill_rate/count($detail_list)),0,PHP_ROUND_HALF_UP);
		} 

?>
<div>
<div id="notification" style="float: left; height: 5%"> Fill Rate = ( Quantity Received / Quantity Ordered ) * 100</div>
<div style="margin-left: 80%" style="float: right" >
<div class="activity pdf"><h2><a href="<?php echo site_url('report_management/get_order_details_report/'.$this->uri->segment(3).'/'.$this->uri->segment(4));?>">
 Download</h2></div>
</a>
</div>
</div>

<caption ><p style="letter-spacing: 1px;font-weight: bold;text-shadow: 0 1px rgba(0, 0, 0, 0.1);font-size: 14px; " >Facility Order No <?php echo $this->uri->segment(3);?>| KEMSA Order No <?php echo $this->uri->segment(4);?> | Total Order FIll Rate <?php echo $order_value ."%";?>| Order lead Time <?php echo $date_diff;?> day(s)</p></caption>
<table class="data-table" style="margin-left: 0px">
	<tr>
		<td width="50px" style="background-color: #C3FDB8; "></td><td>Full Delivery 100%</td><td width="50px" style="background-color:#FFFFFF"></td><td>Ok Delivery 60%-less than 100%</td><td width="50px" style="background-color:#FAF8CC;"></td><td>Partial Delivery less than 60% </td><td width="50px" style="background-color:#FBBBB9;"></td><td>Problematic Delivery 0% or over 100%</td>
	</tr>

</table>
<table id="main1" width="100%">
	
	<thead>
	<tr>
		<th><strong>Category</strong></th>
		<th><strong>Description</strong></th>
		<th><strong>KEMSA&nbsp;Code</strong></th>
		<th><strong>Unit Size</strong></th>
		<th><strong>Unit Cost Ksh</strong></th>
		<th><strong>Quantity Ordered</strong></th>
		<th><strong>Total Cost</strong></th>
		<th><strong>Quantity Received</strong></th>
		<th><strong>Fill rate</strong></th>
	</tr>
	</thead>
	<tbody>
	<?php
		echo $table_body;
	?>
	</tbody>
</table>