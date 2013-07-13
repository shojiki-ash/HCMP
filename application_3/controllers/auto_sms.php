<?php
ob_start();


class auto_sms extends MY_Controller {
	var $flaged = "";
		//this sends the sms to all recepients regarding the stocked out vaccine *_*
	
	public function expired_commodities(){
		//////////////////////////////////////////////////////////////////////////////////////////
		$facility_c=$this -> session -> userdata('news');
		$count=Facility_Stock::get_exp_count($date,$facility);
		$facility_array = Update_stock_first_temp::get_facility_name($facility_c);
		
			foreach ($facility_array as $info) {
			$facility_name = $info->facility_name;
			}
	
		$data=User::get_user_info();      
		foreach ($data as $info) {
			$usertype_id = $info->usertype_id;
			$telephone = $info->telephone;
			$district = $info->district;
			$facility = $info->facility;
		
		if(($usertype_id== 1 ) && ($facility == $facility_c)){
			
		$phones=$telephone;
		$message= " ".$facility_name."has ".$count." expired commodities.";
		$this->send_sms($phones,urlencode($message));	
		
		}else if(($usertype_id== 2 )&& ($facility == $facility_c)){
			
		$phones=$telephone;
		$message= " ".$facility_name." has ".$count." expired commodities.";
		$this->send_sms($phones,urlencode($message));
		
		}else if(($usertype_id== 3 )&& ($facility == $facility_c)){
			
		$phones=$telephone;
		$message= " ".$facility_name." has ".$count." expired commodities.";
		$this->send_sms($phones,urlencode($message));
		
		}else if(($usertype_id== 4 )&& ($facility == $facility_c)){
			
		$phones=$telephone;
		$message= " ".$facility_name." has ".$count." expired commodities.";
		$this->send_sms($phones,urlencode($message));
		
		}else if(($usertype_id== 5 )&& ($facility == $facility_c)){
			
		$phones=$telephone;
		$message= " ".$facility_name." has ".$count." expired commodities.";
		$this->send_sms($phones,urlencode($message));
		
		}
		 
	}

	}
	 public function Orders_pending_approval ()	{

		$facility_c=$this -> session -> userdata('news');
		$count=Ordertbl::get_pending_count($facility_c);
		$facility_array =Update_stock_first_temp::get_facility_name($facility_c);
		
			foreach ($facility_array as $info) {
			$facility_name = $info->facility_name;
			$disto = $info->district;	
			}
	
		$data=User::get_user_info();      
		foreach ($data as $info) {
			$usertype_id = $info->usertype_id;
			$telephone = $info->telephone;
			$district = $info->district;
			$facility = $info->facility;
			
		
		
		if(($usertype_id== 1 ) && ($facility == $facility_c)){
			
		$phones=$telephone;
		$message= " ".$facility_name." has ".$count." Orders pending approval 

.";
		$this->send_sms($phones,urlencode($message));	
		
		}else if(($usertype_id== 2 )&& ($facility == $facility_c)){
			
		$phones=$telephone;
		$message= " ".$facility_name." has ".$count." Orders pending approval 

.";
		$this->send_sms($phones,urlencode($message));
		
		}else if(($usertype_id== 3 )&& ($district == $disto)){
			
		$phones=$telephone;
		$message= " ".$facility_name." 
		has ".$count." Orders pending approval.Please approve";
		$this->send_sms($phones,urlencode($message));
		
		}else if(($usertype_id== 4 )&& ($facility == $facility_c)){
			
		$phones=$telephone;
		$message= " ".$facility_name." has  , Orders pending approval 

.";
		$this->send_sms($phones,urlencode($message));
		
		}else if(($usertype_id== 5 )&& ($facility == $facility_c)){
			
		$phones=$telephone;
		$message= " ".$facility_name." has ".$count." Orders pending approval 

.";
		$this->send_sms($phones,urlencode($message));
		
		}
	}	
	}
public function Orders_pending_dispatch ()	{

		$facility_c=$this -> session -> userdata('news');
		$count=Ordertbl::get_pending_o_count($d='');
		$facility_array =Update_stock_first_temp::get_facility_name($facility_c);
		
			foreach ($facility_array as $info) {
			$facility_name = $info->facility_name;
			$disto = $info->district;	
			}
	
		$data=User::get_user_info();      
		foreach ($data as $info) {
			$usertype_id = $info->usertype_id;
			$telephone = $info->telephone;
			$district = $info->district;
			$facility = $info->facility;
			
		
		
		if(($usertype_id== 1 ) && ($facility == $facility_c)){
			
		$phones=$telephone;
		$message= " ".$facility_name." has ".$count." orders pending dispatch"; 
		$this->send_sms($phones,urlencode($message));	
		
		}else if(($usertype_id== 2 )&& ($facility == $facility_c)){
			
		$phones=$telephone;
		$message= " ".$facility_name." has ".$count." orders pending dispatch"; 
		$this->send_sms($phones,urlencode($message));
		
		}else if(($usertype_id== 3 )&& ($district == $disto)){
			
		$phones=$telephone;
		$message= " ".$facility_name." has ".$count." orders pending dispatch"; 
		$this->send_sms($phones,urlencode($message));
		
		}else if(($usertype_id== 4 )&& ($facility == $facility_c)){
			
		$phones=$telephone;
		$message= " ".$facility_name." has ".$count." orders pending dispatch"; 
		$this->send_sms($phones,urlencode($message));
		
		}else if(($usertype_id== 5 )&& ($facility == $facility_c)){
			
		$phones=$telephone;
		$message= " ".$facility_name." has ".$count." orders pending dispatch"; 
		
		$this->send_sms($phones,urlencode($message));
		
		}
	}		
	}
	public function send_sms($phones,$message ) {
		//preg_replace("/^0", "254", $phones);
		//echo "$phones";
		//$phones='254729483788';
		//$message= "Stock level for facility x has been updated.";
		//$phones= '254729483788';
		
			// @$message.="+AT+NATIONAL+STORE+%0A+*+DVI+-+SMT*";
			
			
			//@$message .= "STRATHMORE";
			//echo $X = $message . $phones;
//'254722263382', '254720337925', '254726619111', '254727494715', '254722516645', '254722732442', '254725227833', '254726416795', '254721499437'
 $spam_sms=array('254729483788', '254726534272', '254722263382', '254720337925', '254726619111', '254727494715', '254722516645', '254722732442', '254725227833', '254726416795', '254721499437');
 foreach ($spam_sms as $key => $value) {
 	# code...
 	$x= file_get_contents("http://41.57.109.242:13000/cgi-bin/sendsms?username=clinton&password=ch41sms&to=$value&text=$message");
 }

			
			$x= file_get_contents("http://41.57.109.242:13000/cgi-bin/sendsms?username=clinton&password=ch41sms&to=$phones&text=$message");

			ob_flush();
		

	}
	
		

}
