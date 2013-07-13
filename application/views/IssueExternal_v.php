<script type="text/javascript" language="javascript" src="<?php echo base_url(); ?>Scripts/jquery.dataTables.js"></script>
		<style type="text/css" title="currentStyle">
			
			@import "<?php echo base_url(); ?>DataTables-1.9.3 /media/css/jquery.dataTables.css";
		</style>
<style>
.user{
		width:100px;
	}
	.date{
		width:110px;
	}
	
	.user1{
	width:100px;
	background : none;
	border : none;
	text-align: center;
	}
	</style>
        
   <script> 
json_obj = {
				"url" : "<?php echo base_url().'Images/calendar.gif';?>",
				};
	var baseUrl=json_obj.url;
	
	$(function() {
			$('#main').dataTable( {
					"bJQueryUI": true
				} );
		
			
		  $( "#dialog" ).dialog();	
					
		$( "#datepicker" ).datepicker({
			showOn: "button",
			dateFormat: 'd M, yy', 
			buttonImage: baseUrl,
			buttonImageOnly: true
		});
			$( "#dialog" ).dialog();
		$( "#expiry_date" ).datepicker({
			showOn: "button",
			dateFormat: 'd M, yy', 
			buttonImage: baseUrl,
			buttonImageOnly: true
		});
				
		
		$( "#dialog:ui-dialog" ).dialog( "destroy" );
		//confirmation modal window
		$('#qty').keyup(function() {
			
  					var hidden=$('input:[name=avlb_hide]').val();
  					var stock=$('input:text[name=avlb_Stock]').val();
					var issues=$('input:text[name=qty]').val();
					var remainder=hidden-issues;
					
					
					if (remainder<=0) {
						$('input:text[name=qty]').val('');
						$('input:[name=avlb_Stock]').val(hidden);
						alert("Can not issue beyond available stock");
					}else{
						
						$('input:text[name=avlb_Stock]').val(remainder);
					}
					});
		 var checker=0;
		$( "#IssueNow" ).dialog({
		    autoOpen: true,
			height: 300,
			width:1350,
			modal: true,
			buttons: {
				"Donate": function() {
					
					if ($('input:text[name=s11N]').val()=="") {
						
						alert("Please enter S11 No");
						return;
					}
					if ($('input:text[name=mfl]').val()=="") {
						
						alert("Please enter Mfl No");
						return;
					}
					if ($("#desc option:selected").text()=="-Select Drug Name-") {
						
						alert("Please Select Drug");
						return;
					}
					if ($('input:text[name=qty]').val()=="") {
						
						alert("Please enter Quantity to dispense");
						return;
					}
					
					    
          $( "#main" ).dataTable().fnAddData(['<input class="user" type="text" name="S11[]"  value="'+ $('input:text[name=s11N]').val() +'"/>' + '',
             "" + $("#facility option:selected").text() + "" ,
         					"" + $('input:[name=kemsac_1]').val() + "" , 
							"" + $("#desc option:selected").text() + "" ,
							"" + $("#batchNo option:selected").text() + ""+ 
         '<input type="hidden" name="mfl['+checker+']" value="'+$('#facility option:selected').val()+'" /><input type="hidden" name="kemsaCode['+checker+']" value="'+$('input:[name=kemsac]').val()+'" />'+
         '<input type="hidden" name="drugName['+checker+']" value="'+$("#desc option:selected").text()+'" />'+
         '<input type="hidden" name="batchNo['+checker+']" value="'+$("#batchNo option:selected").text()+'" />'+ 
          '<input type="hidden" name="Expiries['+checker+']" value="'+$("#Exp option:selected").val()+'" />'
         					

							,
							
							'' +'<input class="user" type="text" name="Expiries['+checker+']" readonly="readonly" value="'+ $("#Exp option:selected").val() +'"/>' + '' ,
							'' +'<input class="user" type="text" name="AvStck['+checker+']" readonly="readonly" value="'+ $('input:text[name=avlb_Stock]').val() +'"/>' + '' ,
							'' + '<input class="user" type="text" name="Qtyissued['+checker+']" value="'+ $('input:text[name=qty]').val() +'" />' + '' ,
							'' + '<input class="user" type="text" name="date_issue['+checker+']"  value="'+ $('input:text[name=datepicker]').val() +'" />' + '' ,
							
							'' + '<img class="del" src="<?php echo base_url()?>Images/close.png" />' ]); 
						checker =checker+1;
						
						$( this ).dialog( "close" );
        
				},
				Cancel: function() {
					$( this ).dialog( "close" );
				}
			},
			close: function() {
				
			}
			});
			
			$( "#NewIssue" )
			.button()
			.click(function() {
				$( "#IssueNow" ).dialog( "open" );
			});
			
			$( "#finishIssue" )
			.button()
			.click(function() {
				return $myDialog.dialog('open');
				
			});
			
			$('.del').live('click',function(){
    $(this).parent().parent().remove();
});
		
			var $myDialog = $('<div></div>')
    .html('Please confirm the values before saving')
    .dialog({
        autoOpen: false,
        title: 'Confirmation',
        buttons: { "Cancel": function() {
                      $(this).dialog("close");
                      return false;
                },
                "OK": function() { 
                	var checker=0;
                	$("input[name^=Expiries]").each(function() {
                		checker=checker+1;
                		
                	});
                	//alert(checker);
                	if(checker<1){
                		alert("Cannot submit an empty form");
                		$(this).dialog("close"); 
                	}
                	else{
                	$(this).dialog("close"); 
                     $( "#myform" ).submit();
                      return true;	
                	}
                	
                      
                 }
        }
});
			    
    $('#desc').change(function() {
			//alert("test");
				
			var code= $("#desc").val();
				var text=$("#desc option:selected").text();
				var code_array=code.split("|");
				var text_array=text.split("|");
				$('input:[name=kemsac]').val(code_array[0]);	
				$('input:[name=kemsac_1]').val(code_array[2]);
				
				
			/*
			 * when clicked, this object should populate district names to district dropdown list.
			 * Initially it sets default values to the 2 drop down lists(districts and facilities) 
			 * then ajax is used is to retrieve the district names using the 'dropdown()' method that has
			 * 3 arguments(the ajax url, value POSTed and the id of the object to populated)
			 */
			$("#batchNo").html("<option>--Batch--</option>");
			$("#Exp").html("<option>--Exp--</option>");
			//$("#Exp").html("<option>--Exp Dates--</option>");
			json_obj={"url":"<?php echo site_url("order_management/getBatch");?>",}
			var baseUrl=json_obj.url;
			//var id=$(this).attr("value")
			var id=code_array[0];
			dropdown(baseUrl,"desc="+id,"#batchNo");	
			
			$('#batchNo').click(function(){
				
				var drug_total=0;
				 var batch= $("#batchNo option:selected").text();
				var batch_array=$('#batchNo').val();
				var batch_split=batch_array.split("|");
		  var new_date=$.datepicker.formatDate('d M, yy', new Date(batch_split[0]));

			var drop='<option>'+new_date+'</option>'
			$('#Exp').html(drop);
			
				$("input[name^=kemsaCode]").each(function(index, value) {
  //alert(batch);
			if($(this).val()==(code_array[0]) && $(document.getElementsByName("batchNo["+index+"]")).val()==batch){ 

				drug_total +=parseInt($(document.getElementsByName("Qtyissued["+index+"]")).val());
				
			}
		});
			//alert(drug_total);
		   if(drug_total>0){
          batch_split[1]= batch_split[1]-drug_total;
		   }else{
		   	 
		   }
			$('#avlb_Stock').val(batch_split[1]);
			$('#avlb_hide').val(batch_split[1]);
				
		});	
			
		});	
		
		  $('#district').change(function() {
			/*
			 * when clicked, this object should populate district names to district dropdown list.
			 * Initially it sets default values to the 2 drop down lists(districts and facilities) 
			 * then ajax is used is to retrieve the district names using the 'dropdown()' method that has
			 * 3 arguments(the ajax url, value POSTed and the id of the object to populated)
			 */
			$("#facility").html("<option>--Select--</option>");

			json_obj={"url":"<?php echo site_url("order_management/getFacilities");?>",}
			var baseUrl=json_obj.url;
			var id=$(this).attr("value")
			dropdown(baseUrl,"district="+id,"#facility");	
			
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
			  	
			  	 //	alert(msg);
			  	
			  		var values=msg.split("_");
			  		var dropdown;
			  		var txtbox;
			  		var checker=identifier;
			  			
			  		
			  		for (var i=0; i < values.length-1; i++) {
			  			if(checker=="#facility"){
			  				var id_value=values[i].split("*");
			  			
			  			dropdown+="<option value="+id_value[0]+">";
						dropdown+=id_value[1];						
						dropdown+="</option>";
			  			}else{
			  				
			  			
			  			var id_value=values[i].split("*");
			  			
			  			dropdown+="<option value="+id_value[2]+"|"+id_value[3]+">";
						dropdown+=id_value[1];						
						dropdown+="</option>";
						}
						
					
		  		}
			  		
					$(identifier).html(dropdown);
					
			  },
			  error: function(XMLHttpRequest, textStatus, errorThrown) {
			       if(textStatus == 'timeout') {}
			   }
			}).done(function( msg ) {
				
			});
		}
}); 

   </script>  
   
   

<style>
   
   <style>
   	form {
    font-family: helvetica, arial, sans-serif;
    font-size: 11px;
}
 
form div{
    margin-bottom:10px;
}
 
form a {
    display: inline-block;
	min-width: 54px;
	text-align: center;
	color: #555;
	font-size: 11px;
	font-weight: bold;
	height: 27px;
	padding: 0 8px;
	line-height: 27px;
	-webkit-border-radius: 2px;
	-moz-border-radius: 2px;
	border-radius: 2px;
	
	border: 1px solid gainsboro;
	border: 1px solid rgba(0, 0, 0, 0.1);
	background-color: whiteSmoke;
	
	cursor: default;
}
 
form a:hover{
    border: 1px solid black;
}
td {
		padding: 5px;
	}	
	a {
    text-decoration:underline;
    color:#00F;
    cursor:pointer;

   </style>
   
   
  
	
	
	<div id="IssueNow" title="Fill in the details below">
	<table class="data-table" width="100%">
					<thead>
					<tr>
						<th><b>S11 No</b></th>
						<th><b>District( Select )</b></th>
						<th><b>Facility( Select )</b></th>
						<th>Commodity ( Select )</th>
						<th><b>Batch No</b></th>
						<th><b>Expiry Date</b></th>
						<th><b>Available Stock</b></th>
						<th><b>Donated Quantity</b></th>	
						<th><b>Donate Date</b></th>	 
						 
					</tr>
					</thead>
					<tbody>
						<tr>
							<td >
								<input  class="user" name="s11N" id="s11N" value=""/>
								
							</td>
							<td >
							 <select id="district" name="distrct" class="dropdownsize">
    <option>-Select Distrct-</option>
		<?php 
		foreach ($district as $district) {
			$id=$district->id;
			$name=$district->district;
		
			echo '<option value="'.$id.'"> '.$name.'</option>';
		}
		?>
	</select>	  
								
							</td>
						<td >
							<select id='facility' class="dropdownsize">
								
							</select>
							
       </td>
       <td>   <select class="dropdownsize" id="desc" name="desc">
    <option >-Select Commodity -</option>
		<?php 
		
		foreach ($drugs as $drugs) {
			
			foreach ($drugs->Code as $d) {
			$drugname=$d->Drug_Name;
			$code=$d->id;
			$unit=$d->Unit_Size;
			$kemsa_code=$d->Kemsa_Code;
				
			
		echo 	'<option value="'.$code.'|'.$unit.'|'.$kemsa_code.'"> '.$drugname.'</option>';
		} }
?>
	</select></td>
	
						<td width="80">
	<select id="batchNo" name="batchNo">
		<option>-Batch-</option>
	</select></td>
						<td width="80">
	<select id="Exp" name="Exp">
		<option>-Exp-</option>
	</select>
	</td>
	
	<td width="70"><input class="user" id="avlb_Stock" name="avlb_Stock" readonly="readonly"/>
		
	</td>
	
	
						<td width="70"><input type="text" class="user" name="qty" id="qty" value="" /></td>
						
						
						<td width="110"><?php 
					
					$today= ( date('d M, Y')); 
					
				?><input type="text" name="datepicker" class="date" readonly="readonly" value="<?php echo $today;?>" id="datepicker"/></td>
						</tr>
					</tbody>
					</table>
					
					
						<input type="hidden" id="kemsac" type="text" name="kemsac"  readonly="readonly">
						<input type="hidden" id="kemsac_1" name="kemsac_1"  readonly="readonly" />
						<input type="hidden" class="user" id="avlb_hide" name="avlb_hide" /> 
</div>


   		
 <div id="demo" align="center">
			<p>
				<?php  $att=array("name"=>'myform','id'=>'myform');
	 echo form_open('Issues_main/InsertExt',$att); ?>
				<table id="main" width="100%">
					<thead>
					<tr>
						<th><b>S11 No</b></th>
						<th><b>Facility Name</b></th>
						<th><b>KEMSA Code</b></th>
						<th><b>Description</b></th>
						<th><b>Batch No</b></th>
						<th><b>Expiry Date</b></th>
					    <th><b>Available Stock</b></th>
					    <th><b>Donated Quantity</b></th>
					    <th><b>Donate Date </b></th>
					    <th>Remove</th>  
					   	
					   				    
					</tr>
					</thead>
					
							<tbody>
							
			       
						
						</tbody>
					
				</table>
			</p>
			<?php echo form_close(); ?>
			<div align="center">
<input   id="NewIssue"  value="Issue" >
<input  id="finishIssue"  type="submit" value="Finish" >
</div>
		</div>
		


