<?php
if (!defined('BASEPATH'))
	exit('No direct script access allowed');
class cd4_Management extends MY_Controller {
	function __construct() {
		parent::__construct();
		
	}

	public function index() {

//		$this->get_kenyan_county_map();
		$data['content_view']="cd4/dashboard";
		$data['title']= "CD4 Home";
		$data['banner_text']="CD4";
		$data ['table_data'] = $this->cd4_sidebar();
		$this->load->view('template',$data);
	}
	public function get_cd4_allocation_kenyan_map(){

	$this->load->view("allocation_committee/ajax_view/cd4_allocation_county_map");
}

function objectToArray( $object ) {
    if( !is_object( $object ) && !is_array( $object ) ) {
        return $object;
    }
    if( is_object( $object ) ) {
        $object = (array) $object;
    }
    return array_map( 'objectToArray', $object );
}	

public function api_get_facilities (){


	function objectToArray( $object ) {
    if( !is_object( $object ) && !is_array( $object ) ) {
        return $object;
    }
    if( is_object( $object ) ) {
        $object = (array) $object;
    }
    return array_map( 'objectToArray', $object );
}	



	date_default_timezone_set('EUROPE/Moscow');
	$month = date('m');
	$year = date('o');
    $url = 'http://nascop.org/cd4/reportingfacsummary.php?yr='.$year.'&month='.$month;
    $url = 'http://nascop.org/cd4/reportingfacsummary.php?county=24&yr=2013&month=07';
//	$url = 'http://localhost/api/counties.php';
 	$string_manual = file_get_contents($url);



	$string = json_decode($string_manual);
	$string = objectToArray($string);
// 	$string = $this->objectToArray($string);
 return $string;
 //	echo"<pre>";
 	//	var_dump($string);
 	//	echo"</pre>";

}
public function get_facilities_local(){

	function objectToArray( $object ) {
    if( !is_object( $object ) && !is_array( $object ) ) {
        return $object;
    }
    if( is_object( $object ) ) {
        $object = (array) $object;
    }
    return array_map( 'objectToArray', $object );
}	

	$this->load->database();
	$q = $this->db->query('SELECT * FROM  `api_gen` ORDER BY  `api_gen`.`id` ASC LIMIT 0 , 1');
	$local_json = $q->result_array();

	$res_arr = json_decode($local_json[0]['json']);
	$res_arr = objectToArray($res_arr);
	//$res_arr = objectToArray($local_json[0]['json']);
	return $res_arr;
//	echo "<pre>";var_dump($res_arr); echo "</pre>";
}

public function cd4_sidebar(){
	$tdata=' ';
	$all_data = $this->get_facilities_local();
   foreach ($all_data as $key => $county) {
//   echo "<pre>"; var_dump($all_data); echo "</pre>";
//   echo key($all_data);
//   	echo($key);
   
   	$county_map_id = $county['county'];
   	$countyname = $county['name'];
   	$total_facilities = $county['particulars']['total'];
	$reporting_facilities = $county['particulars']['reported'];
	if ($total_facilities>0){
 	$reporting_rate=round((($reporting_facilities/$total_facilities)*100),1);
 	}
 	else {$reporting_rate = 0;}
// 	county_allocation_details
 	$key +=1;
 	$tdata .='<tr><td><a href="'.base_url().'cd4_management/county_allocation_details/'.$key.'">'.$countyname.'</a></td><td>'.$reporting_facilities.'/'.$total_facilities.'</td></tr>';
   
}
   return $tdata;

}
	// currently using county details from RTK/HCMP will load from cd4_  as next step
	public function map_chart(){
	$map="";
	$map .="<map showBevel='0' caption='CD4 county allocation: Click to view facilities in county' showMarkerLabels='1' fillColor='F1f1f1' borderColor='000000' hoverColor='efeaef' canvasBorderColor='FFFFFF' baseFont='Verdana' baseFontSize='10' markerBorderColor='000000' markerBgColor='FF5904' markerRadius='6' legendPosition='bottom' useHoverColor='1' showMarkerToolTip='1'  showExportDataMenuItem='1' >";
	$map .="<data>";
	$colors=array("FFFFCC"=>"1","E2E2C7"=>"2","FFCCFF"=>"3","F7F7F7"=>"5","FFCC99"=>"6","B3D7FF"=>"7","CBCB96"=>"8","FFCCCC"=>"9");
	
	$counties=Counties::get_county_map_data();
   /*	foreach( $counties as $county_detail){
   	$countyid=$county_detail->id;
	$county_map_id=$county_detail->kenya_map_id;
   	$countyname=trim($county_detail->county);
   	


// 	$county_detail=hcmp_stock_status::get_county_reporting_rate ($countyid);
 	$county_detail = $this->api_get_facilities($county_map_id);
 	$total_facilities=$county_detail->total;
 	$reporting_facilities=$county_detail->reported;
	
	$reporting_rate=round((($reporting_facilities/$total_facilities)*100),1);
 	$map .="<entity  link='".base_url()."cd4_management/county_allocation_details/$county_map_id' id='$county_map_id' displayValue ='$countyname' color='".array_rand($colors,1)."'  toolText='County :$countyname&lt;BR&gt; Total Facilities :".$total_facilities."&lt;BR&gt; Facilities Reporting  :".$reporting_facilities."&lt;BR&gt; Facility Reporting Rate :".$reporting_rate." %'/>";
   		}*/
   $all_data = $this->get_facilities_local();
   foreach ($all_data as $county) {
   	$county_map_id = $county['county'];
   	$countyname = $county['name'];
   	$total_facilities = $county['particulars']['total'];
	$reporting_facilities = $county['particulars']['reported'];
	if ($total_facilities>0){
 	$reporting_rate=round((($reporting_facilities/$total_facilities)*100),1);
 	}
 	else {$reporting_rate = 0;}

  $map .="<entity  link='".base_url()."cd4_management/county_allocation_details/$county_map_id' id='$county_map_id' displayValue ='$countyname' color='".array_rand($colors,1)."'  toolText='County :$countyname&lt;BR&gt; Total Facilities :".$total_facilities."&lt;BR&gt; Facilities Reporting  :".$reporting_facilities."&lt;BR&gt; Facility Reporting Rate :".$reporting_rate." %'/>"; 	
   }

	$map .="</data>
		<styles>
		<definition>
   		<style name='TTipFont' type='font' isHTML='1'  color='FFFFFF' bgColor='666666' size='11'/>
   		<style name='HTMLFont' type='font' color='333333' borderColor='CCCCCC' bgColor='FFFFFF'/>
   		<style name='myShadow' type='Shadow' distance='1'/>
		</definition>
		<application>
		<apply toObject='MARKERS' styles='myShadow' /> 
		<apply toObject='MARKERLABELS' styles='HTMLFont,myShadow' />
		<apply toObject='TOOLTIP' styles='TTipFont' />
		</application>
		</styles>
		</map>";

		echo $map;
	}



	public function get_kenyan_county_map(){
	$data['content_view']="cd4/ajax_view/kenyan_county_v";
	$data['title'] = "CD4";
	$data['banner_text'] = "CD4";
	$this -> load -> view("template",$data);	
		
		
		
	}
	
	public function kenya_county_map(){
		$map ="";
		
		$map .="<map showBevel='0' showMarkerLabels='1' fillColor='F1f1f1' borderColor='000000' hoverColor='efeaef' canvasBorderColor='FFFFFF' baseFont='Verdana' baseFontSize='10' markerBorderColor='000000' markerBgColor='FF5904' markerRadius='6' legendPosition='bottom' useHoverColor='1' showMarkerToolTip='1'  showExportDataMenuItem='1' >";
		$map .="<data>";
		$colors=array("FFFFCC"=>"1","E2E2C7"=>"2","FFCCFF"=>"3","F7F7F7"=>"5","FFCC99"=>"6","B3D7FF"=>"7","CBCB96"=>"8","FFCCCC"=>"9");

	    $counties=Counties::get_county_map_data();
   		   foreach( $counties as $county_detail){
   		$countyid=$county_detail->id;
	  	$county_map_id=$county_detail->kenya_map_id;
   	    $countyname=trim($county_detail->county);
   	
	   	$county_detail=hcmp_stock_status::get_county_reporting_rate ($countyid);
	   	$total_facilities=$county_detail[0]['total_facilities'];
	   	$reporting_facilities=$county_detail[0]['reported'];
	   	$reporting_rate=round((($reporting_facilities/$total_facilities)*100),1);
 		$map .="<entity  link='cd4_management/county_detail_zoom/$countyid' id='$county_map_id' displayValue ='$countyname' color='".array_rand($colors,1)."'  toolText='County :$countyname&lt;BR&gt; Total Facilities :".$total_facilities."&lt;BR&gt; Facilities Reporting  :".$reporting_facilities."&lt;BR&gt; Facility Reporting Rate :".$reporting_rate." %'/>";
   		}
		$map .="</data>
		<styles>
		<definition>
   		<style name='TTipFont' type='font' isHTML='1'  color='FFFFFF' bgColor='666666' size='11'/>
   		<style name='HTMLFont' type='font' color='333333' borderColor='CCCCCC' bgColor='FFFFFF'/>
   		<style name='myShadow' type='Shadow' distance='1'/>
		</definition>
		<application>
		<apply toObject='MARKERS' styles='myShadow' /> 
		<apply toObject='MARKERLABELS' styles='HTMLFont,myShadow' />
		<apply toObject='TOOLTIP' styles='TTipFont' />
		</application>
		</styles>
		</map>";

		echo $map;
		
		
	}
	public function kenyan_map($data, $title=NULL){
	    $map ="";
		$map .="<map showBevel='0' showMarkerLabels='1' caption='$title'  fillColor='F1f1f1' borderColor='000000' hoverColor='efeaef' canvasBorderColor='FFFFFF' baseFont='Verdana' baseFontSize='10' markerBorderColor='000000' markerBgColor='FF5904' markerRadius='6' legendPosition='bottom' useHoverColor='1' showMarkerToolTip='1'  showExportDataMenuItem='1' >";
		
			$map .="<data>";
			$map .=$data;
			$map .="</data>
		<styles> 
  <definition>
   <style name='TTipFont' type='font' isHTML='1'  color='FFFFFF' bgColor='666666' size='11'/>
   <style name='HTMLFont' type='font' color='333333' borderColor='CCCCCC' bgColor='FFFFFF'/>
   <style name='myShadow' type='Shadow' distance='1'/>
  </definition>
  <application>
   <apply toObject='MARKERS' styles='myShadow' /> 
   <apply toObject='MARKERLABELS' styles='HTMLFont,myShadow' />
   <apply toObject='TOOLTIP' styles='TTipFont' />
  </application>
 </styles>
</map>";
			
	return $map;
	
}

	public function cd4_allocation_kenyan_map(){
$colors=array("FFFFCC"=>"1","E2E2C7"=>"2","FFCCFF"=>"3","F7F7F7"=>"5","FFCC99"=>"6","B3D7FF"=>"7","CBCB96"=>"8","FFCCCC"=>"9");

  
   $map ="";
   
 $counties=Counties::get_county_map_data();
	$table_data="";
	$allocation_rate=0;
	$total_facilities_in_county=1;
	$total_facilities_allocated_in_county=1;
   foreach( $counties as $county_detail){
   	
   	   $countyid=$county_detail->id;
	   $county_map_id=$county_detail->kenya_map_id;
   	   $countyname=trim($county_detail->county);
   	
	   $county_detail=rtk_stock_status::get_allocation_rate_county($countyid);
	   $total_facilities_in_county=$county_detail['total_facilities_in_county'];
	   $total_facilities_allocated_in_county=$county_detail['total_facilities_allocated_in_county'];

	  @$allocation_rate=round((($total_facilities_allocated_in_county/$total_facilities_in_county)*100),1);
     $map .="<entity  link='".base_url()."cd4_management/allocation_county_detail_zoom/$countyid' id='$county_map_id' displayValue ='$countyname' color='".array_rand($colors,1)."' toolText='County :$countyname&lt;BR&gt; Total Facilities Reporting:".$total_facilities_in_county."&lt;BR&gt; Facilities Allocated  :".$total_facilities_allocated_in_county."&lt;BR&gt; Facility Allocation Rate :".$allocation_rate." %'/>";

   		}
 echo  $this->kenyan_map($map,"CD4 County allocation: Click to view facilities in county");
	
	
}



public function county_allocation_details_old($county_id){


	$data['content_view']='cd4/ajax_view/county_allocation_v';
	


	
$htm='';


	$facilities =$this->db->query('SELECT DISTINCT AutoID,fname,MFLCode,countyname
			FROM cd4_facility, cd4_facilityequipments, cd4_districts
			WHERE cd4_facility.AutoID = cd4_facilityequipments.facility
			AND cd4_facility.district = cd4_districts.ID
			AND equipment  <=3
			AND county = "'.$county_id.'"');

			


		if ($facilities->num_rows() > 0){

			// checks whether any equipments 
//			$htm.='<table class=" "  style="position:fixed; width:300px">';
//			$htm.='<tr><thead><th>Facility</th><!--<th>Device</th>--><th></th></thead></tr>';
			$htm.='<ul class="facility-list">';
		foreach ($facilities->result_array() as $facilitiessarr) 
		{
			$countyname = $facilitiessarr['countyname'];



			$facility= $facilitiessarr['AutoID'];
			$facility_name = $facilitiessarr['fname'];
			$facility_mfl = $facilitiessarr['MFLCode'];
			$facilitiessarr['equipmentname'] ='';
//			echo $facility_name .' - '.$facility;
		

//			echo"<pre>";
// 			var_dump($facilitiessarr);
//			echo"</pre>";	
//	 		
		//	$htm.='<tr><!--Facility --><td>'.$facilitiessarr['fname'].'</td><!-- MFLCode '.$facilitiessarr['MFLCode'].' equipment <td>'.$facilitiessarr['equipmentname'].'</td>--><td><a href="#'.$facility.'" class="allocate" onClick="showpreview('.$facility.')" >Allocate</a></td></tr>';
			$htm .='<li><a href="#'.$facility_mfl.'" class="allocate" onClick="showpreview('.$facility_mfl.')" >'.$facilitiessarr['fname'].'</a></li>';

//			echo 'Facility '.$facilitiessarr['fname'].' MFLCode '.$facilitiessarr['MFLCode']
//			.' equipment '.$facilitiessarr['equipment']		;

	 

		}$htm.='</ul>';
		//$htm.='</table>';

		}
		$data['htm'] = $htm;
			$data['banner_text']='Allocate '.$countyname;
			$data['title']='CD4 Allocation '.$countyname;
			$data['countyname'] =$countyname;

	$this->load->view('template',$data);

		  
 

}

public function county_allocation_details($county_id){

	$county_id = $county_id-1;

	$data['content_view']='cd4/ajax_view/county_allocation_v';
	$htm='';
	$htm.='<ul class="facility-list">';
	
	$all_counties = $this->get_facilities_local();
	$countyname = $all_counties[$county_id]['name'];
 //var_dump($all_counties[$county_id]);
   if ($all_counties[$county_id]['particulars']>0){

   	foreach ($all_counties[$county_id]['particulars']['particular']as $key => $facilities) {
   		$facility_mfl = $facilities['mfl'];
   		$facilityname = $facilities['name'];
   		$status =  $facilities['status'];
if ($status !=="Not Reported"){
  $htm .='<li><a href="#'.$facility_mfl.'" class="allocate" onClick="showpreview('.$facility_mfl.')" >'.$facilityname.'</a></li>';
 }
 else{
 $htm .='<li style="background: #FF0000;"><a href="#" title="'.$facilityname.' has not reported yet" class="allocate" onClick="alertnonreported()"  >'.$facilityname.'</a></li>';	
 }


 //$htm .='<li><a href="#'.$facility_mfl.'" class="allocate" onClick="showpreview('.$facility_mfl.')" >'.$facilityname.'</a></li>';


   }
 
   }
   $htm.='</ul>';


		$data['htm'] = $htm;
			$data['banner_text']='Allocate '.$countyname;
			$data['title']='CD4 Allocation '.$countyname;
			$data['countyname'] =$countyname;

	$this->load->view('template',$data);

		  
 

}

function nascop_get($facil_mfl){ 
	/*
	//$facil_mfl = 11555;
function objectToArray( $object ) {
    if( !is_object( $object ) && !is_array( $object ) ) {
        return $object;
    }
    if( is_object( $object ) ) {
        $object = (array) $object;
    }
    return array_map( 'objectToArray', $object );
}
$url = 'http://nascop.org/cd4/arraytest.php?mfl='.$facil_mfl.''; // url for the aPI

//$url = 'http://localhost/api/arraytest.php';
$string_manual = file_get_contents($url); // Fetchin the API json
//echo $string_manual;
$string_manual = substr($string_manual, 0, -1); // Removes the last string character ']' from the json
//echo $string_manual;
$string_manual = substr($string_manual, 12); // removes the first 12 string characters which includes a '<pre>' tag up to the '['
//echo $string_manual;
$string = $string_manual;
//$string .= '[{"mfl":"11555","facility":"Malindi District Hospital","device":{"0":"BD Facs Calibur","devices":[{"name":"Tri-TEST CD3\/CD4\/CD45 with TruCOUNT Tubes","code":"CAL 002","unit":"50T Pack","reagentID":"1","report":{"used":"8","received":"60","requested":"70","endbal":"36"}},{"name":"Calibrite 3 Beads","code":"CAL 003","unit":"3 Vials Pack","reagentID":"2","report":{"used":"0","received":"3","requested":"1","endbal":"2"}},{"name":"FACS Lysing solution","code":"CAL 005","unit":"100mL Pack","reagentID":"3","report":{"used":"1","received":"2","requested":"1","endbal":"2"}},{"name":"FACS Clean solution","code":"","unit":"5L Pack","reagentID":"4","report":{"used":"0","received":"0","requested":"5","endbal":"0"}},{"name":"FACS Rinse solution","code":"","unit":"5L Pack","reagentID":"5","report":{"used":"0","received":"1","requested":"5","endbal":"0"}},{"name":"FACS Flow solution","code":"","unit":"20L Pack","reagentID":"6","report":{"used":"1","received":"6","requested":"1","endbal":"7"}},{"name":"Falcon Tubes","code":"CAL 006","unit":"125 pcs Pack","reagentID":"7","report":{"used":"2","received":"0","requested":"1","endbal":"5"}},{"name":"BD Multi-Check Control","code":"","unit":"Pack","reagentID":"8","report":{"used":"0","received":"1","requested":"1","endbal":"0"}},{"name":"BD Multi-Check CD4 Low Control","code":"","unit":"Pack","reagentID":"9","report":{"used":"0","received":"1","requested":"1","endbal":"0"}},{"name":"Printing Paper (A4)","code":"CAL 009","unit":"Raem","reagentID":"10","report":{"used":"2","received":"0","requested":"3","endbal":"0"}},{"name":"HP Laser Jet Printer Catridge 53A","code":"CAL 010","unit":"pcs","reagentID":"11","report":{"used":"1","received":"0","requested":"2","endbal":"1"}},{"name":"Vacutainer EDTA 4ml tubes","code":"CON 007","unit":"100\/pack","reagentID":"27","report":{"used":"4","received":"0","requested":"10","endbal":"0"}},{"name":"Vacutainer Needle 21G [Adult]\r\n","code":"CON 011","unit":"100\/pack","reagentID":"28","report":{"used":"9","received":"0","requested":"20","endbal":"0"}},{"name":"Micortainer tubes [Paediatric]","code":"CON 009","unit":"50\/Pack","reagentID":"30","report":{"used":"1","received":"0","requested":"2","endbal":"0"}},{"name":"Microtainer Pink lancets 21G [Paediatric]","code":"CON 010","unit":"200\/Pack","reagentID":"31","report":{"used":"0","received":"0","requested":"2","endbal":"0"}},{"name":"Vacutainer Butterfly Needle 23G [Paediatrics]","code":"CON 012","unit":"50\/Pack","reagentID":"32","report":{"used":"0","received":"0","requested":"2","endbal":"0"}},{"name":"Yellow Pipette Tips (50 MicroL)","code":"CON 005","unit":"1,000 tips","reagentID":"33","report":{"used":"450","received":"0","requested":"3000","endbal":"2000"}},{"name":"CD4 Stabilizer tubes 5ml","code":"CON 008","unit":"100\/Pack","reagentID":"34","report":{"used":"0","received":"0","requested":"2","endbal":"0"}}]}}]';
//$string .= ' ';
//$string = $string_manual;
//echo $string_manual.'<br /><br />';
//echo $string_manual;

$string_manual = json_decode($string_manual); // decoding the json
$string_manual = objectToArray($string_manual); // This is where I convert String Manual to array

 //var_dump($string_manual);
*/
$string_manual = $this->get_reported_local($facil_mfl);

//echo'<br /><br />';
 if ($string_manual==null){
 	echo '<fieldset style="
		    position: absolute;
		    margin-top: 112px;
		    font-size: 2em;
		    border: solid 1px #DDE2BB;
		    padding: 79px;
		    color: rgb(221, 154, 154);
		    background: snow;
		    /* margin-left: 80px; */
 
		"> <h1>No data has been submitted yet</h1></fieldset>'; 
 }
 else{
 

	echo '<fieldset style="font-size: 14px;background: #FCF8F8;padding: 10px;">
				<span><b>FACILITY :</b>'.$string_manual['facility'].' ('.$string_manual['mfl'].')</span><br>
				<span><b>DEVICE :</b>'.$string_manual['device'][0].'</span><br>
				</fieldset>';
				echo"<form action='../allocate_cd4' method='post' name='cd4_allocation' id='cd4_allocation'>";

	echo "<table border='0' class='data-table' style='font-size: 0.9em;'>"; // Table begins
	echo "<thead><th>Name(Unit)</th><th>received </th><th>used</th><th>requested</th><th>Allocated</th></thead>";
	foreach ($string_manual['device']['devices'] as $reagents_arr) {
//		echo "<pre>";var_dump($reagents_arr);echo "</pre>";
//		$used =  $reagents_arr['report']['used'];
//		echo "<pre>";var_dump($reagents_arr);echo "</pre>";
		$used = $reagents_arr['report']['used'];
		$alloc_formula = 1.14*$used*4;
	$alloc_formula = round($alloc_formula);
 
	echo "<tr>";
	echo "<td>".$reagents_arr['name'].'('.$reagents_arr['unit'].') </td>';
//	echo "<td>".$reagents_arr['reagentID'].' </td>';

	echo "<td>".$reagents_arr['report']['received'].' </td>';
	echo "<td>".$reagents_arr['report']['used'].' ';
	echo "<td>".$reagents_arr['report']['requested'].' </td>';

	$reagentID = $reagents_arr['reagentID'];
	$facility_code = $string_manual['mfl'];
	$date = time();
    date_default_timezone_set("EUROPE/Moscow");
    $thismonth = date('mY', strtotime("this month"));
	$allocation_for = $thismonth;
	
	echo "<input name='reagentID_$reagentID' type='hidden' value='$reagentID' />";
	echo "<input name='facility_$reagentID' type='hidden' value='$facility_code' />";
	echo "<input name='allocation_$reagentID' type='hidden' value='$allocation_for' />";
	echo "<input name='date_$reagentID' type='hidden' value='$date' />";

	echo "<td><input name='reagent_$reagentID' type='text' value='$alloc_formula' /></td>";
	echo "</tr />";
	//echo "<pre>";
	//var_dump($reagents_arr);
	//	echo "</pre>";
}
echo "</table>";// end og table
echo '<input class="button ui-button ui-widget ui-state-default ui-corner-all" id="allocate" type="submit" value="Allocate" role="button" aria-disabled="false">';
echo "</form>";
 }
	}

	function allocate_cd4(){
		$cd4_arr = $_POST;
		$chunks = (array_chunk($cd4_arr, 5));
 		foreach ($chunks as $cd4_arr) {
			$reagent = $cd4_arr[0];
			$facility = $cd4_arr[1];
			$allocation_for = $cd4_arr[2];
			$allocation_timestamp = $cd4_arr[3];
			$allocation_qty = $cd4_arr[4];
 		$this->load->database();
		$this->db->query("INSERT INTO `kemsa2`.`cd4_allocation` (`id`, `facility_code`, `reagentID`, `allocation_for`, `qty`, `date_allocated`, `allocated_by`) 
												VALUES (NULL, '$facility', '$reagent', '$allocation_for', '$allocation_qty', '$allocation_timestamp', '');");
		}
 redirect('cd4_Management/allocations?allocationsuccess');

//		echo "<pre>";
//		var_dump($cd4_arr/);
//		echo "</pre>";
		}
function allocation_per_facility($mfl){
$this->load->database();

$sel = $this->db->query('SELECT cd4_facility.facilityname, cd4_facility.MFLCode, cd4_facility.districtname, cd4_allocation.id, cd4_allocation.facility_code, cd4_allocation.reagentID, cd4_allocation.allocation_for, cd4_allocation.qty, cd4_allocation.date_allocated, cd4_allocation.allocated_by, cd4_reagents.reagentname, cd4_reagents.reagentID, cd4_countys.ID, cd4_countys.name, cd4_districts.name, cd4_districts.county, cd4_districts.ID
FROM cd4_facility, cd4_allocation, cd4_reagents, cd4_districts, cd4_countys
WHERE  `cd4_facility`.`MFLCode` =  `cd4_allocation`.`facility_code` 
AND cd4_reagents.reagentID = cd4_allocation.reagentID
AND cd4_countys.ID = cd4_districts.county
AND cd4_facility.district = cd4_districts.ID
AND cd4_allocation.qty>0
AND cd4_facility.MFLCode='.$mfl.''); 
$resarr = $sel->result_array();
//for($i = 0; $i < count($resarr); $i++){if($i % 2) // OR if(!($i % 2)){unset($resarr[$i]);}}
//echo "<pre>";print_r($resarr);echo "</pre>";
return $resarr;
}

function facility_allocate($facility){
	$htm = '';

	$equipments  = $this->db->query('SELECT * 
FROM cd4_facilityequipments, cd4_equipments, cd4_reagentcategory, cd4_reagents
WHERE cd4_facilityequipments.equipment = cd4_equipments.ID
AND cd4_reagentcategory.equipmentType = cd4_equipments.ID
AND cd4_reagents.categoryID = cd4_equipments.ID
AND cd4_equipments.ID = cd4_equipments.ID
AND facility= '.$facility.'');

			if ($equipments->num_rows()>0){

				$facility_details = $this->db->query('SELECT * 
								FROM cd4_facilityequipments, cd4_equipments, cd4_reagentcategory, cd4_reagents
								WHERE cd4_facilityequipments.equipment = cd4_equipments.ID
								AND cd4_reagentcategory.equipmentType = cd4_equipments.ID
								AND cd4_reagents.categoryID = cd4_equipments.ID
								AND cd4_equipments.ID = cd4_equipments.ID
								AND facility ='.$facility.'
								LIMIT 0 , 1');
				foreach ($facility_details->result_array() as $facility_details_arr) {	 
					$facility_equipment =$facility_details_arr['equipmentname'];
					$facility_name  = $facility_details_arr['fname'];
					$facility_mfl  = $facility_details_arr['fname'];

			 $htm .= '<fieldset style="font-size: 14px;background: #FCF8F8;padding: 10px;">
			<span><b>DEVICE :</b>'.$facility_equipment.'</span><br>
			<span><b>FACILITY :</b> '.$facility_name.'</span><br>
			</fieldset>';

}
		$htm .=  "<table class='data-table' style='font-size: 0.9em;'>";
		$htm .=  "<thead>
		<!--<th>Equipment Name</th> -->
 
		<th ROWSPAN=2> Reagent Name</th>
		<th COLSPAN=3>Quantity Received(3 months av)</th>
		<th COLSPAN=3>Quantity Consumed(3 months av)</th>
		<th ROWSPAN=2>End Balance(July)</th>
		<th ROWSPAN=2>Requested</th>
		<th ROWSPAN=2>Allocated</th>
		</tr>
		<tr>
		<th>May</th><th>June</th><th>July</th>
		<th>May</th><th>June</th><th>July</th>
		</tr></thead>
		";
  
				foreach ($equipments->result_array() as $equipmentsarr) {

				$name = $equipmentsarr['name'];
				$reagentname = $equipmentsarr['reagentname'];
				$equipmentname = $equipmentsarr['equipmentname'];
				$unit = $equipmentsarr['unit'];

//				echo "<pre>";
//			var_dump($equipmentsarr);

 
			 	$htm .= '<tr> <td>'.$name.'<br />('.$unit.')</td><td>1</td><td>1</td><td>1</td><td>1</td><td>1</td><td>1</td><td>3</td><td>3</td><td><input type="text" value="0" /></td></tr>';
 

//				echo "</pre>";
			}
			$htm.="</table>";
			$htm.='<input class="button ui-button ui-widget ui-state-default ui-corner-all" id="allocate" value="Allocate" role="button" aria-disabled="false">';

			}
			else{ 
		echo '<fieldset style="
		    position: absolute;
		    margin-top: 112px;
		    font-size: 2em;
		    border: solid 1px #DDE2BB;
		    padding: 79px;
		    color: rgb(221, 154, 154);
		    background: snow;
		    /* margin-left: 80px; */
 
		"> <h1>No data has been submitted yet</h1></fieldset>';}
 
			echo $htm;
}
public function county_detail_zoom($county_id){

    $data['facility'] =Facilities::get_total_facilities_cd4_in_county($county_id);
	$data['table_body']="Hello World"; 
	$data['title'] = "County View";
	$data['banner_text'] = "County View";
	$data['content_view']="cd4/ajax_view/county_detail_zoom_v";
	$this -> load -> view("template",$data);
	 }

	

function national_yearly_reporting_chart(){
	 $caption='National Reporting Status';
	 $xAxisName='Month';
	 $yAxisName='Reagents';
	echo "<chart yAxisName='National Reporting Status' numberPrefix='' showValues='1'>	
	   <set label='Jan' value='40' />
	   <set label='Feb' value='90' />
	   <set label='Mar' value='70' />
	   <set label='Apr' value='50' />
	   <set label='May' value='80' />
	   <set label='Jun' value='50' />
	   <set label='Jul' value='60' />
	   <set label='Aug' value='60' />
	   <set label='Sep' value='60' />
	   <set label='Oct' value='40' />
	   <set label='Nov' value='50' />
	   <set label='Dec' value='30' />	
	   <trendLines>
	      <line startValue='700000' color='009933' displayvalue='Target' /> 
	   </trendLines>
	
	</chart>";
}

public function get_cd4_facility_detail($facility_code){
	$county_data=hcmp_stock_status::get_facility_reporting_details($facility_code);
	
	
	$table_body='';
	$fill_rate=0;
	
	if(count($county_data)>0){
		
	
	
	foreach($county_data as $county_detail){
		
			
		
	   $mos=$county_detail['moc'];
	   $unittests=$county_detail['unittests'];
	   $facility_name=$county_detail['facility_name'];
	   
 
	$table_body .="<tr>
	<td>$facility_code</td>
	<td>$facility_name</td>
	<td>$county_detail[test_name]</td>
	<td>$mos</td>
	<td>$unittests</td>
	<td>10</td>
	<td>10</td>
	<td>100 %</td>
	 </tr>";	

	}
	
	}
else{
	//do nothing 
}

$data['table_body']=$table_body;
$this -> load -> view("cd4/ajax_view/facility_zoom_v",$data);
	
	
	
	
}
    function sendmail($message,$output, $reportname) {
        $this->load->helper('file');
        //  $email_address = 'williamnguru@gmail.com';
        //    $message = 'Hi William';
        //      $subject = 'no subject today';
        include 'auto_sms.php';
//        $output = 'This is the output that should be stated on the pdf';
 
        $newmail = new auto_sms();
        $this->load->library('mpdf');
        $mpdf = new mPDF();

        $mpdf->WriteHTML($output);
        $emailAttachment = $mpdf->Output($reportname . '.pdf', 'S');
//	$emailAttachment = chunk_split(base64_encode($emailAttachment));
//	echo $emailAttachment;
        $attach_file = './pdf/' . $reportname . '.pdf';
        if (!write_file('./pdf/' . $reportname . '.pdf', $mpdf->Output('report_name.pdf', 'S'))) {
            $this->session->set_flashdata('system_error_message', 'An error occured');
        } else {
            $email_address = "onjathi@clintonhealthaccess.org";
            $subject = 'Order Report For ' . $reportname;

            $attach_file = './pdf/' . $reportname . '.pdf';
            $bcc_email = 'williamnguru@gmail.com,kariukijackson@gmail.com,tngugi@gmail.com,rickinyua@gmail.com';
            $response = $newmail->send_email($email_address, $message, $subject, $attach_file, $bcc_email);
            // $response= $newmail->send_email(substr($email_address,0,-1),$message,$subject,$attach_file,$bcc_email);
            if ($response) {
                delete_files('./pdf/' . $reportname . '.pdf');
            }
        }
    }

public function send_mail($alloc_period){
date_default_timezone_set('EUROPE/Moscow');
$today = date('dS F Y');
$pdf_html = " ";
 
	$allocation_for = str_split($alloc_period);
	$newdate = $allocation_for[0].':'.$allocation_for[1];
    $date = date('F, Y', strtotime($newdate));
//  $pdf_html .= ($date).'<br />';
$pdf_html .="<div ALIGN=CENTER><img src='" . base_url() . "Images/coat_of_arms.png' height='70' width='70'style='vertical-align: top;' > </img></div>

       <div style='text-align:center; font-family: arial,helvetica,clean,sans-serif;display: block; font-weight: bold; font-size: 14px;'>
       Ministry of Health<br />
       CD4 Allocations for $date</div>
       <hr />";
 
$this->load->database();
$q = $this->db->query('SELECT DISTINCT cd4_allocation.facility_code, cd4_facility.facilityname,cd4_allocation.allocation_for
FROM cd4_allocation, cd4_facility
WHERE cd4_allocation.facility_code = cd4_facility.MFLCode
AND  cd4_allocation.allocation_for = '.$alloc_period.'');
foreach ($q->result_array() as $key => $value) {
//	var_dump($value);
	$mfl = $value['facility_code'];
	$facil = $this->allocation_per_facility($mfl);
	$pdf_html .= $value['facilityname'].' ('.$mfl.')';
	$pdf_html .= "<table>
		<thead>
		<th>Reagent</th>
		<th>Quantity</th>
		</thead>
		<tbody>";

	foreach ($facil as $key => $val) {
		# code...
		$pdf_html .='<tr>
		<td>'.$val['reagentname'].'</td>
		<td>'.$val['qty'].'</td>
		</tr>';
	}
	$pdf_html .= "</tbody></table><hr />";

}
//echo $pdf_html ;
$message = "<div ALIGN=CENTER><img src='" . base_url() . "Images/coat_of_arms.png' height='70' width='70'style='vertical-align: top;' > </img></div>

       <div style='text-align:center; font-family: arial,helvetica,clean,sans-serif;display: block; font-weight: bold; font-size: 14px;'>
       Ministry of Health</div>
       <hr />
<table border='0' style='width:100%;'>
<tr>
<td>Telephone:(020) 2630867<br />Fax: (020) 2710518<br />E-mail: head@nascop.or.ke<br />Office Mobile: 0775-409108<br />Skype: nascop.ke</br />When replying please quote
<br />Ref:NASCOP/ADMIN/MARPs/2013/5
<br />
............................................................<br />
............................................................<br />
To CEO KEMSA<br />
Dear Sir
</td>
<td>
NATIONAL AIDS & STI CONTROL PROGRAM<br />
Kenyatta National Hospital Grounds<br />
P.O. Box 19361, 00202<br />
Nairobi<br />
<br /><br /><br /><br /><br />

$today  

</td>
</tr>
<tr><td COLSPAN='2' style='border-bottom: solid 1px #3C3838;'><strong>RE:	Release of CD4 Reagents  </strong></td></tr>
<tr>
<td COLSPAN='2'>NASCOP is mandated to control HIV commodities. The purpose of this memo is to kindly request the release of CD4 reagents (FACS Calibur, FACS Count, Partec Cyflow) for Q4 2013. Please find the allocation list attached. 
<br /><br />
<strong>Dr. William K. Maina, OGW</strong>
<br /><br />

<u>Head, NASCOP.</u>
<br /><br />
</td>
</tr>
</table> 
";
$reportname = 'CD4 Allocations for '.$date;
$this->sendmail($message,$pdf_html, $reportname);
echo "The reports were sent successfully";
}
public function allocations(){

	$data['table_body']="Hello World"; 
	$data['title'] = "Cd4 Allocations";
	$data['banner_text'] = "CD4 Allocations Countrywide";
	$data['content_view']="cd4/ajax_view/cd4_overall_allocations";
	$data['counties'] = array();
	$countiesid[] = array();
	$countiesnames[] = array();
	$final_arr=array();

$this->load->database();
$sel = $this->db->query('SELECT cd4_facility.facilityname, cd4_facility.MFLCode, cd4_facility.districtname, cd4_allocation.id, cd4_allocation.facility_code, cd4_allocation.reagentID, cd4_allocation.allocation_for, cd4_allocation.qty, cd4_allocation.date_allocated, cd4_allocation.allocated_by, cd4_reagents.reagentname, cd4_reagents.reagentID, cd4_countys.ID, cd4_countys.name, cd4_districts.name, cd4_districts.county, cd4_districts.ID
FROM cd4_facility, cd4_allocation, cd4_reagents, cd4_districts, cd4_countys
WHERE  `cd4_facility`.`MFLCode` =  `cd4_allocation`.`facility_code` 
AND cd4_reagents.reagentID = cd4_allocation.reagentID
AND cd4_countys.ID = cd4_districts.county
AND cd4_facility.district = cd4_districts.ID
AND cd4_allocation.qty>0'); 
$resarr = $sel->result_array();
 
// echo "<pre>";print_r($resarr); echo "</pre>";

$data['allocations'] = $resarr;


$this->load->view('template',$data);
}
public function allocations_county($County)
{
	

	$data['table_body']="Hello World"; 
	$data['title'] = "Cd4 Allocations";
	$data['banner_text'] = "CD4 Allocations";
	$data['content_view']="cd4/ajax_view/cd4_allocations";
	$data['counties'] = array();
	$countiesid[] = array();
	$countiesnames[] = array();
	$final_arr=array();

$this->load->database();
$sel = $this->db->query('SELECT cd4_facility.name, cd4_facility.MFLCode, cd4_facility.districtname, cd4_allocation.id, cd4_allocation.facility_code, cd4_allocation.reagentID, cd4_allocation.allocation_for, cd4_allocation.qty, cd4_allocation.date_allocated, cd4_allocation.allocated_by, cd4_reagents.reagentname, cd4_reagents.reagentID, cd4_countys.ID, cd4_countys.name, cd4_districts.name, cd4_districts.county, cd4_districts.ID
FROM cd4_facility, cd4_allocation, cd4_reagents, cd4_districts, cd4_countys
WHERE  `cd4_facility`.`MFLCode` =  `cd4_allocation`.`facility_code` 
AND cd4_reagents.reagentID = cd4_allocation.reagentID
AND cd4_countys.ID = cd4_districts.county
AND cd4_facility.district = cd4_districts.ID
AND cd4_countys.ID = '.$County.' '); 
$resarr = $sel->result_array();
 
for($i = 0; $i < count($resarr); $i++)
{
    if($i % 2) // OR if(!($i % 2))
    {
        unset($resarr[$i]);
    }
}

$data['allocations'] = $resarr;
return $resarr;

//$this->load->view('template',$data);
 
}
public function loadmonth_alloc($alloc_period)

{ 

date_default_timezone_set('EUROPE/Moscow');
$today = date('dS F Y');
$pdf_html = ' ';
 
	$allocation_for = str_split($alloc_period);
	$newdate = $allocation_for[0].':'.$allocation_for[1];
    $date = date('F, Y', strtotime($newdate));
//  $pdf_html .= ($date).'<br />';
 
 
$this->load->database();
$q = $this->db->query('SELECT DISTINCT cd4_allocation.facility_code, cd4_facility.facilityname,cd4_allocation.allocation_for
FROM cd4_allocation, cd4_facility
WHERE cd4_allocation.facility_code = cd4_facility.MFLCode
AND  cd4_allocation.allocation_for = '.$alloc_period.'');
foreach ($q->result_array() as $key => $value) {
//	var_dump($value);
	$mfl = $value['facility_code'];
	$facil = $this->allocation_per_facility($mfl);
	$pdf_html .= $value['facilityname'].' ('.$mfl.')';
	$pdf_html .= "<table class='data-table'>
		<thead>
 
<th>Reagent</th>
<th>Quantity</th>
 
 
</tr></thead>
		<tbody>";

	foreach ($facil as $key => $val) {
//		var_dump($val);
		# code...
		$pdf_html .='<tr>
 
		<td>'.$val['reagentname'].'</td>
		<td>'.$val['qty'].'</td>
		</tr>';
	}
	$pdf_html .= "</tbody></table><br />";
echo '<button onclick="send_mail('.$alloc_period.')" style="background: #CAEE59;border: solid 1px #ECECEC;">Send mail</button><br />';
echo $pdf_html;
}
}
 public function allocated(){
	//  $data['facility'] =Facilities::get_total_facilities_cd4_in_county($county_id);
	$data['table_body']="Hello World"; 
	$data['title'] = "CD4 Allocations";
	$data['banner_text'] = "County View";
	$data['content_view']="cd4/ajax_view/county_detail_zoom_v";
	$data['counties'] = array();
	$countiesid[] = array();
	$countiesnames[] = array();


		/* Manual Database Config for test putposes. 
		 * Monday presentation is required. no time to create models and integrate the two databases for new database
		 * API will come later
		*/
 
		$counties =$this->db->query('SELECT DISTINCT county, countyname
			FROM cd4_facility, cd4_facilityequipments, cd4_districts
			WHERE cd4_facility.AutoID = cd4_facilityequipments.facility
			AND cd4_facility.district = cd4_districts.ID');

	
		foreach ($counties->result_array() as $countiesarr) {
			array_push($data['counties'], $countiesarr['countyname']);
		//echo $countiesarr['countyname'].' - '.$countiesarr['county'];		
		$county_id = $countiesarr['county'];

		// Query to get facilities details(county,district,name,owner)	
		$facility_e1  = $this->db->query('SELECT * FROM cd4_facility, cd4_facilityequipments, cd4_districts WHERE cd4_facility.AutoID = cd4_facilityequipments.facility AND cd4_facility.district = cd4_districts.ID AND equipment =1 AND county= '.$county_id.' ORDER BY  `cd4_facility`.`name` ASC ');
		foreach ($facility_e1->result_array() as $fe1) {
//			echo "<pre>";
// 			var_dump($fe1);
//			echo "</pre>";
			
			/*$reagents -> $this->db->query('SELECT * 
						FROM facilityequipments, equipments, reagents, equipmentcategories, reagentcategory
						WHERE facilityequipments.equipment = equipments.ID
						AND reagentcategory.equipmentType = equipments.ID
						AND reagents.categoryID = reagentcategory.equipmentType
						AND equipments.category = reagentcategory.equipmentType
						AND facility = '.$facility_id.'');
 */
	}
}
		 
//		$county_id = 1;
//		$res = $this->db->query('SELECT * FROM  `countys` WHERE `ID`='.$county_id.'');
/*		$all_counties = $this->db->query('SELECT * FROM  `cd4_countys` WHERE ID =3');

		foreach
		($all_counties->result_array()as $row){
			var_dump($row);
		$countyid = $row['ID']; // We have the ID of the county 
		echo $countyid;
		$districts_in_county = $this->db->query('SELECT * FROM cd4_districts WHERE `county` = '.$countyid.'');
	 

		foreach ($districts_in_county->result_array() as $districts_row) {
		$district_id =	$districts_row['ID'];
 		echo $district_id."<br />";
 
		$facilities_in_district= $this->db->query('SELECT * FROM `cd4_facility` WHERE `district` = '.$district_id.'');

		foreach ($facilities_in_district->result_array() as $facility_row) {
		$
		echo "<pre>";
		var_dump($facility_row);
		echo "</pre>";

		
		}
   	
	 }

	}
*/
$this->db->close();

$this -> load -> view("template",$data);
}

function loaddistricts($county){
	$districtsarr = array();
		$districts =$this->db->query('SELECT DISTINCT districtname, district
			FROM cd4_facility, cd4_facilityequipments, cd4_districts
			WHERE cd4_facility.AutoID = cd4_facilityequipments.facility
			AND cd4_facility.district = cd4_districts.ID AND countyname = "'.$county.'"');

		if ($districts->num_rows() > 0){
		foreach ($districts->result_array() as $districtsarr) 
		{echo'<option value="'.$districtsarr['district'].'">'.$districtsarr['districtname'].'</option>';}
		} else{echo "<option>No data</option>";}

}
function loadfacilities($district){
	$facilityarr = array();
		$facility =$this->db->query('SELECT fname, facility
FROM cd4_facility, cd4_facilityequipments, cd4_districts
WHERE cd4_facility.AutoID = cd4_facilityequipments.facility
AND cd4_facility.district = cd4_districts.ID
AND district ='.$district.'');

		if ($facility->num_rows() > 0){
		foreach ($facility->result_array() as $facilityarr) 
		{echo'<option value="'.$facilityarr['facility'].'">'.$facilityarr['fname'].'</option>';}
		} else{echo "<option>No data</option>";}
	}
public function get_reported_local($mfl)
{
		function objectToArray( $object ) {
    if( !is_object( $object ) && !is_array( $object ) ) {
        return $object;
    }
    if( is_object( $object ) ) {
        $object = (array) $object;
    }
    return array_map( 'objectToArray', $object );
}

	$this->load->database();
	$q = $this->db->query('SELECT * FROM  `api_facilities` WHERE  `mfl` ='.$mfl.' ORDER BY  `api_facilities`.`id` ASC LIMIT 0 , 1');
	$res = $q->result_array();
//	var_dump($res[0]['json']);

	$fac_arr = $res[0]['json'];
	$fac_arr = json_decode($fac_arr);
	$fac_arr = objectToArray($fac_arr);
//	echo "<pre>";var_dump($fac_arr);echo "</pre>";
	return $fac_arr;
}
	public function facility_api_data($facil_mfl){

 
$url = 'http://nascop.org/cd4/arraytest.php?mfl='.$facil_mfl.''; // url for the aPI

//$url = 'http://localhost/api/arraytest.php';
$string_manual = file_get_contents($url); // Fetchin the API json
//echo $string_manual;
$string_manual = substr($string_manual, 0, -1); // Removes the last string character ']' from the json
//echo $string_manual;
$string_manual = substr($string_manual, 12); // removes the first 12 string characters which includes a '<pre>' tag up to the '['
// echo $string_manual;
 
$now = time();
$this->load->database();
	$data = array(
		'id'=> 'NULL',
		'mfl'=>$facil_mfl,
		'json'=>$string_manual,
		'time'=>$now
		);
	$this->db->insert('api_facilities', $data); 
 /*
$string_manual = json_decode($string_manual); // decoding the json
$string_manual = objectToArray($string_manual); // This is where I convert String Manual to array
  */
	}

public function sync_nascop(){


	$allfacilities = $this->api_get_facilities();
//	
	$reported_facilities_to_sync = array();


 	foreach ($allfacilities as $key => $value) {
	if ($value['particulars']['reported'] > 0){foreach ($value['particulars']['particular'] as  $reportedfacilities)
		{
			
			if ($reportedfacilities['status']=="Reported"){
//				echo "<pre>";var_dump($reportedfacilities);echo "</pre>";
			array_push($reported_facilities_to_sync, $reportedfacilities['mfl']);
			}
}
}}
 foreach ($reported_facilities_to_sync as  $sync_mfl_code) {
// 	echo($sync_mfl_code.'<br />');
 	$this->facility_api_data($sync_mfl_code);
 }
 echo "Success: Facilities Sync Complete, Please wait shortly to sync Counties<br />";
//	echo($allfacilities);
    $allfacilities = json_encode($allfacilities);
 	$now = time();
	$this->load->database();
	$data = array(
		'id'=> 'NULL',
		'json'=>$allfacilities,
		'date_sync'=>$now
		);
	$this->db->insert('api_gen', $data); 
 	echo "Counties Done synchronizing. You are now being redirected to another planet....";
//	echo "Counties Sync Complete. Please wait for Reported facilities sync";
//$allfacilities = $this->api_get_facilities();
 
}
public function i($MFLCode,$year,$month){
	$date = $month.''.$year;
		
		$this->load->database();
 
	$allocated_cd4_query = $this->db->query('SELECT * 
FROM  `cd4_allocation` 
WHERE  `facility_code` ='.$MFLCode.'
AND  `allocation_for`  = '.$date.'');

	$ret = $allocated_cd4_query->result_array();
//	var_dump($ret);
	$ret = json_encode($ret);
	echo $ret;



}

	function loaddevices($facility){

	$facilityarr = array();
	$facility_dev1  = $this->db->query('SELECT * 
FROM cd4_facilityequipments, cd4_equipments, cd4_reagentcategory, cd4_reagents
WHERE cd4_facilityequipments.equipment = cd4_equipments.ID
AND cd4_reagents.categoryID = cd4_equipments.ID
AND cd4_equipments.category = cd4_equipments.ID
AND cd4_reagentcategory.categoryID = 1
AND facility = '.$facility.'');
	$facility_dev2  = $this->db->query('SELECT * 
FROM cd4_facilityequipments, cd4_equipments, cd4_reagentcategory, cd4_reagents
WHERE cd4_facilityequipments.equipment = cd4_equipments.ID
AND cd4_reagents.categoryID = cd4_equipments.ID
AND cd4_equipments.category = cd4_equipments.ID
AND cd4_reagentcategory.categoryID = 2
AND facility = '.$facility.'');
	$facility_dev3  = $this->db->query('SELECT * 
FROM cd4_facilityequipments, cd4_equipments, cd4_reagentcategory, cd4_reagents
WHERE cd4_facilityequipments.equipment = cd4_equipments.ID
AND cd4_reagents.categoryID = cd4_equipments.ID
AND cd4_equipments.category = cd4_equipments.ID
AND cd4_reagentcategory.categoryID = 3
AND facility = '.$facility.'');
	$facility_dev4  = $this->db->query('SELECT * 
FROM cd4_facilityequipments, cd4_equipments, cd4_reagentcategory, cd4_reagents
WHERE cd4_facilityequipments.equipment = cd4_equipments.ID
AND cd4_reagents.categoryID = cd4_equipments.ID
AND cd4_equipments.category = cd4_equipments.ID
AND cd4_reagentcategory.categoryID = 4
AND facility = '.$facility.'');

 
		if ($facility_dev1->num_rows() > 0){
		echo "<table class='data-table' style='font-size: 1.2em;'>";
		echo "<thead><th>Equipment Name</th> 
		<th> Description(Unit)</th>
		<th>Quantity Received(3 months av)</th>
		<th>Quantity Received(3 months av)</th>
		<th>End Balance(June)</th>
		<th>Requested</th>
		<th>Allocated</th></thead>";
		foreach ($facility_dev1->result_array() as $facilityarr) 
		{
			echo "<tr>";
			echo '<td>'.$facilityarr['reagentname'].'</td>';
			echo '<td>'.$facilityarr['name'].'( '.$facilityarr['unit'].')</td>';
			echo '<td>'.$facilityarr['facility'].'</td>';
			echo '<td>'.$facilityarr['category'].'</td>';
			echo '<td>'.$facilityarr['facility'].'</td>';
			echo '<td>'.$facilityarr['facility'].'</td>';
			echo '<td><input type="text" value="0" /></td>';


			echo "</tr>";

		}
		echo "</table/>";
//		echo '<input class="button ui-button ui-widget ui-state-default ui-corner-all" id="allocate" value="Allocate" role="button" aria-disabled="false">';
		echo "<br /><br /><br />";

	}


		if ($facility_dev2->num_rows() > 0){
		echo "<table class='data-table' style='font-size: 1.2em;'>";
		echo "<thead><th>Equipment Name</th> 
		<th> Description(Unit)</th>
		<th>Quantity Received(3 months av)</th>
		<th>Quantity Received(3 months av)</th>
		<th>End Balance(June)</th>
		<th>Requested</th>
		<th>Allocated</th></thead>";
		foreach ($facility_dev2->result_array() as $facilityarr) 
		{
			echo "<tr>";
			echo '<td>'.$facilityarr['reagentname'].'</td>';
			echo '<td>'.$facilityarr['name'].'( '.$facilityarr['unit'].')</td>';
			echo '<td>'.$facilityarr['facility'].'</td>';
			echo '<td>'.$facilityarr['category'].'</td>';
			echo '<td>'.$facilityarr['facility'].'</td>';
			echo '<td>'.$facilityarr['facility'].'</td>';
			echo '<td><input type="text" value="0" /></td>';


			echo "</tr>";

		}
		echo "</table/>";
//		echo '<input class="button ui-button ui-widget ui-state-default ui-corner-all" id="allocate" value="Allocate" role="button" aria-disabled="false">';
		echo "<br /><br /><br />";
	}


		if ($facility_dev3->num_rows() > 0){
		echo "<table class='data-table' style='font-size: 1.2em;'>";
		echo "<thead><th>Equipment Name</th> 
		<th> Description(Unit)</th>
		<th>Quantity Received(3 months av)</th>
		<th>Quantity Received(3 months av)</th>
		<th>End Balance(June)</th>
		<th>Requested</th>
		<th>Allocated</th></thead>";
		foreach ($facility_dev3->result_array() as $facilityarr) 
		{
			echo "<tr>";
			echo '<td>'.$facilityarr['reagentname'].'</td>';
			echo '<td>'.$facilityarr['name'].'( '.$facilityarr['unit'].')</td>';
			echo '<td>'.$facilityarr['facility'].'</td>';
			echo '<td>'.$facilityarr['category'].'</td>';
			echo '<td>'.$facilityarr['facility'].'</td>';
			echo '<td>'.$facilityarr['facility'].'</td>';
			echo '<td><input type="text" value="0" /></td>';


			echo "</tr>";

		}
		echo "</table/>";
//		echo '<input class="button ui-button ui-widget ui-state-default ui-corner-all" id="allocate" value="Allocate" role="button" aria-disabled="false">';
		echo "<br /><br /><br />";
		}


		if ($facility_dev4->num_rows() > 0){
		echo "<table class='data-table' style='font-size: 1.2em;'>";
		echo "<thead><th>Equipment Name</th> 
		<th> Description(Unit)</th>
		<th>Quantity Received(3 months av)</th>
		<th>Quantity Received(3 months av)</th>
		<th>End Balance(June)</th>
		<th>Requested</th>
		<th>Allocated</th></thead>";
		foreach ($facility_dev4->result_array() as $facilityarr) 
		{
			echo "<tr>";
			echo '<td>'.$facilityarr['reagentname'].'</td>';
			echo '<td>'.$facilityarr['name'].'( '.$facilityarr['unit'].')</td>';
			echo '<td>'.$facilityarr['facility'].'</td>';
			echo '<td>'.$facilityarr['category'].'</td>';
			echo '<td>'.$facilityarr['facility'].'</td>';
			echo '<td>'.$facilityarr['facility'].'</td>';
			echo '<td><input type="text" value="0" /></td>';


			echo "</tr>";

		}
		echo "</table/>";
		echo '<input class="button ui-button ui-widget ui-state-default ui-corner-all" id="allocate" value="Allocate" role="button" aria-disabled="false">';
		echo "<br /><br /><br />";
		}

		 else{ 
		echo '<fieldset style="
		    position: absolute;
		    margin-top: 112px;
		    font-size: 2em;
		    border: solid 1px #DDE2BB;
		    padding: 79px;
		    color: rgb(221, 154, 154);
		    background: snow;
		    /* margin-left: 80px; */
		"> <h1>No data has been submitted yet</h1></fieldset>';;}
	 

	}




}
?>