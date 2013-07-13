<style type="text/css" title="currentStyle">
			@import "<?php echo base_url()?>DataTables-1.9.3 /media/css/jquery.dataTables.css";
		</style>
        <script src="<?php echo base_url()?>DataTables-1.9.3/media/js/jquery.dataTables.min.js" type="text/javascript"></script>
        <script src="<?php echo base_url()?>DataTables-1.9.3/media/js/jquery.jeditable.js" type="text/javascript"></script>
        <script src="<?php echo base_url()?>DataTables-1.9.3/media/js/jquery.validate.js" type="text/javascript"></script>
        <script src="<?php echo base_url()?>DataTables-1.9.3/media/js/jquery.dataTables.editable.js" type="text/javascript"></script>
        <script src="<?php echo base_url()?>DataTables-1.9.3/media/js/jquery.jeditable.ajaxUpload.js" type="text/javascript"></script>
    
        
        
        <script type="text/javascript" charset="utf-8">
		    $(document).ready(function () {
		    	
		   $("#email").live("click keyup", function(event){
		   	var email=encodeURI($(this).val());
		   	 var url = "<?php echo base_url().'user_management/check_user_email' ?>"+'/'+email;
		   	 
          $('#user_name').val(email);
          ajax_request (url);
                    }); 	

		    	$(".ulink").click(function(){
		    			
                   var status=false;
                	var id  = $(this).attr("id"); 
		    		var title=$(this).attr("title");		
		            var url = "<?php echo base_url().'user_management/reset_user_variable' ?>"+'/'+title+"/"+id;
		         
                 
                 var r=confirm("Please confirm");
                if (r==true)
                 {
                   ajax_request (url)	;
                    }
                   else
                      {
  
                         }

		    	});
		    	
		    	function ajax_request (url){
	            var url =url;
	           $.ajax({
                     type: "POST",
                     url: url,
                     beforeSend: function() {
                  $('#feedback').html('');
                      },
                     success: function(msg) {                     	
                            switch (msg){
                     		case 'User name is available':
                     		$('#feedback').html(msg);
                     		break;
                     		case 'User name is already in use':
                     		$('#feedback').html(msg);
                     		case 'Blank email':
                     		return
                     		break;
                     		default:
                     		 alert(msg);
                     	}
                     	
              
                            
                     }
        }); 
}             
		    	
		    	
		    	$('#userfile').customFileInput();	
		        $('#example').dataTable({
		        	                "bJQueryUI": true,		
									"bProcessing": true
									})
                 .makeEditable({
                 	                       aoColumns: [
                                     {  
                                     },
                                 null
                                    ],
                                      sUpdateURL:function(value, settings)
                                                                        {
                                                                            return value; //Simulation of server-side response using a callback function
                                                                        }//Remove this line in your code
                                                ,

                     aoTableActions: [
										{
										    sAction: "EditData",
										    sServerActionURL: "<?php //echo base_url().'product_controller/update_product' ?>",
										    oFormOptions: { autoOpen: false, modal: true }
										}
									],
                     sUpdateURL: "<?php //echo base_url().'product_controller/update_product' ?>",
                    
                     oAddNewRowButtonOptions: {	label: "Add...",
													icons: {primary:'ui-icon-plus'} 
									},
					//oDeleteRowButtonOptions: {	label: "Remove", 
													//icons: {primary:'ui-icon-trash'}
									//},
					 sAddURL: "<?php echo base_url().'user_management/create_new_facility_user' ?>",				 			
                     sAddHttpMethod: "POST", //Used only on google.code live example because google.code server do not support POST request
                    // sDeleteURL: "DeleteData.php",
                     // sDeleteHttpMethod: "GET", //Used only on google.code live example because google.code server do not support POST request
                     sAddDeleteToolbarSelector: ".dataTables_length",
                    
                 });

		    });
		</script>
		 <form id="formEditData" action="<?php echo base_url().'user_management/edit_facility_user' ?>" title="Update User" >
		<input type="hidden" name="id" id="id"  class="DT_RowId" />
<label for="name">First Name</label><br />
 	 <input type="hidden" rel="0" />
	<input type="text" name="f_name" size="40" id="f_name"  rel="1" />
        <br />
        <label for="name">Other Name</label><br />
	<input type="text" name="o_name" id="o_name" size="40"  rel="2" />
        <br />
         <label for="desc">Email</label><br />
	<input type="text" name="email" size="50"  id="email_1" rel="5"/>
        <br />
        <label for="desc">User Name</label><br />
	<input type="text" name="user_name" size="50"  id="user_name_1" rel="6"/>
        <br />
        <label for="product name">Facility Name</label><br />
        
	<select name="facility_code"  class="dropdownsize" rel="3" />
		<?php 
		foreach($facilities as $facility1){
			echo "<option value=$facility1->facility_code>$facility1->facility_name</option>";
			
		}
		?>
	</select>
	
	
	<label id="feedback"></label>
        <br />
         <label for="desc">User Type</label><br />
	<select name="user_type" id="user_type" rel="4">
		<?php 
		foreach($user_type as $data){
			echo "<option value=$data->id>$data->level</option>";
			
		}
		?>
		</select>
        <br />
     <label for="version">Phone No</label><br />
       <input type="text" name="phone_no"  id="phone_no" rel="7" value="254"/>
        <br />
        
          <label for="desc">Status</label><br />
	<select name="status" id="status" rel="8">
                <option value="1">Active</option>
                <option value="0">Inactive</option>
        </select>
        <br />
				<span class="datafield" style="display:none" rel="9"><a class="table-action-EditData">Edit</a></span>
		<hr />		
        <button id="formEditDataOk" type="submit">Ok</button>
		<button id="formEditDataCancel" type="button">Cancel</button>
		<br />
</form>

 <form id="formAddNewRow"  action="#"  title="Add new User">
 	 <label for="name">First Name</label><br />
 	 <input type="hidden" rel="0" />
	<input type="text" name="f_name" size="40" id="f_name"  rel="1" />
        <br />
        <label for="name">Other Name</label><br />
	<input type="text" name="o_name" id="o_name" size="40"  rel="2" />
        <br />
         <label for="desc">Email</label><br />
	<input type="text" name="email" size="50"  id="email" rel="5"/>
        <br />
        <label for="desc">User Name</label><br />
	<input type="text" name="user_name" size="50"  id="user_name" rel="6"/>
	<label id="feedback"></label>
        <br />
        <label for="product name">Facility Name</label><br />
        
	<select name="facility_code" class="dropdownsize" rel="3" />
		<?php 
		foreach($facilities as $facility){
			echo "<option value=$facility->facility_code>$facility->facility_name</option>";
			
		}
		?>
	</select>
        <br />
         <label for="desc">User Type</label><br />
	<select name="user_type" id="user_type" rel="4">
		<?php 
		foreach($user_type as $data){
			echo "<option value=$data->id>$data->level</option>";
			
		}
		?>
		</select>
        <br />
     <label for="version">Phone No</label><br />
       <input type="text" name="phone_no"  id="phone_no" rel="7" value="254"/>
        <br />
        
          <label for="desc">Status</label><br />
	<select name="status" id="status" rel="8">
                <option value="1">Active</option>
                <option value="0">Inactive</option>
        </select>
        <br />
				<span class="datafield" style="display:none" rel="9"><a class="table-action-EditData">Edit</a></span>
				
</form>
		


<table width="100%" id="example">
	<thead>
	<tr>
		<th>User ID</th>
		<th>First Name </th>
		<th>Other Name</th>
		<th>Facility Name</th>
		<th>User Type</th>
		<th>Email</th>
		<th>Username</th>
		<th>Telephone</th>
		<th>Status</th>
		<th>Actions</th>
		
	</tr>
	</thead>
	<tbody>
	<?php
		foreach($result as $row){
	   
?>
	<tr id="<?php echo $row->id;?>">
		<td><?php echo $row->id;?></td>
		<td><?php echo $row->fname;?></td>
		<td><?php echo $row->lname;?></td>
		<td><?php 
		foreach($row->Codes as $facility)
		{echo  $facility->facility_name;}
		 ?></td>
		 <td>
		 	<?php 
		foreach($row->u_type as $test){echo  $test->level;}
		 ?>
		 </td>
		<td><?php echo $row->email;?></td>
		<td><?php echo $row->username;?></td>
		<td><?php echo $row->telephone ?></td>
		<td><?php if ($row->status==1) {
			echo 'Active';
		} else {
			echo 'Inactive';
		}
		 ?></td>
		
		
		<td><a class="table-action-EditData link" >Edit</a></td>
		
		
	</tr> 
	<?php
		}
	?>
	</tbody>
</table>
<?php 

