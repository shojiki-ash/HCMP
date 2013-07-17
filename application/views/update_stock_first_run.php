<script type="text/javascript" language="javascript" src="<?php echo base_url();  ?>Scripts/jquery.dataTables.js"></script>
<script type="text/javascript" language="javascript" src="<?php echo base_url();  ?>Scripts/unit_size.js"></script>
		<style type="text/css" title="currentStyle">
			
			@import "<?php echo base_url(); ?>DataTables-1.9.3 /media2/css/jquery.dataTables.css";
		
label {
	display: inline-block;
	cursor: pointer;
	position: relative;
	padding-left: 25px;
	margin-right: 15px;
	font-size: 13px;
}label:before {
	content: "";
	display: inline-block;

	width: 16px;
	height: 16px;

	margin-right: 10px;
	position: absolute;
	left: 0;
	bottom: 1px;
	background-color: rgba(86, 125, 138, 0.97);
	box-shadow: inset 0px 2px 3px 0px rgba(0, 0, 0, .3), 0px 1px 0px 0px rgba(255, 255, 255, .8);
}
.radio label:before {
	border-radius: 8px;
}
input[type=radio] {
	display: none;
}
input[type=radio]:checked + label:before {
    content: "\2022";
    color: #f3f3f3;
    font-size: 30px;
    text-align: center;
    line-height: 18px;
}
.user{
		width:100px;
	}
	
	.user1{
	width:100px;
	background : none;
	border : none;
	text-align: center;
	}
	.date{
		width:110px;
	}
	
	.label-container
{
    margin: 10px 10px;
}
	.my_date,.stock_l,.batchN{
		width:6.95em;
	}
	
	</style>

   <script>    
  function calculate_a_stock (argument) {
  	
  	
  	var radiocheck =($("input[type='radio'][name='unitissue']:checked").val());
  	
  	
  	
  	if (radiocheck == 'Unit_Size'){
    //do this

     	var x= argument;
  
  	
    //checking if the quantity is a number 	    
	var num = document.getElementsByName("a_stock["+x+"]")[0].value.replace(/\,/g,'');
if(!isNaN(num)){
if(num.indexOf('.') > -1) {
alert("Decimals are not allowed.");
document.getElementsByName("a_stock["+x+"]")[0].value = document.getElementsByName("a_stock["+x+"]")[0].value.substring(0,document.getElementsByName("a_stock["+x+"]")[0].value.length-1);
document.getElementsByName("a_stock["+x+"]")[0].select();
return;
}
} else {
alert('Enter only numbers');
document.getElementsByName("a_stock["+x+"]")[0].value= document.getElementsByName("a_stock["+x+"]")[0].value.substring(0,document.getElementsByName("a_stock["+x+"]")[0].value.length-1);
return;
}
  var actual_unit_size=get_unit_quantity(document.getElementsByName("u_size["+x+"]")[0].value);

 var total_a_stock=actual_unit_size*num;
 
   document.getElementsByName("qreceived["+x+"]")[0].value=total_a_stock; 
    
    
  
  }
else{
	//do this other
	$(function() {
		
		$("#qreceived").val($("#a_stock").val());
		
		
	});
}
   }
   /*********************getting the last day of the month***********/
  function getLastDayOfYearAndMonth(year, month)
{
    return(new Date((new Date(year, month + 1, 1)) - 1)).getDate();
}
   
   
   
json_obj = {
				"url" : "<?php echo base_url().'Images/calendar.gif';?>",
				};
	var baseUrl=json_obj.url;
	
	$(function() {
		
		 $( "#desc" ).combobox({
        	selected: function(event, ui) {
        		
           var data =$("#desc").val();
           
           var data_array=data.split("|");
         
           $('#unit_size').val(data_array[4]);
            $('#kemsa_code').val(data_array[1]);
         
            $( "#desc_hidden" ).val(data);
            
			}
			});
		
		var count=count123;
				$( "#IssueNow" ).dialog({
		    autoOpen: true,
			height: 200,
			width:1500,
			modal: true,
			buttons: {
				"Add Commodity": function() {
					var details=$("#desc_hidden").val();	
					var details_array=details.split("|");
					
var r=confirm("Are you sure you want to add"+" "+details_array[3]+" "+" with a total unit count of"+" "+$('#qreceived').val()+"?"+"Please confirm values before submitting.");
if (r==true)
  {
  
  }
else
  {
  return;
  }
 
          $( "#main" ).dataTable().fnAddData( [
          	"" + details_array[2] + "",
         '<input type="hidden" name="kemsa_code['+count+']" value="'+details_array[0]+'" />'+
							"" + details_array[1] + "",
							"" + details_array[3] + "",
							'' +'<input class="user1" readonly="readonly" type="text" name="u_size['+count+']" value="'+$('#unit_size').val()+'"/>',
							'' +'<input class="user" type="text" name="batch_no['+count+']"  required="required" value="'+$('#batchNo').val()+'"/>',
							''+'<input name="manuf['+count+']" type="text" size="20" maxlength="20" value="'+$('#manuf').val()+'"/>',
							'' +'<input class="my_date" type="text" name="expiry_date['+count+']"  required="required"  value="'+ $('input:text[name=expiry_date]').val() +'"/>',
							'' +'<input class="user" type="text" name="a_stock['+count+']"  value="'+ $('#a_stock').val() +'" onkeyup="calculate_a_stock('+count+')" required="required" "/>',
							'' +'<input class="user1" readonly="readonly" type="text" name="qreceived['+count+']"  value="'+ $('#qreceived').val() +'"/>',
							'' + '<img class="del" src="<?php echo base_url()?>Images/close.png" />'
							] ); 
							

		var url = "<?php echo base_url().'stock_management/autosave_update'?>";
        $.ajax({
          type: "POST",
          data: "category="+details_array[2]+"&kemsa_code="+details_array[1]+"&description="+details_array[3]+"&unit_size="
          +$('#unit_size').val()+" &batch_no="+$('#batchNo').val()+"&manu="+$('#manuf').val()+
          "&expiry_date="+$('input:text[name=expiry_date]').val()+
          "&stock_level="+$('#a_stock').val()+
          "&unit_count="+$('#qreceived').val()+
          "&drug_id="+details_array[0],
          url: url,
          beforeSend: function() {
           // console.log("data to send :"+data);
          },
          success: function(msg) {
            console.log(msg);
            
             }
         });
							
						count= count+1;
						$( this ).dialog( "close" );
					refreshDatePickers();
						
        
				},
				Cancel: function() {
					$( this ).dialog( "close" );
				}
			},
			close: function() {
				$('#kemsa_code').val('');
				$('#manuf').val('');
				$('#unit_size').val('');
				$('#batchNo').val('');
				$('#a_stock').val('');
				$('input:text[name=expiry_date]').val('');
				$('#qreceived').val('');
				
			}
						
			});
		
		   $( "#NewIssue" )
			.button()
			.click(function() {
				$( "#IssueNow" ).dialog( "open" );
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
                	$("input[name^=expiry_date]").each(function() {
                		checker=checker+1;
                		
                	});
                	//alert(checker);
                	if(checker<2){
                		alert("Cannot submit an empty form");
                		$(this).dialog("close"); 
                	}
                	else{
                	$(this).dialog("close"); 
                      $('#myform').submit();
                      return true;	
                	}
                	
                      
                 }
        }
});

		$('#save1')
		.button()
			.click(function() {
				
			return $myDialog.dialog('open');
		});	
			
			
				
		$( "#datepicker" ).datepicker({
			showOn: "button",
			dateFormat: 'd M, yy', 
			buttonImage: baseUrl,
			buttonImageOnly: true
		});
		//	-- Datepicker
				$(".my_date").datepicker({
					        	beforeShowDay: function(date)
    {
        // getDate() returns the day [ 0 to 31 ]
        if (date.getDate() ==
            getLastDayOfYearAndMonth(date.getFullYear(), date.getMonth()))
        {
            return [true, ''];
        }

        return [false, ''];
    },
					
					dateFormat: 'd M, yy', 
					changeMonth: true,
			        changeYear: true,
			        buttonImage: baseUrl,
			       
				});
				
				
				
				/************************************document ready**********************************************************/
   $(document).ready(function() {
   	
   	var dTable= $('#main').dataTable( {
         "bJQueryUI": true,
          "bPaginate": false
				} );
   	
 
   		
	// Select all table cells to bind a click event
$('.del').live('click',function(){
	var hv = $('#h_v').val();
	<?php  $facility_code =$this -> session -> userdata('news');?>
	
	var facilitycode = "<?php echo  $facility_code?>";
	var url = "<?php echo base_url().'stock_management/delete_temp_autosave'?>";

       
        $.ajax({
          type: "POST",
          data: "drugid="+hv+"&facilitycode="+facilitycode,
          url: url,
          success: function() {
 
          }
        });
        
        
          
    $(this).parent().parent().remove();
    
    
    
});				
    
});
		
		
	});
	function refreshDatePickers() {
		var counter = 0;
		$('.my_date').each(function() {
			var this_id = $(this).attr("id"); // current inputs id
        var new_id = counter +1; // a new id
        $(this).attr("id", new_id); // change to new id
        $(this).removeClass('hasDatepicker'); // remove hasDatepicker class
        $(this).datepicker({ 
        	beforeShowDay: function(date)
    {
        // getDate() returns the day [ 0 to 31 ]
        if (date.getDate() ==
            getLastDayOfYearAndMonth(date.getFullYear(), date.getMonth()))
        {
            return [true, ''];
        }

        return [false, ''];
    },
        	dateFormat: 'd M, yy', 
        	        buttonImage: baseUrl,
					changeMonth: true,
			        changeYear: true
				});; // re-init datepicker
				counter++;
		});
		
		
  }

   </script>
<h2>Please note this is a one off activity</h2>

		<table>
		<tr>
			<td><h4>Stock level as of</h4></td>
			<td>			 
				<?php $today= ( date('d M, Y')); //get today's date in full?>
				<input type="text" name="datepicker" readonly="readonly" value="<?php echo $today;?>" id="datepicker"/>			
			</td>
		</tr>
	</table>
	<fieldset>
	<legend>
   			
   		</legend>
   		   		<div id="IssueNow" title="Fill in the details below">
   			<table class="table-update" >
					<thead>
					<tr>
						<th><b>Description( Type Commodity Name )</b></th>
						<th><b>KEMSA Code</b></th>
						<th><b>Unit&nbsp;Size</b></th>
						<th><b>Unit&nbsp;of&nbsp;Issue</b></th>
						<th><b>Batch&nbsp;No</b></th>
						<th><b>Manufacturer</b></th>
						<th><b>Expiry&nbsp;Date</b></th>
						<th><b>Stock&nbsp;Level</b></th>
						<th><b>Total&nbsp;Unit&nbsp;Count</b></th>					   				    
					</tr>
					</thead>
					<tbody>
	  <td>
	  	<input type="hidden" id="desc_hidden"  name="desc_hidden"/>		
	  	<select id="desc" name="desc">
    <option></option>
		<?php 
		foreach ($drugs as $drugs) {
			$id=$drugs->id;
			$id1=$drugs->Kemsa_Code;
			$drug=$drugs->Drug_Name;
			$unit_size=$drugs->Unit_Size;
			foreach($drugs->Category as $cat){
				
			$cat_name=$cat;	
				
			}
			?>
			<option value="<?php echo $id."|".$id1."|".$cat_name."|".$drug."|".$unit_size;?>"><?php echo $drug;?></option>
		<?php }
		?>
	</select>
	</td>
	<td><input size="10" type="text"  class="user1" readonly="readonly" name="kemsa_code[0]" id="kemsa_code" /></td>
	<td><input size="10" type="text" class="user1" readonly="readonly"  name="u_size[0]" id="unit_size" /></td>
	<td><div class="radio">
	<input id="Unit_Size" type="radio" name="unitissue" value="Unit_Size" class="radioOptions">
	<label for="Unit_Size">Pack Size</label>
	<input id="Pack_Size" type="radio" name="unitissue" value="Pack_Size" class="radioOptions">
	<label for="Pack_Size">Unit Size</label>
</div>
</td>
	<td><input id='batchNo' name='batchNo' type='text' class="batchN" /></td>
	<td><input id='manuf' name='manuf[0]' type='text' size='20' maxlength='10'value="" /></td>
	<td><input  class='my_date'  name='expiry_date' type='text' /></td>
	<td><input id='a_stock' name='a_stock[0]' type='text' class="stock_l" onkeyup="calculate_a_stock(0)"  /></td>
	<td><input class='user1' id='qreceived' readonly='readonly'  type='text' name='qreceived[0]' value=''  /></td>
	  
						</tbody>
						</table>	
							
					
   			</div>
   		<?php $att=array("name"=>'myform','id'=>'myform');
	 echo form_open('stock_management/test2',$att); ?>
<table id="main" width="100%">
					<thead>
					<tr>
						<th><b>Category</b></th>
						<th><b>KEMSA&nbsp;Code</b></th>
						<th><b>Description</b></th>
						<th><b>Unit&nbsp;Size</b></th>
						<th><b>Batch&nbsp;No</b></th>
						<th><b>Manufacturer</b></th>
						<th><b>Expiry&nbsp;Date</b></th>
						<th><b>Stock&nbsp;Level</b></th>
						<th width="10px"><b>Unit&nbsp;Count</b></th>
						<th width="10px"><b>Delete</b></th>					   				    
					</tr>
					</thead>
					<tbody>
						<?php
						$count=1;
					foreach($first_run_temp as $data){
						echo"<tr>
						<td>$data->category</td>
						<td>$data->kemsa_code
						<input type='hidden' name='kemsa_code[".$count."]' value='$data->drug_id' id='h_v' />
						</td>
						<td>$data->description</td>
						<td><input class='user1' readonly='readonly' type ='text' name='unit_size[".$count."]' value='$data->unit_size'></td>
						<td><input class='user' name='batch_no[".$count."]' required='required' value='$data->batch_no'></td>
						<td><input  name='manuf[".$count."]' size='20' maxlength='20' value='$data->manu'></td>
						<td><input class='my_date' type='text' name='expiry_date[".$count."]' required='required' value='$data->expiry_date'></td>
						<td><input class='user' name='a_stock[".$count."]' onkeyup='calculate_a_stock(".$count.")' required='required' value='$data->stock_level'></td>
						<td><input class='user1' readonly='readonly' type ='text' name='qreceived[".$count."]'  value='$data->unit_count'></td>
						<td><img class='del' src='".base_url()."Images/close.png' /> </td>
						
						
						</tr>";
						$count++;
					}	
					echo "<script>count123=".($count)."</script>";
						?>
						</tbody>
						</table>
						<?php echo form_close();?>	
						<button class="btn "   id="NewIssue">Add Commodity </button>
                        <button class="btn btn-primary"   id="save1" >Save</button>
                        
</div>

         

