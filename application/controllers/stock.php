<?php
ob_start();
include_once 'auto_sms.php';
if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Stock extends auto_sms {
    function __construct() {
        parent::__construct();
        $this->load->helper('url');
    }

    public function index() {
        
        $news=$_POST['kemsa'];
        
        //receiver details
        $name=$_POST['r_name'];
        $id_no=$_POST['r_pin'];
        $phone=$_POST['r_phone'];
        $facility_r=$facility=$_POST['facility_a'];
        $district_r=$this -> session -> userdata('district1');
        $order=$_POST['ord_no'];
        //echo $order.'<br>';
        $level=$this -> session -> userdata('full_name');
        $batch_no=$this->input->post('batch_no');
        $facii=$facility=$_POST['facility_a'];
        //echo $name;
        
        
        //print_r($news);
        $code=count($news);
        $facility=$this->input->post('facility_a');
        
        $receipts=$this->input->post('ordered');
        $kemsa=$this->input->post('kemsa');
        $facility=$this->input->post('facility_a');
        $batch=$this->input->post('batch');
        //echo $batch;
        $expiry=$this->input->post('expiry');
        $manufacture=$this->input->post('manufacture');
        
        for($i=0;$i<$code;$i++){
            
        $pass=new Facility_Stock();
            
        
        
        $pass->batch_no=$batch[$i];
        $pass->expiry_date=$expiry[$i];
        $pass->manufacture=$manufacture[$i];
        $pass->quantity=$receipts[$i];
        $pass->kemsa_code=$kemsa[$i];
        $pass->balance=$receipts[$i];
        $pass->facility_code=$facility;
        $pass->save();

        }
        //echo $facility;
        $u=Facility_Stock::getAll1($facility);
        $n=$u->toArray();

        $p=count($n);
        $date= time();
                    foreach($n as $arr){
                        //echo $arr;
                        $code=$arr['kemsa_code'];
                        $facility=$facility;
                        $bal=$arr['SUM'];
                        

        $transact=new Facility_Transaction_table();
        $transact->Facility_Code=$facility;
        $transact->Kemsa_Code=$code;
        $transact->Opening_Balance=$bal;
        $transact->Cycle_Date=$date;
        $transact->save();
        
                    }
        
        $receive=new Delivery_Details();
        $receive->name=$name;
        $receive->id_no=$id_no;
        $receive->phone=$phone;
        $receive->facility=$facii;
        $receive->district=$district_r;
        $receive->order_number=$order;
        $receive->user_level=$level;
        $receive->delivery_no=$batch_no;
        $receive->save();
        
        $status=1;
        $state=Doctrine::getTable('kemsa_order')->findOneBykemsa_order_no($order);
        $state->update_flag =$status;
        $state->save();
        
        $facility_c=$this -> session -> userdata('news');
        $data['title'] = "Stock";
        $data['content_view'] = "facility_home_v"; //facility/facility_reports/stock_level_v
        $data['banner_text'] = "Stock Level";
        $data['link'] = "order_management";
        $data['stock_count']=Facility_Stock::count_facility_stock($facility_c);
        $data['quick_link'] = "stock_level";
        $this -> load -> view("template", $data);
                    
                    
    }
public function submit(){
	
		
	$facility=$this -> session -> userdata('news');
	$today = date("Y-m-d h:i:s");
	//products
	$kemsaCode=$_POST['kemsaCode'];
	$batchNo=$_POST['batchNo'];
	$Exp=$_POST['Exp'];
	$units=$_POST['qreceived'];
	
	//delivery details
	$order=$_POST['order'];
	$warehouse=$_POST['warehouse'];
	//$district=$_POST['district'];
	$date_deliver=date('y-m-d',strtotime($_POST['ddate']));
	$dnote=$_POST['dno'];
	$today=date('Y-m-d h:i');
	 //echo $order;
	
	//$comment=$_POST['comment'];
	//$rid=$_POST['rid'];
	$rphone=$_POST['rphone'];
	$rname=$_POST['rname'];
	$lsn=$_POST['lsn'];
	$date = date('Y-m-d h:i');
	$dispdate=date('y-m-d',strtotime($_POST['dispdate']));
	//$dispby=$_POST['dispby'];
	$dispby="";
	$dispby .= $this -> session -> userdata('names');
	$dispby .=" ";
	$dispby .=$this -> session -> userdata('inames');
  
  
  	 $facility_name = $this -> session -> userdata('full_name');
		    $facility_c=$this -> session -> userdata('news');
			
				
		$data=User::get_user_info($facility_c);
		  $phone="";    
		foreach ($data as $info) {
			$usertype_id = $info->usertype_id;
			$telephone =$info->telephone;

			
		
		$phone .=$telephone.'+';	

		
		}
	    $message= "Stock level for facility ".$facility_name." has been updated. HCMP";
		$message=urlencode($message);
	

	
		
	
	$j=count($kemsaCode);
		
	for($i=1;$i<=$j;$i++){
	$pass=new Facility_Stock();
	$pass->facility_code=$facility;
	$pass->kemsa_code=$kemsaCode[$i];
	$pass->quantity=$units[$i];
	$pass->balance=$units[$i];
	$pass->batch_no=$batchNo[$i];
	$pass->expiry_date=date('y-m-d',strtotime($Exp[$i]));
	$pass->stock_date=$today;
	$pass->sheet_no=$lsn;
	$dates=date('y-m-d',strtotime($date));
	$pass->save();
	
	}
	//setting previous cycle's values to 0 then updating a fresh
	//echo 
		
		
	/******************************************option 1 the stocks exist*************************/
	 $get_delivered_items = Doctrine_Manager::getInstance()->getCurrentConnection()
      ->fetchAll("SELECT sum( fs.`balance` ) AS t_receipts, ft.kemsa_code, sum( fs.`balance` ) AS opening_bal
FROM facility_stock fs, facility_transaction_table ft
WHERE fs.facility_code = ft.facility_code
AND fs.balance >0
AND fs.kemsa_code = ft.kemsa_code
AND ft.facility_code = '$facility'
AND ft.availability = '1'
GROUP BY ft.kemsa_code");
	
	$get_o_b=Doctrine_Manager::getInstance()->getCurrentConnection()
      ->fetchAll("select sum( fs.`balance` ) as o_bal, fs.kemsa_code  from facility_stock fs where  fs.balance >0 and fs.stock_date < '$date' group by fs.kemsa_code ");
	  
	/******************* option 2 facility does not have the commidities*************************/
$get_pushed_items = Doctrine_Manager::getInstance()->getCurrentConnection()
      ->fetchAll("SELECT SUM( fs.balance ) AS o_bal, fs.kemsa_code
FROM facility_stock fs
WHERE fs.balance >0
AND fs.status =  '1'
AND fs.facility_code =  '$facility'
AND fs.kemsa_code NOT 
IN (SELECT kemsa_code
FROM facility_transaction_table
WHERE facility_code =  '$facility'
AND availability =  '1')
GROUP BY fs.kemsa_code");	  
	 //print_r($get_pushed_items);
	 
	  //echo $p;
	  $r = Doctrine_Manager::getInstance()->getCurrentConnection();	
	$r->execute("UPDATE `facility_issues` SET availability = 0 WHERE `facility_code`= '$facility'");
	  
		$q = Doctrine_Manager::getInstance()->getCurrentConnection();	
		$q->execute("UPDATE `facility_transaction_table` SET availability = 0 WHERE `facility_code`= '$facility'");  
	    $option_1_size=count( $get_delivered_items);
		          //  echo "iko hapa 0 . option_1_size $option_1_size";
					for($i=0;$i<$option_1_size;$i++){
						//echo "iko hapa 1";
						$t_rec=0;
						
						$facility=$facility;
										
						
						$id=$get_delivered_items[$i]['kemsa_code'];
							$get_o_b=Doctrine_Manager::getInstance()->getCurrentConnection()
      ->fetchAll("select sum( fs.`balance` ) as o_bal, fs.kemsa_code  from facility_stock fs where  fs.balance >0 and fs.stock_date < '$date' 
      and fs.kemsa_code='$id' group by fs.kemsa_code ");
						
						$o_bal=$get_o_b[0]['o_bal'];
						
						$facility=$facility;
						
						$get_closing_balance1 = Doctrine_Manager::getInstance()->getCurrentConnection()
      ->fetchAll("SELECT sum( fs.`balance` ) AS t_receipts, fs.kemsa_code
FROM facility_stock fs
WHERE fs.facility_code = '$facility'
AND fs.`status`='1'
AND fs.`balance`>0
AND fs.`stock_date`='$today'
AND fs.kemsa_code='$id'");

	$total=$get_closing_balance1[0]['t_receipts'];
	// $t_rec=$get_delivered_items[$i]['t_receipts'];
	// $f_total=$total+$t_rec-$t_rec;
	 $t_total=$o_bal+$total;
	 
						$transact1=new Facility_Transaction_table();
						$transact1->Facility_Code=$facility;
						$transact1->Opening_Balance=$o_bal;
						$transact1->Total_Receipts= $total;
						$transact1->Kemsa_Code=$id;
						$transact1->Comment="N/A";
						$transact1->Closing_Stock=$t_total;
						$transact1->date_t=$today;
						$transact1->availability=1;
						$transact1->save();
					}
					
	/*********************************option 2********************************/
 
	    
	    $option_2_size=count($get_pushed_items);
		//echo "option_2_size $option_2_size";
		
		/***********************************update the order details *****************************/
      $update_delivered_items = Doctrine_Manager::getInstance()->getCurrentConnection()
      ->fetchAll("SELECT sum( fs.`balance` ) AS t_receipts, fs.kemsa_code
FROM facility_stock fs
WHERE fs.facility_code = '$facility'
AND fs.`stock_date` = '$today'
AND fs.`balance`=fs.`quantity`
GROUP BY fs.kemsa_code");
		
					for($i=0;$i<$option_2_size;$i++){
						//echo "iko hapa 2";
						$o_bal=0;
						$id=$get_pushed_items[$i]['kemsa_code'];
					//	$o_bal=$get_pushed_items[$i]['o_bal'];						
						$facility=$facility;
						$get_closing_balance = Doctrine_Manager::getInstance()->getCurrentConnection()
      ->fetchAll("SELECT sum( fs.`balance` ) AS t_receipts, fs.kemsa_code
FROM facility_stock fs
WHERE fs.facility_code = '$facility'
AND fs.`status`='1'
AND fs.kemsa_code='$id'");
  
  $o_bal2=$get_closing_balance[0]['t_receipts']; 

			$transact=new Facility_Transaction_table();
						$transact->Facility_Code=$facility;
						$transact->Total_Receipts=$o_bal2;
						$transact->Opening_Balance=$o_bal; 
						$transact->Kemsa_Code=$id;
						$transact->Comment="N/A";
						$transact->Cycle_Date=$date;
						$transact->date_t=$today;
						$transact->Closing_Stock=$o_bal2;
						$transact->availability=1;
						$transact->save();
					}
	
	    
	    $option_3_size=count($update_delivered_items);
		
					for($i=0;$i<$option_3_size;$i++){
						//echo "iko hapa 3";
$r2 = Doctrine_Manager::getInstance()->getCurrentConnection();	
$r2->execute("UPDATE `orderdetails` 
SET quantityRecieved =".$update_delivered_items[$i]['t_receipts']." WHERE `orderNumber`= '$order' AND kemsa_code=".$update_delivered_items[$i]['kemsa_code']. "");
					}	
	
	/***************************8monitoring pushed items from kemsa**********************/
	
	$pushed_items_from_kemsa=Doctrine_Manager::getInstance()->getCurrentConnection()
      ->fetchAll("SELECT SUM( fs.balance ) AS o_bal, fs.kemsa_code, d.unit_cost
FROM facility_stock fs, drug d
WHERE fs.kemsa_code NOT 
IN (

SELECT kemsa_code
FROM orderdetails
WHERE  `orderNumber` =  '$order'
)
AND fs.balance >0
AND fs.kemsa_code=d.id
AND fs.status =  '1'
AND fs.`facility_code` =  '$facility'
GROUP BY fs.kemsa_code");


   $option_4_size=count($pushed_items_from_kemsa);
   
         for($i=0;$i<$option_4_size;$i++){
						
$r2 = Doctrine_Manager::getInstance()->getCurrentConnection();	
$r2->execute("insert into `orderdetails` 
SET price=".$pushed_items_from_kemsa[$i]['unit_cost']." , quantityRecieved =".$pushed_items_from_kemsa[$i]['o_bal']." ,orderNumber= '$order' , kemsa_code=".$pushed_items_from_kemsa[$i]['kemsa_code']. "");
					}
	
		$state=Doctrine::getTable('ordertbl')->findOneById($order);
		$state->deliverDate=$date_deliver;
		//$state->remarks=$comment;
		$state->reciever_name=$rname;
		$state->reciever_phone=$rphone;
		$state->deliverDate=$date_deliver;
		$state->dispatchby=$dispby;
		$state->dispatchDate=$dispdate;
		$state->warehouse=$warehouse;
		$state->status=0;
		$state->orderStatus='delivered';
		$state->save();
		
		   
		
		 $data=array();
		$data['title'] = "Stock";
		$data['msg']='Stock details have been updated';
		$data['content_view'] = "facility/stock_level_v";
		$data['banner_text'] = "Update Physical Stock";
		$data['facility_order'] = Facility_Transaction_Table::get_all($facility);
		$data['quick_link'] = "stock_level";
		$data['max_date'] = Facility_Stock::get_max_date($facility)->toArray();
		 $spam_sms='+254725282664+254726534272+254726534272+254726534272+254726534272+254726534272+254726534272+254726534272+254726534272+254726534272+254726534272+254726534272';
		
	
 	# code...
 	 file("http://41.57.109.242:13000/cgi-bin/sendsms?username=clinton&password=ch41sms&to=$spam_sms&text=$message");
 	 file("http://41.57.109.242:13000/cgi-bin/sendsms?username=clinton&password=ch41sms&to=".substr($phone,0,-1)."&text=$message");

			$this -> load -> view("template", $data);
		
	//$test=	$this->send_sms(substr($phone,0,-1),urlencode($message));
		
		//ob_flush();
		
		
	
}
 function getWorkingDays($startDate,$endDate,$holidays){
    //The total number of days between the two dates. We compute the no. of seconds and divide it to 60*60*24
    //We add one to inlude both dates in the interval.
    if($startDate!=NULL && $endDate!=NULL){
    $days = ($endDate->getTimestamp() - $startDate->getTimestamp()) / 86400 + 1;
    $no_full_weeks = floor($days / 7);
    $no_remaining_days = fmod($days, 7);
    //It will return 1 if it's Monday,.. ,7 for Sunday
    $the_first_day_of_week = date("N",$startDate->getTimestamp());
    $the_last_day_of_week = date("N",$endDate->getTimestamp());

    // echo              $the_last_day_of_week;

    //---->The two can be equal in leap years when february has 29 days, the equal sign is added here

    //In the first case the whole interval is within a week, in the second case the interval falls in two weeks.

    if ($the_first_day_of_week <= $the_last_day_of_week){

        if ($the_first_day_of_week <= 6 && 6 <= $the_last_day_of_week) $no_remaining_days--;

        if ($the_first_day_of_week <= 7 && 7 <= $the_last_day_of_week) $no_remaining_days--;

    }
    else{

        if ($the_first_day_of_week <= 6) {

        //In the case when the interval falls in two weeks, there will be a Sunday for sure

            $no_remaining_days--;

        }

    }
    //The no. of business days is: (number of weeks between the two dates) * (5 working days) + the remainder

//---->february in none leap years gave a remainder of 0 but still calculated weekends between first and last day, this is one way to fix it

   $workingDays = $no_full_weeks * 5;

    if ($no_remaining_days > 0 )

    {

      $workingDays += $no_remaining_days;

    }
    //We subtract the holidays

/*    foreach($holidays as $holiday){

        $time_stamp=strtotime($holiday);

        //If the holiday doesn't fall in weekend

        if (strtotime($startDate) <= $time_stamp && $time_stamp <= strtotime($endDate) && date("N",$time_stamp) != 6 && date("N",$time_stamp) != 7)

            $workingDays--;

    }*/
    return round ($workingDays-1);
    }
return NULL;
}
    
}