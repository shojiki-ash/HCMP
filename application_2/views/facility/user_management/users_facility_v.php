		<style type="text/css" title="currentStyle">
			@import "<?php echo base_url(); ?>DataTables-1.9.3 /media/css/jquery.dataTables.css";
		</style>
        <script src="<?php echo base_url()?>DataTables-1.9.3/media/js/jquery.dataTables.min.js" type="text/javascript"></script>
        <script src="<?php echo base_url()?>DataTables-1.9.3/media/js/jquery.dataTables.editable.js" type="text/javascript"></script>
        <script src="<?php echo base_url()?>DataTables-1.9.3/media/js/jquery.jeditable.js" type="text/javascript"></script>
    
        
        
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
                                                                        	alert(value)
                                                                            return value; //Simulation of server-side response using a callback function
                                                                        }//Remove this line in your code
                                                ,

                     aoTableActions: [
										{
										    sAction: "EditData",
										    sServerActionURL: "<?php //echo base_url().'product_controller/update_product' ?>",
										    oFormOptions: { autoOpen: false, modal: true}
										}
									],
                     sUpdateURL: "<?php //echo base_url().'product_controller/update_product' ?>",
                    
                     oAddNewRowButtonOptions: {	label: "Add...",
													icons: {primary:'ui-icon-plus'} 
									},
					oDeleteRowButtonOptions: {	label: "", 
													//icons: {primary:'ui-icon-trash'}
									},
					 sAddURL: "<?php echo base_url().'user_management/create_new_facility_user' ?>",				 			
                     sAddHttpMethod: "POST", //Used only on google.code live example because google.code server do not support POST request
                    // sDeleteURL: "#",
                     // sDeleteHttpMethod: "", //Used only on google.code live example because google.code server do not support POST request
                     sAddDeleteToolbarSelector: ".dataTables_length",
                    
                 });

		    });
		</script>
		
		<style>
			
			.form{
			 width: 100%;
			}
		</style>
		<div class="dialogA">
		 <form id="formEditData" action="<?php echo base_url().'user_management/edit_facility_user' ?>" title="Update User" >
		<input type="hidden" name="id" id="id"  class="DT_RowId" />
		<input type="hidden" rel="0" />
       <label for="name">First Name</label><br />
	<input type="text" name="f_name" id="f_name"  rel="1" />
        <br />
        <label for="name">Other Name</label><br />
	<input type="text" name="o_name" id="o_name"  rel="2" />
        <br />
        <label for="product name">User Name</label><br />
	<input type="text" name="user_name" id="user_name"  rel="3" />
        <br />
         <label for="desc">Status</label><br />
	<select name="status" id="status" rel="4">
                <option value="1">Active</option>
                <option value="0">Inactive</option>
        </select>
        <br />
         <label for="desc">User Type</label><br />
	<select name="user_type" id="user_type" rel="5">
		<?php 
		foreach($user_type as $data1){
			echo "<option value=$data1->id>$data1->level</option>";
			
		}
		?>
		</select>
        <br />
      
         <label for="desc">Email</label><br />
	<input type="text" name="email" size="50" rel="6"/>
	
        <br />
                        <label for="version">Phone No</label><br />
       <input type="text" name="phone_no"  id="phone_no" rel="7"/>
        <br />
				<span class="datafield" style="display:none" rel="8"><a class="table-action-EditData">Edit</a></span>
		<br />
		<br />
		<hr />		
        <button id="formEditDataOk" type="submit">Ok</button>
		<button id="formEditDataCancel" type="button">Cancel</button>
		<br />
</form>
</div>
 <form id="formAddNewRow"  action="#"  title="Add new User" style="width:500px;" >
 	 <label for="name">First Name</label><br />
 	 <input type="hidden" rel="0" />
	<input type="text" name="f_name" size="70" id="f_name"  rel="1" />
        <br />
        <label for="name">Other Name</label><br />
	<input type="text" name="o_name" id="o_name" size="40"  rel="2" />
        <br />
         <label for="desc">Email</label><br />
	<input type="text" name="email" size="50"  id="email" rel="6"/>
        <br />
        <label for="product name">User Name</label><br />
	<input type="text" name="user_name" size="50" id="user_name"  rel="3" />
	<label id="feedback"></label>
        <br />
         <label for="desc">User Type</label><br />
	<select name="user_type" id="user_type" rel="5">
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
	<select name="status" id="status" rel="4">
                <option value="1">Active</option>
                <option value="0">Inactive</option>
        </select>
        <br />
				<span class="datafield" style="display:none" rel="8"><a class="table-action-EditData">Edit</a></span>
				
</form>
<table id="example" width="100%">
	       <thead>
			<tr>
				<th>User Id</th>
				<th><strong>First Name</strong></th>
				<th><strong>Other Name</strong></th>
				<th><strong>Username</strong></th> 
				<th>Status</th>
				<th>User Type</th>
				<th>Email</th>
				<th>Phone No</th>
				<th>Action</th>	
			</tr>
			</thead>
			<tbody>
			<?php foreach( $result as $row):
				if($row->status==1){
					 echo '<tr id="'.$row->id.'">
					 <td>'.$row->id.'</td>
				<td>'.$row->fname.'</td><td> '.$row->lname.' </td>
				<td>'.$row->username.' </td> 
				
				<td>'?><?php if ($row->status==1){
					echo 'Active </td>';
				}else{
					echo 'In Active </td>';
				}?><?php 

				foreach($row->u_type as $test){echo '<td>'. $test->level.'</td>';}
				echo'
				<td>'.$row->email.'</td>
				<td>'.$row->telephone.'</td>
				
				<td><a id="'.$row->id.'" title="reset" href="#" class="ulink">Reset Password</a>|
				<a class="table-action-EditData link" >Edit</a>
				'?>|<?php if ($row->status==1){
					echo '<a id="'.$row->id.'" title="deactive" href="#" class="ulink">Deactivate</a>';
				}else{
					echo '<a id="'.$row->id.'" title="active" href="#" class="ulink">Activate</a>';
				}?><?php echo '</td>
				
			</tr>';
			}else{
				echo '<tr id="'.$row->id.'"  style="background-color:#D3D3D3">
				<td>'.$row->id.'</td>
				<td>'?><?php echo $row->fname.'</td><td> '.$row->lname?><?php echo '</td>
				<td>'?><?php echo $row->username?><?php echo '</td> 
				<td>'?><?php if ($row->status==1){
					echo 'Active</td>';
				}else{
					echo 'In Active</td>';
				}?><?php 
				foreach($row->u_type as $test)
				{
					echo '<td>'. $test->level.'</td>';
                }
				echo'
				<td>'.$row->email.'</td>
				<td>'.$row->telephone.'</td>
				</td>
				<td><a id="'.$row->id.'" title="reset" href="#" class="ulink">Reset Password</a>|
				<a class="table-action-EditData link" >Edit</a>
				'?>|<?php if ($row->status==1){
					echo '<a id="'.$row->id.'" title="deactive" href="#" class="ulink">Deactivate</a>';
				}else{
					echo '<a id="'.$row->id.'" title="active" href="#" class="ulink">Activate</a>';
				}?><?php echo '</td>
				
			</tr>';
			}?>
		<?php
 endforeach;
	?>
	</tbody>
		</table>