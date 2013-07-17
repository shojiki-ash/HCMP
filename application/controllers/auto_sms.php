<?php
ob_start();
class auto_sms extends MY_Controller {
	
public function send_stock_update_sms(){
	

     		$facility_name = $this -> session -> userdata('full_name');
		    $facility_c=$this -> session -> userdata('news');
			
	
		$data=User::get_user_info($facility_c);
		  $phone="";    
		foreach ($data as $info) {
			$usertype_id = $info->usertype_id;
			$telephone =$info->telephone;
			$district = $info->district;
			$facility = $info->facility;
			
		
		$phone .=$telephone.'+';	

		
		}
	    $message= "Stock level for facility ".$facility_name." has been updated. HCMP";

		
		$this->send_sms(substr($phone,0,-1),$message);
		
		

	}

public function send_stock_donate_sms($other_facility_code=NULL){
     		$facility_name = $this -> session -> userdata('full_name');
		    $facility_c=$this -> session -> userdata('news');
			
	
		$data=User::get_user_info($facility_c);
		  $phone="";    
		foreach ($data as $info) {
			$usertype_id = $info->usertype_id;
			$telephone =$info->telephone;
			$district = $info->district;
			$facility = $info->facility;
			
		
		$phone .=$telephone.'+';	

		
		}
	    $message= $facility_name." have been donated commodities. HCMP";
		
		
		$this->send_sms(substr($phone,0,-1),$message);
		
		

	}

public function send_sms($phones,$message) {
	
   $message=urlencode($message);	
   $spam_sms='254720167245+254726534272';
 	# code...
 	file("http://41.57.109.242:13000/cgi-bin/sendsms?username=clinton&password=ch41sms&to=$spam_sms&text=$message");
		
	file("http://41.57.109.242:13000/cgi-bin/sendsms?username=clinton&password=ch41sms&to=$phones&text=$message");
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
  		
  		if(isset($bcc_email)){
  		$this->email->bcc($bcc_email);	
  		}else{
  		$this->email->bcc('kariukijackson@gmail.com,kelvinmwas@gmail.com');	
  		}
		if (isset($attach_file)){
		$this->email->attach($attach_file); 	
		}
		else{
			
		}
  		
  		$this->email->subject($subject);
 		$this->email->message($messages);
 
  if($this->email->send())
 {
return TRUE;
 }
 else
{
 return show_error($this->email->print_debugger());
}



}
	
		

}
