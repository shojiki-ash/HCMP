<?php
class Analyses_Management extends MY_Controller {
	function __construct() {
		parent::__construct();
	}

	public function index() {
		$data = array();
		$this->base_params($data);
	}

	public function base_params($data) {
		$data['title'] = "Data Analyses";
		$data['content_view'] = "data_analyses_v";
		$data['banner_text'] = "Data Analyses";
		$data['link'] = "analyses_management";
		$this -> load -> view("template", $data);
	}


public function test_graph(){
	    $data['title'] = "Data Analyses";
		$data['content_view'] = "ajax_view/test";
		$data['banner_text'] = "Data Analyses";
		$data['link'] = "analyses_management";
		$this -> load -> view("template", $data);
}
public function drh(){
	$test='<chart caption="Brand Winner" yAxisName="Brand Value ($ m)" xAxisName="Brand" bgColor="F1F1F1" showValues="0" canvasBorderThickness="1" canvasBorderColor="999999" plotFillAngle="330" plotBorderColor="999999" showAlternateVGridColor="1" divLineAlpha="0">
         <trendLines>
        <line startValue="430000" color="009933" displayvalue="Target" />
   </trendLines>
        <set label="Coca-Cola" value="67000" toolText="2006 Rank: 1, Country: US"/> 
        <set label="Microsoft" value="56926" toolText="2006 Rank: 2, Country: US"/> 
        <set label="IBM" value="56201" toolText="2006 Rank: 3, Country: US"/> 
        <set label="GE" value="48907" toolText="2006 Rank: 4, Country: US"/> 
        <set label="Intel" value="32319" toolText="2006 Rank: 5, Country: US"/> 
        <set label="Nokia" value="30131" toolText="2006 Rank: 6, Country: Finland"/> 
        <set label="Toyota" value="27941" toolText="2006 Rank: 7, Country: Japan"/> 
        <set label="Disney" value="27848" toolText="2006 Rank: 8, Country: US"/> 
        <set label="McDonalds" value="27501" toolText="2006 Rank: 9, Country: US"/> 
        <set label="Mercedes-Benz" value="21795" toolText="2006 Rank: 10, Country: Germany"/> 
</chart>';
echo $test;
}
}
