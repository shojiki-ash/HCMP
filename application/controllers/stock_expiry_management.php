<?php
include_once 'auto_sms.php';
class Stock_Expiry_Management extends auto_sms {

	function __construct() {
		parent::__construct();
		$this->load->helper(array('form','url'));
	}
	
	public function index() {
		$data['title'] = "Potential expiries";
		$data['content_view'] = "stockouts_v";
		$data['banner_text'] = "Potential expiries";
		$data['link'] = "Emergecy";
		$data['quick_link'] = "Emergecy";
		$this -> load -> view("template", $data);
	}
	public function default_expiries(){
		$facility_c=$this -> session -> userdata('news');
		$data['report']=Facility_Stock::expiries($facility_c);
	    $mycount= count(Facility_Stock::expiries($facility_c));
		if ($mycount>0) {
			$this -> load -> view("potential_expiries_v", $data);
		} else {
			echo '<div class="norecord"></div>';
		}
	}
		public function default_expiries_notification(){
		
		$facility_c=$this -> session -> userdata('news');
		$data['report']=Facility_Stock::expiries($facility_c);
		$data['title'] = "Potential expiries";
		$data['content_view'] = "potential_expiries_v";
		$data['banner_text'] = "Potential expiries";
		$data['link'] = "Potential expiries";
		$data['quick_link'] = "Potential expiries";
	    $mycount= count(Facility_Stock::expiries($facility_c));
		if ($mycount>0) {
			$this -> load -> view("template", $data);
		} else {
			echo '<div class="norecord"></div>';
		}
				
	}
public function get_expiries(){
		$checker=$_POST['id'];
		//echo $checker;
		$facility=$this -> session -> userdata('news');
		
			switch ($checker)
			{
				case '6months':
					$date= date('Y-m-d', strtotime('+6 months'));
					$date1=date('Y-m-d');
					$data['report']=Facility_Stock::getStockouts($date,$facility,$date1);
					break;
					case '3months':
						$date= date('Y-m-d', strtotime('+3 month'));
						$date1=date('Y-m-d');
					    $data['report']=Facility_Stock::getStockouts($date,$facility,$date1);
					break;
						case '12months':
						$date= date('Y-m-d', strtotime('+12 month'));
						$date1=date('Y-m-d');
					    $data['report']=Facility_Stock::getStockouts($date,$facility,$date1);
						break;
								default :
								$data['report']=Facility_Stock::expiries($facility);			
			}
		
				$this -> load -> view("potential_expiries_v", $data);
	}

//function to generate report on potential expiries
public function get_expiry(){
	//$option=$this->uri->segment(3);
		$i=$_POST['interval'];
		$facility=$this -> session -> userdata('news');
		$drug_name=Drug::get_drug_name();
		$title='test';
		
			
			switch ($i)
			{
				case '6_months'://for 6 months
					$date= date('Y-m-d', strtotime('+6 months'));
					$date1=date('Y-m-d');
					$report=Facility_Stock::getStockouts($date,$facility,$date1);
					$report_name="Drugs Expiring in next 6 Months ";
					break;
					case '2_months'://for 3 months
						$date= date('Y-m-d', strtotime('+2 month'));
						$date1=date('Y-m-d');
					    $report=Facility_Stock::getStockouts($date,$facility,$date1);
					$report_name="Drugs Expiring in next 2 Months ";
					break;
						case '12_months'://for a year
						$date= date('Y-m-d', strtotime('+12 month'));
						$date1=date('Y-m-d');
					    $report=Facility_Stock::getStockouts($date,$facility,$date1);
					$report_name="Drugs Expiring in next 1 Year ";
						break;
								default :
								$data['stockouts']=Facility_Stock::expiries($facility);	
								$report_name="Drugs Expiring in next 1 Year ";
									
			}
									/**************************************set the style for the table****************************************/

$html_data='<style>table.data-table {border: 1px solid #DDD;margin: 10px auto;border-spacing: 0px;}
table.data-table th {border: none;color: #036;text-align: center;background-color: #F5F5F5;border: 1px solid #DDD;border-top: none;max-width: 450px;}
table.data-table td, table th {padding: 4px;}
table.data-table td {border: none;border-left: 1px solid #DDD;border-right: 1px solid #DDD;height: 30px;margin: 0px;border-bottom: 1px solid #DDD;}
.col5{background:#C9C299;}</style>';


		$html_data1 ='';	
		
		/*****************************setting up the report*******************************************/

$html_data1 .='<table class="data-table"><thead>

			<tr > <th ><strong>Kemsa Code</strong></th>
			<th><strong>Description</strong></th>
			<th><strong>Unit size</strong></th>
			<th><strong>Unit Cost</strong></th>
			<th><strong>Batch No</strong></th>
			<th><strong>Expiry Date</strong></th>
			<th ><strong><b>Units</b></strong></th>
			<th ><strong><b>Stock Worth(Ksh)</b></strong></th>

</tr> </thead><tbody>';

/*******************************begin adding data to the report*****************************************/

	foreach($report as $drug){
			
				foreach($drug->Code as $d){
								$name=$d->Drug_Name;
								$code=$d->Kemsa_Code;
					            $unitS=$d->Unit_Size; 
								$unitC=$d->Unit_Cost;
							    
							    }
							$calc=$drug->balance;
		 $html_data1 .='<tr><td>'.$code.'</td>
							<td>'.$name.'</td>
							<td>'.$unitS.'</td>
							<td>'.$unitC.'</td>
							<td >'.$drug->batch_no.'</td>
							<td>'.$drug->expiry_date.'</td>
							<td >'.$drug->balance.'</td>
							<td >'.$calc*$unitC.'</td>
							</tr>';

/***********************************************************************************************/
					
		  }
		$html_data1 .='</tbody></table>';

		
			$html_data .= $html_data1;
		
		
         
	  	//$this->generate_pdf($report_name,$title,$html_data);
		$this->getpdf($report_name,$title,$html_data);
				
			}

public function generate_pdf($report_name,$title,$data){
		
		      	
        $html_title= '<link href="'.base_url().'CSS/style.css" type="text/css" rel="stylesheet"/> 
				<img src="'.base_url().'Images/coat_of_arms.png" style="position:absolute;  width:100px; width:100px; top:0px; left:0px; margin-bottom:-100px;margin-right:-100px;"></img>
		 <div id="system_title">
		<span style="display: block; font-weight: bold; font-size: 14px; margin:2px;">Ministry of Public Health and Sanitation/Ministry of Medical Services</span>
		<span style="display: block; font-size: 12px;">Health Commodities Management Platform</span>
		</div>
		</div>
		<span style="display: block; font-size: 24px; font-weight: bold; text-align:center; font-family:georgia,garamond,serif;">'.$report_name.'</span></br>
		<div align="center"> 
		<form action="'.base_url().'Stock_Expiry_Management/get" >
		<button class="btn1" ></button>
		 </form></div>
		<span style="text-align:center;" ></br><hr /> 
        ';
		
            echo $html_title.$data;

        }

public function getpdf($report_name,$title,$data)
{
		/********************************************setting the report title*********************/
			
		$html_title="<img src='".base_url()."Images/coat_of_arms.png' style='position:absolute;  width:160px; width:160px; top:0px; left:0px; margin-bottom:-100px;margin-right:-100px;'></img>
       <h2 style='text-align:center;'>".$report_name."</h2><br><br>
       <span style=' margin-left:500px; text-align:center; font-family: arial,helvetica,clean,sans-serif;display: block; font-weight: bold; font-size: 14px;'>
     Ministry of Public Health and Sanitation/Ministry of Medical Services</span><br>
       <span style='display: block; font-size: 12px;'>Health Commodities Management Platform</span><span style='text-align:center;' ><hr /> 
        <span><p style='font-weight: bold;'>Kemsa Code:</p><p style='font-weight: bold;'> Drug Description:</p>
         ";
		
		///**********************************initializing the report **********************/
            $this->load->library('mpdf');
           $this->mpdf = new mPDF('', 'A4-L', 0, '', 15, 15, 16, 16, 9, 9, '');
           $this->mpdf->SetTitle($title);
           $this->mpdf->WriteHTML($html_title);
           $this->mpdf->simpleTables = true;
            $this->mpdf->WriteHTML('<br/>');
            $this->mpdf->WriteHTML($data);
			$report_name = $report_name.".pdf";
           $this->mpdf->Output($report_name,'D');
			
		
		
}

public function Decommission1(){
	$date= date('Y-m-d');
		$facility=$this -> session -> userdata('news');
			$decom=Facility_Stock::getdecommissioned($date,$facility);
			echo $decom;	
}

public function expired($facility_code=NULL) {
		$date= date('Y-m-d');
		if (!isset($facility_code)) {			
			$facility=$this -> session -> userdata('news');
		}else{
			$facility=$facility_code;
		}
		$district=$this -> session -> userdata('district');
		$data['dpp_array']=User::get_dpp_details($district);
		//echo $date;
		$data['title'] = "Expired Products";
		$data['content_view'] = "expire_v";
		$data['banner_text'] = "Expired Products";
		$data['expired']=Facility_Stock::getexp($date,$facility);
		$data['county_view'] = "County View";
		$data['link'] = "expire_v";
		$data['quick_link'] = "expire_v";
		$this -> load -> view("template", $data);
	}

public function county_expiries() {
		$date= date('Y-m-d');
		$county=$this -> session -> userdata('county_id');
		$data['title'] = "Expired Products";
		$data['content_view'] = "county/county_expiries_v";
		$data['banner_text'] = "Expired Products";
		$data['potential_expiries']=Counties::get_potential_expiry_summary($county);
		$data['expired2']=Counties::get_county_expiries($date,$county);
		
		$data['link'] = "county_expiries_v";
		$data['quick_link'] = "county_expiries_v";

		$this -> load -> view("template", $data);
	}


	public function district_expiries($district=NULL) {
		
		$date= date('Y-m-d');
		$county=$this -> session -> userdata('county_id');
		$data['title'] = "Expired Products";
		$data['content_view'] = "county/district_expiries_v";
		$data['banner_text'] = "Expired Products";
		$data['expired']=Districts::get_district_expiries($date,$district);
		$data['potential_expiries']=Counties::get_potential_expiry_summary($county);
		$data['link'] = "district_expiries_v";
		$data['quick_link'] = "district_expiries_v";

		$this -> load -> view("county/district_expiries_v", $data);
	}

	public function county_potential_expiries($facility_code=NULL){
		if (!isset($facility_code)) {			
			$facility_c=$this -> session -> userdata('news');
		}else{
			$facility_c=$facility_code;
		}		
		$data['title'] = "Potential Expiries";
		$data['content_view'] = "county/county_potential_expiries_v";
		$data['banner_text'] = "Expired Products";
		$data['report']=Facility_Stock::expiries($facility_c);
	    $data['mycount']= count(Facility_Stock::expiries($facility_c));

		$data['expired']=Districts::get_district_expiries($date,$district);
		$data['potential_expiries']=Counties::get_potential_expiry_summary($county);
		
		$data['table_body2']="";
		if (count($data['expired'])) {
		foreach ($data['expired'] as $item) {
			$data['table_body2'].="<tr>
			<td>".$item['facility_code']."</td>
			<td>".$item['facility_name']."</td>
			<td>".$item['balance']."</td>
			<td><a href=".site_url('stock_expiry_management/expired/'.$item['facility_code'])." class='link'>View</a></td>
			</tr>";
			}
		}
			else{
			$data['table_body2']="<div id='notification'>No records found</div>";
		}

		$this -> load -> view("template", $data);
	}
	public function county_get_potential_expiries(){
		$checker=$_POST['id'];
		$county=$this -> session -> userdata('county_id');
				
			switch ($checker)
			{
				case '6months':
					$date= date('Y-m-d', strtotime('+6 months'));
					$date1=date('Y-m-d');
					$data['potential_expiries']=Counties::get_county_p_stockouts($date,$county,$date1);
					break;
					case '3months':
						$date= date('Y-m-d', strtotime('+3 month'));
						$date1=date('Y-m-d');
					    $data['potential_expiries']=Counties::get_county_p_stockouts($date,$county,$date1);
					break;
						case '12months':
						$date= date('Y-m-d', strtotime('+12 month'));
						$date1=date('Y-m-d');
					    $data['potential_expiries']=Counties::get_county_p_stockouts($date,$county,$date1);
						break;
								default :
								$data['potential_expiries']=Counties::get_potential_expiry_summary($county);			
			}
		
				$this -> load -> view("county/county_potential_expiries_v", $data);
	}


	public function district_potential_expiries($district=NULL) {
		$date= date('Y-m-d');
		$county=$this -> session -> userdata('county_id');
		$data['title'] = "Expired Products";
		$data['content_view'] = "county/district_potential_expiries_v";
		$data['banner_text'] = "Expired Products";
		$data['expired']=Districts::get_district_expiries($date,$district);
		$data['potential_expiries']=Counties::get_potential_expiry_summary($county);
		$data['link'] = "county/district_expiries_v";
		$data['quick_link'] = "county/district_expiries_v";
		$data['table_body']="";
		if (count($data['potential_expiries'])>0) {		
		foreach ($data['potential_expiries'] as $item) {
		$data['table_body'].="<tr><td>".$item['facility_code']."</td>
			<td>".$item['facility_name']."</td>
			<td>".$item['balance']."</td>
			<td><a href=".site_url('stock_expiry_management/county_potential_expiries/'.$item['facility_code'])." class='link'>View</a></td>
			</tr>}";
		}
		}else{
			$data['table_body']="<div id='notification'>No records found</div>";
		}
		$this -> load -> view("county/district_potential_expiries_v", $data);
	}
	
	public function county_deliveries() {
		$date= date('Y-m-d');
		$county=$this -> session -> userdata('county_id');
		$data['title'] = "Deliveries";
		$data['content_view'] = "county/county_deliveries_v";
		$data['banner_text'] = "Deliveries";
		$data['delivered']=Counties::get_county_received($county);
		$data['order_counts']=Counties::get_county_order_details($county);
		$data['order_details']=Ordertbl::get_county_orders($county);
		$data['link'] = "county/county_deliveries_v";
		$data['quick_link'] = "county/county_deliveries_v";

		$this -> load -> view("template", $data);
	}
public function district_deliveries($district=NULL) {
		
		$date= date('Y-m-d');
		$data['title'] = "Deliveries";
		$data['content_view'] = "county/district_deliveries_v";
		$data['banner_text'] = "Deliveries";
		$data['delivered']=Counties::get_district_received($district);
		$data['link'] = "county/district_expiries_v";
		$data['quick_link'] = "county/district_expiries_v";
		$data['table_body3']="";
		if (count($data['delivered']>0)) {
		foreach ($data['delivered'] as $item) {
		$data['table_body3'].="<tr>
		<td>".$item['facility_code']."</td>
		<td>".$item['facility_name']."</td>
		<td>".$item['orderTotal']."</td>
		<td><a href=".site_url('order_management/moh_order_details/'.$item['id'])." class='link'>View</a></td>
		</tr>";
		}
		}else{
			$data['table_body3']="<div id='notification'>No records found</div>";
		}
	
		$this -> load -> view("county/district_deliveries_v", $data);
	}
public function facility_report_expired() {
		$date= date('Y-m-d');
		$facility=$this -> session -> userdata('news');
		$district=$this -> session -> userdata('district');
		$data['dpp_array']=User::get_dpp_details($district);
		$data['title'] = "Expired Products";
		$data['content_view'] = "facility_report_expired_v";
		$data['banner_text'] = "Expired Products";
		$data['expired']=Facility_Stock::getexp($date,$facility);
		
		$data['link'] = "facility_report_expired_v";
		$data['quick_link'] = "facility_report_expired_v";
		$this -> load -> view("facility_report_expired_v", $data);
	}
	public function get_decommission_report_pdf() {
		$facilityCode= $this-> session-> userdata('news');
		$date= date('Y-m-d');
		$date2= date('d-M-Y');
		$facility=$this -> session -> userdata('news');
		$current_year = date('Y');
		$current_month = date('F');
		$current_monthdigit = date('m');
		$id=$this -> session -> userdata('identity');
		$report_name='Decommission Report for ' .$date2;
		$title='Expired Commodities as of ' .$date2;
		$expired=Facility_Stock::getexp($date,$facility);

$html_data='<style>table.data-table {border: 1px solid #DDD;margin: 10px auto;border-spacing: 0px;}
table.data-table th {border: none;color: #036;text-align: center;background-color: #F5F5F5;border: 1px solid #DDD;border-top: none;max-width: 450px;}
table.data-table td, table th {padding: 4px;}
table.data-table td {border: none;border-left: 1px solid #DDD;border-right: 1px solid #DDD;height: 30px;margin: 0px;border-bottom: 1px solid #DDD;}
.col5{background:#C9C299;}</style>';

$html_data1 = '';

$html_data1 .='<table class="data-table"><thead>
	<tr>
		<th>KEMSA Code</th>
		<th>Description</th>
		<th>Batch No Affected</th>
		<th>Manufacturer</th>
		<th>Expiry Date</th>
		<th>Unit size</th>
		<th>Stock Expired(Unit Size)</th>
	
	</tr></thead><tbody>';
	
				foreach ($expired as $drug ) {
					foreach($drug->Code as $d){ 
								$name=$d->Drug_Name;
								$code=$d->Kemsa_Code;
					            $unitS=$d->Unit_Size; 
								$unitC=$d->Unit_Cost;
								$calc=$drug->balance;
								$thedate=$drug->expiry_date;
								$formatme = new DateTime($thedate);
								 $myvalue= $formatme->format('d M Y');
		
	$html_data1 .='		<tr>
							
							<td>'.$code.'</td>
							<td>'.$name.'</td>
							<td>'.$drug->batch_no.'</td>
							<td>'.$drug->manufacture.'</td>
							<td>'.$myvalue.'</td>
							<td>'.$unitS.'</td>
							<td>'.$drug->quantity.'</td>					
						</tr>';
					}
					}			
		$html_data1 .='</tbody></table>';
$html_data .=$html_data1;
$this->generate_decommission_report_pdf($report_name,$title,$html_data);
}
public function generate_decommission_report_pdf($report_name,$title,$html_data) {
	$current_year = date('Y');
		$current_month = date('F');
		$facility_code=$this -> session -> userdata('news');
		$facility_name_array=Facilities::get_facility_name($facility_code)->toArray();
		$facility_name=$facility_name_array['facility_name'];
		$districtName = $this->session->userdata('full_name');
					
	/********************************************setting the report title*********************/
			
		$html_title="<div ALIGN=CENTER><img src='".base_url()."Images/coat_of_arms.png' height='70' width='70'style='vertical-align: top;' > </img></div>
      <div style='text-align:center; font-family: arial,helvetica,clean,sans-serif; font-size: 14px; display: block; font-weight: bold;'>".$report_name."</div>
       <div style='text-align:center; font-family: arial,helvetica,clean,sans-serif; font-size: 14px; display: block; font-weight: bold; '>
       Ministry of Public Health and Sanitation/Ministry of Medical Services</div>
        <div style='text-align:center; font-family: arial,helvetica,clean,sans-serif;display: block; font-weight: bold;display: block; font-size: 13px;'>Health Commodities Management Platform</div>
       <div style='text-align:center; font-family: arial,helvetica,clean,sans-serif; font-size: 12px; display: block; font-weight: bold;'>".$districtName." District</h2>
       <div style='text-align:center; font-family: arial,helvetica,clean,sans-serif; font-size: 12px; display: block; font-weight: bold;'>".$current_month." ".$current_year."</h2>
       <hr />   ";
		

		$css_path=base_url().'CSS/style.css';
		
		/**********************************initializing the report **********************/
            $this->load->library('mpdf');
            $this->mpdf = new mPDF('', 'A4-L', 0, '', 15, 15, 16, 16, 9, 9, '');
            $this->mpdf->SetTitle($title);
            $this->mpdf->WriteHTML($html_title);
            $this->mpdf->simpleTables = true;
            $this->mpdf->WriteHTML('<br/>');
            $this->mpdf->WriteHTML($html_data);
			$report_name = $report_name.".pdf";
            $this->mpdf->Output($report_name,'D');
}
public function Decommission() {
	//Change status of commodities to decommissioned
	$date= date('Y-m-d');
	$facility=$this -> session -> userdata('news');
		$q = Doctrine_Query::create()
			->update('Facility_Stock')
				->set('status', '?', 2)
					->where("facility_code='$facility' and expiry_date<='$date'");

			$q->execute();
			
			//Create PDF of Expired Drugs that are to be decommisioned.
			$decom=Facility_Stock::getexp($date,$facility);
			
			//create the report title
		$html_title="<div ALIGN=CENTER><img src='".base_url()."Images/coat_of_arms.png' height='70' width='70'style='vertical-align: top;' > </img></div>
      <div style='text-align:center; font-size: 14px;display: block;font-weight: bold;'>Expiries</div>
       <div style='text-align:center; font-family: arial,helvetica,clean,sans-serif;display: block; font-weight: bold; font-size: 14px;'>
       Ministry of Public Health and Sanitation/Ministry of Medical Services</div>
        <div style='text-align:center; font-family: arial,helvetica,clean,sans-serif;display: block; font-weight: bold;display: block; font-size: 13px;'>Health Commodities Management Platform</div><hr />   ";
		
		/*****************************setting up the report*******************************************/
		$html_body ='';
		
		

$html_body.='<style>table.data-table {border: 1px solid #DDD;margin: 10px auto;border-spacing: 0px;}
table.data-table th {border: none;color: #036;text-align: center;background-color: #F5F5F5;border: 1px solid #DDD;border-top: none;max-width: 450px;}
table.data-table td, table th {padding: 4px;}
table.data-table td {border: none;border-left: 1px solid #DDD;border-right: 1px solid #DDD;height: 30px;margin: 0px;border-bottom: 1px solid #DDD;}
.col5{background:#C9C299;}</style>

<table class="data-table"><thead>

			<tr > <th ><strong>KEMSA Code</strong></th>
			<th><strong>Description</strong></th>
			<th><strong>Batch No Affected</strong></th>
			<th><strong>Manufacturer</strong></th>
			<th><strong>Expiry Date</strong></th>
			<th><strong>Unit Size</strong></th>
			<th><strong>Stock Expired(Unit Size)</strong></th>
			
			

</tr> </thead><tbody>';

/*******************************begin adding data to the report*****************************************/

	foreach($decom as $drug){
			
				foreach($drug->Code as $d){
								$name=$d->Drug_Name;
								$code=$d->Kemsa_Code;
					            $unitS=$d->Unit_Size; 
								$unitC=$d->Unit_Cost;
								$calc=$drug->balance;
								$thedate=$drug->expiry_date;
								$formatme = new DateTime($thedate);
								 $myvalue= $formatme->format('d M Y');					    
							    }
							
		 $html_body .='<tr><td>'.$code.'</td>
							<td>'.$name.'</td>
							<td>'.$drug->batch_no.'</td>
							<td>'.$drug->manufacture.'</td>
							<td>'.$myvalue.'</td>
							<td >'.$unitS.'</td>
							<td >'.$drug->quantity.'</td>
							
							
							</tr>';

/***********************************************************************************************/
					
		  }
		$html_body .='</tbody></table>'; 
		
		
		
		//now ganerate an expiry pdf from the generated report
			$this->load->library('mpdf');
			$this->load->helper('file');
            $this->mpdf = new mPDF('', 'A4-L', 0, '', 15, 15, 16, 16, 9, 9, '');
            $this->mpdf->WriteHTML($html_title);
            $this->mpdf->defaultheaderline = 1;  
            $this->mpdf->simpleTables = true;
            $this->mpdf->WriteHTML($html_body);
            $this->mpdf->AddPage();
			$this->mpdf->WriteHTML($html_body);
			$report_name='Facility_Expired_Commodities'.$facility;
			
			
			
			if( !write_file( './pdf/'.$report_name.'.pdf',$this->mpdf->Output('$report_name','S'))
			)
			{
    	$msg="An error occured";
  $this->district_orders($msg);
             }
                  else{
                  	$config = Array(
  'protocol' => 'smtp',
  'smtp_host' => 'ssl://smtp.googlemail.com',
  'smtp_port' => 465,
  'smtp_user' => 'ashminneh.mugo@gmail.com', // change it to yours
  'smtp_pass' => 'ashwoodnfire', // change it to yours
  'mailtype' => 'html',
  'charset' => 'iso-8859-1',
  'wordwrap' => TRUE
);
 
 //pull required emails ready to attach and send
 $pull_emails=User::getemails($facility);
 //echo $pull_emails;
	foreach ($pull_emails as $emails) {
		$address= $emails['email'];
		
		 $this->load->library('email', $config);
  $this->email->set_newline("\r\n");
  $this->email->from('hcmpkenya@gmail.com'); // change it to yours
  $this->email->to("$address"); 
  $this->email->bcc('ashminneh.mugo@gmail.com');
  $this->email->subject('Order Report For '.$facility);
 
  $this->email->attach('./pdf/'.$report_name.'.pdf'); 
  $this->email->message($html_title.$html_body);
 
  if($this->email->send())
 {
 delete_files('./pdf/');
 }
 else
{
 show_error($this->email->print_debugger());
}
 
		
	}
 
  
	redirect("/");				
  }
			
			}
}

