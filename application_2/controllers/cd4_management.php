<?php
if (!defined('BASEPATH'))
	exit('No direct script access allowed');
class cd4_Management extends MY_Controller {
	function __construct() {
		parent::__construct();
		
	}

	public function index() {

		$this->get_kenyan_county_map();
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


public function county_detail_zoom($county_id){
    $data['facility'] =Facilities::get_total_facilities_cd4_in_county($county_id);
	$data['table_body']="Hello World"; 
	$data['title'] = "County View";
	$data['banner_text'] = "County View";
	$data['content_view']="cd4/ajax_view/county_detail_zoom_v";
	$this -> load -> view("template",$data);
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
}
?>