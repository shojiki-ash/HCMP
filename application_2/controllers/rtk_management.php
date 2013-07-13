<?php
if (!defined('BASEPATH'))
	exit('No direct script access allowed');
class Rtk_Management extends MY_Controller {
	function __construct() {
		parent::__construct();
		
	}

	public function index() {

		echo "Jack";
	}
	
	public function rtk_mapping(){
		$data = array();
		$data['title'] = "Facility Mapping";
		$data['banner_text'] = "Facility Mapping";

	    $data['content_view'] = "rtk/facility_mapping_v";
	  
	  
	  
	  $this -> load -> view("template",$data);
	
	}
	
	public function county_rtk_mapping(){
		$data = array();
		$data['title'] = "Facility Mapping";
		$data['banner_text'] = "Facility Mapping";

	    $data['content_view'] = "";
	  
	    $data['county'] = Counties::getAll();
		         
						
		$owner_array=array("GOK","CBO","FBO","NGO","Private","Other");
		$counties=Counties::getAll();;
		$table_body='';
		
		foreach($counties as $county_detail){
			$id=$county_detail->id;
			$table_body .="<tr><td><a class='ajax_call_1' id='county_facility' name='get_rtk_county_detail/$id' href='#'> $county_detail->county </a></td>";
			
			$county_detail=facilities::get_total_facilities_rtk($id);
			
			$table_body .="<td>".$county_detail[0]['total_facilities']."</td><td>".$county_detail[0]['total_rtk']."</td>";
			foreach($owner_array as $key => $value){
				
				$owner_count=facilities::get_total_facilities_rtk_ownership($id, $value);
				
				
				$table_body .="<td>".$owner_count[0]['ownership_count']."</td>";
			}
			$table_body .="</tr>";
			
		}

		$data['table_body']=$table_body;
	  
	  $this -> load -> view("rtk/ajax_view/county_rtk_v",$data);
	}
	public function get_rtk_county_detail($county_id){
		$data['title'] = "Facilities";
	//	$data['content_view'] = "facilities_rtk_v";
		$data['banner_text'] = "Facility List";
		$data['link'] = "rtk_management";
		$data['doghnut']="county";
		$data['bar_chart']="county";
		$data['county_id']=$county_id;
		//////////////////////owners
		$data['facility'] =Facilities::get_total_facilities_rtk_in_county($county_id);
		$data['quick_link'] = "commodity_list";
		$this -> load -> view("rtk/ajax_view/rtk_facility_list_v", $data);
	
	}

/////////////////////////////////////////////////////////////////////////
	public function facility_ownership_doghnut($option,$county_id=null){
		$str_xml_body='';
		$title="";
		if($option=="county"){
			$county_name=Counties::get_county_name($county_id);
			$county_data=Facilities::get_total_facilities_rtk_ownership_in_a_county($county_id);
			$county_name=$county_name[0]['county'];
			$title="$county_name";
			foreach($county_data as $county_detail){
				$str_xml_body .="<set value='$county_detail[ownership_count]' label='$county_detail[owner]' alpha='60'/>";
			}
		}
		else{
			$title='Country wide';
			$str_xml_body='';
			$county_data=Facilities::get_total_facilities_rtk_ownership_in_the_country();
			
			foreach($county_data as $county_detail){
				$str_xml_body .="<set value='$county_detail[ownership_count]' label='$county_detail[owner]' alpha='60'/>";
			}
		}
		
$strXML = "<chart formatNumber='1' caption='Facility Ownership: $title' bgColor='FFFFFF' showPercentageValues='1' showborder='0'   isSmartLineSlanted='0' showValues='1' showLabels='1' showLegend='1'>";   
$strXML .="$str_xml_body</chart>";
echo $strXML;	
}
	public function get_facility_ownership_doghnut_ajax(){
		$this -> load -> view("county_rtk_v");
	}
	
	public function facility_ownership_bar_chart($option,$county_id=null){
		$str_xml_body='';
		$title="";
		if($option=="county"){
			$county_name=Counties::get_county_name($county_id);
			$county_data=Facilities::get_total_facilities_rtk_ownership_in_a_county($county_id);
			$county_name=$county_name[0]['county'];
			$title="$county_name";
			foreach($county_data as $county_detail){
				$str_xml_body .="<set value='$county_detail[ownership_count]' label='$county_detail[owner]'/> ";
			}
		}
		else{
			$title='Country wide';
			$str_xml_body='';
			$county_data=Facilities::get_total_facilities_rtk_ownership_in_the_country();
			
			foreach($county_data as $county_detail){
				$str_xml_body .="<set value='$county_detail[ownership_count]' label='$county_detail[owner]'/> ";
			}
		}
$strXML ="<chart caption='Facility Ownership : $title' yAxisName='Number of facilities' xAxisName='Owner' alternateVGridColor='AFD8F8' baseFontColor='114B78' toolTipBorderColor='114B78' toolTipBgColor='E7EFF6' useRoundEdges='1' showBorder='0' bgColor='FFFFFF,FFFFFF'>";

        
$strXML .="$str_xml_body</chart>";

echo $strXML;	
}

public function facility_ownership_combined_bar_chart(){
	
	                    $color_array['baseline'] = array('659EC7','E8E8E8');
                        $color_array['midterm'] = array('FBB117','E8E8E8');
                        $color_array['endterm'] = array('59E817','E8E8E8');
	
	 $chart = '<chart decimals="0" sDecimals="0" slantLabels="0" baseFontSize="10" stack100Percent="1" showPercentValues="1" caption="RTK Allocation per County"  showLegend="1"palette="3"numdivlines="3" useRoundEdges="1" showsum="0" bgColor="FFFFFF" showBorder="0" exportEnabled="1" exportHandler="' . base_url() . 'scripts/FusionCharts/ExportHandlers/PHP/FCExporter.php" exportAtClient="0" exportAction="download">';
	$chart_categories="<categories>";
	$chart_xml_body_total_facilities_with_trk="";
	$chart_xml_body_total_facilities_without_rtk="";
	
	$counties = Counties::getAll();
	 
	 foreach($counties as $county_detail){
	 	$chart_categories .= "<category label='$county_detail->county'/>";
	 	
	 	$county_data=facilities::get_total_facilities_rtk($county_detail->id);
	 	
		$total_no_facilities=$county_data[0]['total_facilities'];
		$total_no_allocated_rtk=$county_data[0]['total_rtk'];
		$balance=$total_no_facilities-$total_no_allocated_rtk;
		
		$chart_xml_body_total_facilities_with_trk .='<set  value="'.$total_no_allocated_rtk.'" />';
		$chart_xml_body_total_facilities_without_rtk .='<set  value="'.$balance.'" />';
		
		
	 }
$chart_categories .="</categories>";
	  $chart .=$chart_categories.'<dataset>
	  <dataset seriesName="Allocated RTK" color="'.$color_array['baseline'][0].'"> 
	  '.$chart_xml_body_total_facilities_with_trk.'
 </dataset>
 '.'<dataset showValues="0" color="'.$color_array['baseline'][1].'">
 '.$chart_xml_body_total_facilities_without_rtk.'</dataset>
 </dataset></chart>';
	 
	 echo $chart;
	
}

public function get_rtk_county_distribution_allocation_detail(){
     	$distribution_allocation_data=rtk_stock_status::get_rtk_alloaction_distribution(1);
		$distribution_allocation_data_1=rtk_stock_status::get_rtk_alloaction_distribution(2);
		
		$table_body="";
		$table_body_1="";
		
		foreach($distribution_allocation_data as $data_1){
			$table_body .="<tr><td>$data_1[county]</td><td>$data_1[qty_requested]</td>
			<td>$data_1[distributed]</td><td>$data_1[allocated]</td></tr>";
			
			
		}
		
		foreach($distribution_allocation_data_1 as $data_2){
			$table_body_1 .="<tr><td>$data_2[county]</td><td>$data_2[qty_requested]</td>
			<td>$data_2[distributed]</td><td>$data_2[allocated]</td></tr>";
			
			
		}
		$data['table_body']=$table_body;
		$data['table_body_1']=$table_body_1;
		$this -> load -> view("rtk/ajax_view/rtk_allocation_dist_v",$data);
	
	}

public function get_rtk_distribution_allocation($commodity){
	$distribution_allocation_data=rtk_stock_status::get_rtk_alloaction_distribution($commodity);
	
	if($commodity=="1"){
		$title="Rapid HIV 1+ 2 Test Kit  (Unigold)";
	}else{
		$title="Rapid HIV 1+2 Test Kit (Determine)";
	}
	
	 $chart = '<chart decimals="0" sDecimals="0" baseFontSize="12"  showLegend="1" caption="'.$title.'"  palette="3"numdivlines="3" useRoundEdges="1" showsum="0" bgColor="FFFFFF" showBorder="0" exportEnabled="1" exportHandler="' . base_url() . 'scripts/FusionCharts/ExportHandlers/PHP/FCExporter.php" exportAtClient="0" exportAction="download">';
	$chart_categories="<categories>";
	$chart_xml_body_qty_requested="";
	$chart_xml_body_qty_distributed="";
	$chart_xml_body_qty_allocated="";
	
	foreach($distribution_allocation_data as $data){
		
	$chart_categories .="<category label='$data[county]'/>";
	$chart_xml_body_qty_requested.='<set  value="'.$data['qty_requested'].'" />';
	$chart_xml_body_qty_distributed.='<set  value="'.$data['distributed'].'" />';
	$chart_xml_body_qty_allocated.='<set  value="'.$data['allocated'].'" />';
	
		
	}
	$chart_categories .="</categories>";
	
	
	$chart .=$chart_categories.'<dataset>
	 <dataset seriesName="Requested Quantities"> 
	 '.$chart_xml_body_qty_requested.'
 </dataset>
 </dataset>
 <dataset>
  <dataset seriesName="Distributed Quantities"> 
	 '.$chart_xml_body_qty_distributed.'
 </dataset>
 </dataset>
 <dataset>
  <dataset seriesName="Allocated Quantities"> 
	 '.$chart_xml_body_qty_allocated.'
 </dataset>
	</dataset></chart>';
	
	echo $chart;
	
	
}

public function get_report($report_type){
	if($report_type=="fcdrr"){
		$this -> load -> view("rtk/ajax_view/fcdrr_v");
	}
	else{
		$this -> load -> view("rtk/ajax_view/lab_commodities_three_v");
	}
	
	
}

public function get_reporting_rate(){
			$counties=Counties::getAll();
			
			
			$national_reporting=rtk_stock_status::get_reporting_rate_national();
			
			
		$table_body='';
		
		foreach($counties as $county_detail){
			$id=$county_detail->id;
			$table_body .="<tr><td><a class='ajax_call_1' id='county_facility' name='get_rtk_county_detail/$id' href='#'> $county_detail->county </a></td>";
			
			$county_detail=rtk_stock_status::get_reporting_county($id);
			
			$table_body .="<td>".$county_detail[0]['total_facilities']."</td><td>".$county_detail[0]['reported']."</td>";

			$table_body .="</tr>";
			
		}
		
		//$national_reporting=rtk_stock_status::get_reporting_rate_national();

		$table_body .="<tr><td>TOTAL</td><td>".$national_reporting[0]['total_facilities']."</td><td>".$national_reporting[0]['reported']."</td></tr>";

       

		$data['table_body']=$table_body;
		$this -> load -> view("rtk/ajax_view/rtk_reporting_rate_v",$data);
	
	
}

public function get_reporting_rate_national_doghnut($option,$county_id=NULL){
		$str_xml_body='';
		$title="";
		if($option=="county"){
			$county_name=Counties::get_county_name($county_id);
			$county_data=rtk_stock_status::get_reporting_county($county_id);
			$county_name=$county_name[0]['county'];
			$title="$county_name";
			foreach($county_data as $county_detail){
				$str_xml_body .="<set value='$county_detail[total_facilities]' label='Total Facilities' alpha='60'/>";
				$str_xml_body .="<set value='$county_detail[reported]' label='Reporting Facilities' alpha='60'/>";
			}
		}
		else{
			$title='Country wide';
			$str_xml_body='';
			$county_data=rtk_stock_status::get_reporting_rate_national();
			
			foreach($county_data as $county_detail){
				$str_xml_body .="<set value='$county_detail[total_facilities]' label='Total Facilities' alpha='60'/>";
				$str_xml_body .="<set value='$county_detail[reported]' label='Reporting Facilities' alpha='60'/>";
			}
		}
		
$strXML = "<chart formatNumber='1' caption='Facility Reporting Rate: $title' bgColor='FFFFFF' showPercentageValues='1' showborder='0'   isSmartLineSlanted='0' showValues='1' showLabels='1' showLegend='1'>";   
$strXML .="$str_xml_body</chart>";
echo $strXML;
	
}


public function get_reporting_rate_national_bar($option,$county_id=NULL){
		$str_xml_body='';
		$title="";
		if($option=="county"){
			$county_name=Counties::get_county_name($county_id);
			$county_data=rtk_stock_status::get_reporting_county($county_id);
			$county_name=$county_name[0]['county'];
			$title="$county_name";
			foreach($county_data as $county_detail){
				$str_xml_body .="<set value='$county_detail[total_facilities]' label='Total Facilities'/>";
				$str_xml_body .="<set value='$county_detail[reported]' label='Reporting Facilities'/>";
			}
		}
		else{
			$title='Country wide';
			$str_xml_body='';
			$county_data=rtk_stock_status::get_reporting_rate_national();
			
			foreach($county_data as $county_detail){
				$str_xml_body .="<set value='$county_detail[total_facilities]' label='Total Facilities' />";
				$str_xml_body .="<set value='$county_detail[reported]' label='Reporting Facilities' />";
			}
		}
		
$strXML = "<chart caption='Facility Reporting Rate : $title' yAxisName='Number of facilities' alternateVGridColor='AFD8F8' baseFontColor='114B78' toolTipBorderColor='114B78' toolTipBgColor='E7EFF6' useRoundEdges='1' showBorder='0' bgColor='FFFFFF,FFFFFF'>";   
$strXML .="$str_xml_body</chart>";
echo $strXML;
	
}

public function facility_reporting_combined_bar_chart(){
	
	                    $color_array['baseline'] = array('659EC7','E8E8E8');
                        $color_array['midterm'] = array('FBB117','E8E8E8');
                        $color_array['endterm'] = array('59E817','E8E8E8');
	
	 $chart = '<chart decimals="0" sDecimals="0" slantLabels="0" baseFontSize="10" stack100Percent="1" showPercentValues="1" caption="RTK Allocation per County"  showLegend="1"palette="3"numdivlines="3" useRoundEdges="1" showsum="0" bgColor="FFFFFF" showBorder="0" exportEnabled="1" exportHandler="' . base_url() . 'scripts/FusionCharts/ExportHandlers/PHP/FCExporter.php" exportAtClient="0" exportAction="download">';
	$chart_categories="<categories>";
	$chart_xml_body_total_facilities_with_trk="";
	$chart_xml_body_total_facilities_without_rtk="";
	
	$counties = Counties::getAll();
	 
	 foreach($counties as $county_detail){
	 	$chart_categories .= "<category label='$county_detail->county'/>";
	 	
	 	$county_data=rtk_stock_status::get_reporting_county($county_detail->id);
	 	
		$total_no_facilities=$county_data[0]['total_facilities'];
		$total_no_allocated_rtk=$county_data[0]['reported'];
		$balance=$total_no_facilities-$total_no_allocated_rtk;
		
		$chart_xml_body_total_facilities_with_trk .='<set  value="'.$total_no_allocated_rtk.'" />';
		$chart_xml_body_total_facilities_without_rtk .='<set  value="'.$balance.'" />';
		
		
	 }
$chart_categories .="</categories>";
	  $chart .=$chart_categories.'<dataset>
	  <dataset seriesName="Reported" color="'.$color_array['baseline'][0].'"> 
	  '.$chart_xml_body_total_facilities_with_trk.'
 </dataset>
 '.'<dataset showValues="0" color="'.$color_array['baseline'][1].'">
 '.$chart_xml_body_total_facilities_without_rtk.'</dataset>
 </dataset></chart>';
	 
	 echo $chart;
	
}

	public function get_facility_ownership_bar_chart_ajax(){

		
		$this -> load -> view("county_rtk_v");
	}
	
	
	public function get_kenyan_county_map(){
		$this -> load -> view("rtk/ajax_view/kenya_county_v");
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
   	
	  $county_detail=rtk_stock_status::get_reporting_county($countyid);
	   $total_facilities=$county_detail[0]['total_facilities'];
	   $reporting_facilities=$county_detail[0]['reported'];
	  
	 
	   
	   $reporting_rate=round((($reporting_facilities/$total_facilities)*100),1);
    	$map .="<entity  link='rtk_management/county_detail_zoom/$countyid' id='$county_map_id' displayValue ='$countyname' color='".array_rand($colors,1)."'  toolText='County :$countyname&lt;BR&gt; Total Facilities :".$total_facilities."&lt;BR&gt; Facilities Reporting  :".$reporting_facilities."&lt;BR&gt; Facility Reporting Rate :".$reporting_rate." %'/>";
   	
	
	 
	
	
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
		
	$data['facility'] =Facilities::get_total_facilities_rtk_in_county($county_id);

	$data['doghnut']="county";
	$data['bar_chart']="county";
    $data['county_id']=$county_id;
	$data['content_view']="rtk/ajax_view/county_detail_zoom_v";
	$data['title'] = "County View";
	$data['banner_text'] = "County View";
	$this -> load -> view("template",$data);
	
}

public function get_rtk_facility_detail($facility_code){
	$county_data=rtk_stock_status::get_facility_reporting_details($facility_code);
	
	$table_body='';
	$fill_rate=0;
	
	if(count($county_data)>0){
		
	
	
	foreach($county_data as $county_detail){
		
			
		
	   $total_requested=$county_detail['qty_requested'];
	   $total_delivered=$county_detail['distributed'];
	   @$fill_rate=round((($total_delivered/$total_requested)*100),1);	
        if($county_detail['commodity']==1){
        	$commodity="Rapid HIV 1+ 2 Test Kit  (Unigold)";
        }
 if($county_detail['commodity']==2) {
	$commodity="Rapid HIV 1+2 Test Kit (Determine)";
}

if($county_detail['commodity']==3) {
	$commodity="Rapid Syphillis Test (RPR)";
}
 
	$table_body .="<tr>
	<td>$county_detail[facility_code]</td>
	<td>$county_detail[facility_name]</td>
	<td>$county_detail[owner]</td>
	<td>$commodity</td>
	<td>$county_detail[qty_requested]</td>
	<td>$county_detail[allocated]</td>
	<td>$county_detail[distributed]</td>
	<td>$fill_rate %</td>
	 </tr>";	

	}
	
	}
else{
	//do nothing 
}

$data['table_body']=$table_body;
$this -> load -> view("rtk/ajax_view/facility_zoom_v",$data);

//echo $table_body;
}
	
}



?>