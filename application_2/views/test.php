<?php $this->load->helper('url');?>
   <script> 
json_obj = {
				"url" : "<?php echo base_url().'Images/calendar.gif';?>",
				};
	var baseUrl=json_obj.url;
	$(function() {
$('#category_name').change(function(){
			/*
			 * when clicked, this object should populate facility names to facility dropdown list.
			 * Initially it sets a default value to the facility drop down list then ajax is used 
			 * is to retrieve the district names using the 'dropdown()' method used above.
			 */
			$("#drug_name").html("<option>--Select Commodity Name--</option>");
			json_obj={"url":"<?php echo site_url("report_management/get_drug_names");?>",}
			var baseUrl=json_obj.url;
			var id=$(this).attr("value");
		
			dropdown(baseUrl,"category_id="+id,"#drug_name");
		});
		});
		function dropdown(baseUrl,post,identifier){
		
			/*
			 * ajax is used here to retrieve values from the server side and set them in dropdown list.
			 * the 'baseUrl' is the target ajax url, 'post' contains the a POST varible with data and
			 * 'identifier' is the id of the dropdown list to be populated by values from the server side
			 */
			$.ajax({
			  type: "POST",
			  url: baseUrl,
			  data: post,
			  success: function(msg){
			 
			  		var values=msg.split("_")
			  		var dropdown;
					
			  		for (var i=0; i < values.length-1; i++) {
			  			var id_value=values[i].split("*")
			  			dropdown+="<option value="+id_value[0]+">";
						dropdown+=id_value[1];
						dropdown+="</option>";
					};
				//	alert(dropdown);
					$(identifier).append(dropdown);
			  },
			  error: function(XMLHttpRequest, textStatus, errorThrown) {
			       if(textStatus == 'timeout') {}
			   }
			}).done(function( msg ) {
			});
		}
   </script>   
   <div>
	<fieldset>
	<legend>
   			Select filter options
   		</legend>
   		
    	<label >Category Name </label>
        <select id="category_name">
    <option>--Select Category Name--</option>
		<?php foreach ($category as $d_category):?>
		<option value="<?php echo $d_category->id;?>"><?php echo $d_category->Category_Name;?></option>
		<?php endforeach;?>
	</select>  
        <label >Commodity Name </label>
        <select id="drug_name">
    <option>--Select Commodity Name--</option>
	</select>  
	<label >Service Point </label>
	<select id="service_point">
    <option>--Select Service Point--</option>
		<?php foreach ($service_p as $service_p):?>
		<option value="<?php echo $service_p->service_point;?>"><?php echo $service_p->service_point;?></option>
		<?php endforeach;?>
	</select>      
<input type="submit" class="button "  value="Filter" >
<p></p>

</fieldset>    

	<table class="data-table"><thead>
					<tr>
						<th><b>KEMSA Code</b></th>
						<th><b>Description</b></th>
						<th><b>Unit Size</b></th>
						<th><b>Consumption</b></th>
						<th ><b>Opening Balance</b></th>
						<th ><b>Total Receipts</b></th>
					    <th><b>Total issues</b></th>
					    <th><b>Adjustments</b></th>
					    <th><b>Losses</b></th>
					    <th><b>Closing Stock</b></th>
					    <th><b>No days out of stock</b></th>
					    <th><b>Order Quantity</b></th>
					    <th><b>Actual Units</b></th>
					    <th><b>Order cost(Ksh)</b></th>	
					   <th><b>Comment(if any)</b></th>				    
					</tr>
					</thead>
					<tbody>
						
					</tbody>
					</table>					
</div>