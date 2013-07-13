<?php
$current_year = date('Y');
$earliest_year = $current_year - 2;
?>

<?php $this->load->helper('url');?>
<script type="text/javascript">

$(function() {

	$('#desc').change(function() {
			
				
			var txt=$("#desc option:selected").text();
							
				$('input[name=drugname]').val(txt);
				//alert($('input[name=drugname]').val());
				});
				
				});
	

</script>
	

</script>

<style type="text/css">
	#filter {
		border: 2px solid #DDD;
		display: block;
		width: 80%;
		margin: 10px auto;
	}
	.filter_input {
		border: 1px solid black;
	}

</style>
<div id="filter">
	<?php
	$attributes = array("method" => "POST");
	echo form_open('raw_data/getconsumption', $attributes);
	
	
	?>
	
	
	<fieldset>
		<legend>
			Filter by Drug
		</legend>
		
		
		<select id="desc" name="desc">
    <option>-Select Drug Name-</option>
		<?php 
		foreach ($drugs as $drugs) {
			$id=$drugs->Kemsa_Code;
			$drug=$drugs->Drug_Name;
			?>
			<option value="<?php echo $id;?>"><?php echo $drug;?></option>
		<?php }
		?>
	</select>
	<input  type="hidden"  name="drugname" id="drugname" value="" />
	
	
			
		<label for="year_from">Select Year</label>
		<select name="year_from" id="year_from">
			<?php
for($x=$current_year;$x>=$earliest_year;$x--){
			?>
			<option value="<?php echo $x;?>"
			<?php
			if ($x == $current_year) {echo "selected";
			}
			?>><?php echo $x;?></option>
			<?php }?>
		</select>
		
		<label>Select Report Option</label>
		<select name="type_of_report">
			<option>--select---</option>
			<option>Download PDF</option>
			<option>View Report</option>
		</select>
		
    
    
		
			
    		<input type="submit" name="search" class="button"	value="Get Report" /> 

    <br />
		<p></p>
		
		</fieldset>
		
		
		
		
		
	</form>
</div>


