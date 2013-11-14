<script type="text/javascript">
$(document).ready(function(){
	
	  $( "#dialog-confirm" ).dialog({
      resizable: false,
      autoOpen: false,
      height:140,
      modal: true,
      buttons: {
        "Delete all items": function() {
        	window.location="<?php echo site_url('stock_management/reset_facility_details');?>";	
          $( this ).dialog( "close" );
        },
        Cancel: function() {
          $( this ).dialog( "close" );
        }
      }
    });
	
		$("#dialog" ).dialog({
		  
            title: "facility Reporting Details",
			 autoOpen: false,
			height: 450,
			width: 800,
			buttons: {
				"Add": function() {	
					},
				Cancel: function() {
					$( this ).dialog( "close" );
				}
			},
			close: function() {
				  
				
			}
		});
	
	    $("#formEditData").validate({
      rules: {
         f_name:  "required",
          o_name:  "required",
          email:   { required: true, email: true },
          phone_no:  "required",
          user_type:  "required"
         },
         messages: {
            f_name: "Required Field",
            o_name: "Required Field",
            phone_no: "Required Field",
            email: "Input the correct format",
            user_type: "Required Field",
         }
     });
		    	
			    	
		    	//email bind event 
		   $("#email").live("click keyup", function(event){
		   	var email=encodeURI($(this).val());
		   	 var url = "<?php echo base_url().'user_management/check_user_email' ?>"+'/'+email;
		   	 
          $('#user_name').val(email);
          ajax_request (url);
                    }); 
                   
		
		
		   $("#user_profile" ).click(function() {		   	
		  
         var url = "<?php echo base_url().'user_management/get_user_profile' ?>"
         
          $.ajax({
          type: "POST",
          data: "ajax=1",
          url: url,
          beforeSend: function() {
            $("#dialog").html("");
          },
          success: function(msg) {
         
            $("#dialog").html(msg);
            $("#dialog" ).dialog( "open" );
           
          }
        });
        return false;
        
                
            });
            
               $("#facility_reset" ).click(function() {		   	
		  
    $( "#dialog-confirm" ).dialog( "open" );
});
      
            
            /////ajax request function 
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
                     		$('#feedback').html("<label class='error_2'>"+msg+"</label>");
                     		break;
                     		case 'User name is already in use':
                     		$('#feedback').html("<label class='error'>"+msg+"</label>");
                     		case 'Blank email':
                     		return
                     		break;
                     		default:
                     		 alert(msg);
                     	}
                     	
              
                            
                     }
                    }); 
                     }  
});
</script>
	<div id="dialog-confirm" title="Delete facility data?">
  <p><span class="ui-icon ui-icon-alert" style="float: left; margin: 0 7px 20px 0;"></span>All facility data will be permanently deleted and cannot be recovered!. Are you sure?</p>
</div>
	<div id="left_content">
		<div id="dialog"></div> 
		<fieldset>
		<legend>Actions</legend>
		<div class="activity edit">
	    <a href="<?php echo site_url('stock_management/get_facility_stock_details');?>"><h2>Edit stock details</h2>	</a>
		</div>
			<div class="activity update">
	    <a href="<?php echo site_url('stock_management/historical_stock_take');?>"><h2>Historical Stock Data</h2></a>
		</div>
		<div class="activity users">
		<a id="user_profile" href="#"><h2>User Profile</h2></a>
		</div>
		
	
		
			<div class="activity update">
	    <a id="facility_reset"><h2>Reset Facility Stock Data</h2></a>
		</div>
	
			<div class="activity update">
	    <a href="<?php echo site_url('stock_management/facility_add_stock_data');?>"><h2>Add Facility Stock Data</h2></a>
		</div>
		    <div class="activity update">
      <a href="<?php echo site_url('report_management/facility_evaluation');?>"><h2>Perform HCMP Training Evaluation</h2></a>
    </div>
		</fieldset>
	</div>