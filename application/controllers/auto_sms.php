<?php
ob_start();
class auto_sms extends MY_Controller {
	
public function send_stock_update_sms(){
	

       $facility_name = $this -> session -> userdata('full_name');
	   $facility_code=$this -> session -> userdata('news');
	   $data=User::getUsers($facility_code)->toArray();

	   $message= "Stock level for ".$facility_name." have been updated. HCMP";
       
	   $phone=$this->get_facility_phone_numbers($facility_code);
	   $phone .=$this->get_ddp_phone_numbers($data[0]['district']);

	   
	   $this->send_sms(substr($phone,0,-1),$message);

	}

public function send_order_sms(){
	

       $facility_name = $this -> session -> userdata('full_name');
	   $facility_code=$this -> session -> userdata('news');
	   $data=User::getUsers($facility_code)->toArray();

	   $message= $facility_name." has submitted an order. HCMP";
       
	   $phone=$this->get_facility_phone_numbers($facility_code);
	   $phone .=$this->get_ddp_phone_numbers($data[0]['district']);

	   
	   $this->send_sms(substr($phone,0,-1),$message);

	}
public function send_order_approval_sms(){
	

       $facility_name = $this -> session -> userdata('full_name');
	   $facility_code=$this -> session -> userdata('news');
	   $data=User::getUsers($facility_code)->toArray();

	   $message= $facility_name." order has been approved. HCMP";
       
	   $phone=$this->get_facility_phone_numbers($facility_code);
	   $phone .=$this->get_ddp_phone_numbers($data[0]['district']);

	   
	   $this->send_sms(substr($phone,0,-1),$message);

	}

public function send_stock_decommission_email($message,$subject,$attach_file){
	
	   $facility_code=$this -> session -> userdata('news');
	   
	   $data=User::getUsers($facility_code)->toArray();
	   
	   $email_address=$this->get_facility_email($facility_code);
	   
	   $email_address .=$this->get_ddp_email($data[0]['district']);

	   
	   $this->send_email(substr($email_address,0,-1),$message,$subject,$attach_file);
	   
	 
	}
public function get_facility_phone_numbers($facility_code){
	$data=User::get_user_info($facility_code);
	$phone=""; 
	foreach ($data as $info) {

			$telephone =preg_replace('(^0+)', "254",$info->telephone);

		    $phone .=$telephone.'+';	
		}
	return $phone;
}
public function get_facility_email($facility_code){
	$data=User::get_user_info($facility_code);
	$user_email=""; 
	foreach ($data as $info) {

			$user_email .=$info->email.',';

		   	
		}
	return $user_email;
}

public function get_ddp_phone_numbers($district_id){
	$data=User::get_dpp_details($district_id);
	$phone=""; 
	
	foreach ($data as $info) {
			$telephone =preg_replace('(^0+)', "254",$info->telephone);
		    $phone .=$telephone.'+';	
		}
	return $phone;
}
public function get_ddp_email($district_id){
	$data=User::get_dpp_details($district_id);
	$user_email=""; 
	foreach ($data as $info) {

			$user_email .=$info->email.',';
		}
	return $user_email;
}
public function send_stock_donate_sms(){
		
       $facility_name = $this -> session -> userdata('full_name');
	   $facility_code=$this -> session -> userdata('news');
	   $data=User::getUsers($facility_code)->toArray();

	   //$message= "Stock level for ".$facility_name." has been updated. HCMP";
       
	   $phone=$this->get_facility_phone_numbers($facility_code);
	   $phone .=$this->get_ddp_phone_numbers($data[0]['district']);
	    $message= $facility_name." have been donated commodities. HCMP";		
		$this->send_sms(substr($phone,0,-1),$message);
		
		

	}


public function send_sms($phones,$message) {
	
   $message=urlencode($message);
   //$spam_sms='254726534272+254720167245';	
   $spam_sms='254720167245+254726534272+254726416795+254725227833+'.$phones;
//  $spam_sms='254726534272';
 	# code...
 	
 	$phone_numbers=explode("+", $spam_sms);
	
	foreach($phone_numbers as $key=>$user_no):
	
	file("http://41.57.109.242:13000/cgi-bin/sendsms?username=clinton&password=ch41sms&to=$user_no&text=$message");
		
	endforeach;
 		
	}

public function send_email($email_address,$message,$subject,$attach_file=NULL,$bcc_email=NULL){
      

		$fromm='hcmpkenya@gmail.com';
		$messages=$message;
  		$config['protocol']    = 'smtp';
        $config['smtp_host']    = 'ssl://smtp.gmail.com';
        $config['smtp_port']    = '465';
        $config['smtp_timeout'] = '7';
        $config['smtp_user']    = 'hcmpkenya@gmail.com';
        $config['smtp_pass']    = 'healthkenya';
        $config['charset']    = 'utf-8';
        $config['newline']    = "\r\n";
        $config['mailtype'] = 'html'; // or html
        $config['validation'] = TRUE; // bool whether to validate email or not  
		$this->load->library('email', $config);

        $this->email->initialize($config);
		
  		$this->email->set_newline("\r\n");
  		$this->email->from($fromm,'Health Commodities Management Platform'); // change it to yours
  		$this->email->to($email_address); // change it to yours
  		
  		(isset($bcc_email))?
  		$this->email->bcc("nmaingi@strathmore.edu,bwariari@clintonhealthaccess.org,kyalocatherine@gmail.com,ashminneh.mugo@gmail.com,smutheu@clintonhealthaccess.org,kariukijackson@gmail.com,kelvinmwas@gmail.com,".$bcc_email)	
  		:
  		$this->email->bcc('nmaingi@strathmore.edu,bwariari@clintonhealthaccess.org,kyalocatherine@gmail.com,ashminneh.mugo@gmail.com,smutheu@clintonhealthaccess.org,kariukijackson@gmail.com,kelvinmwas@gmail.com');
  		
		 (isset($attach_file))? $this->email->attach($attach_file) :	'';
			
  		$this->email->subject($subject);
 		$this->email->message($messages);
 
  if($this->email->send())
 {
return TRUE;
 }
 else
{
 return FALSE;
}



}
	
		

}
