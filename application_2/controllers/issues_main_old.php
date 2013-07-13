<?php
if (!defined('BASEPATH'))
	exit('No direct script access allowed');

class Issues_main extends MY_Controller {
		function __construct() {
		parent::__construct();
		$this->load->helper(array('form','url'));
		
		
	}
	
	
	public function index(){
	    $checker=$this->uri->segment(3);
		$facility=$this->uri->segment(4);
			switch ($checker)
			{
				case 'Internal':
					$data['content_view'] = "IssueInternal_v";
					$data['title'] = "Stock";
					$data['banner_text'] = "Dispense";
					$data['link'] = "IssuesnReceipts";
					$data['quick_link'] = "IssueInternal_v";
					break;
					case 'External':
						$data['content_view'] = "IssueExternal_v";
						$data['content_view'] = "IssueExternal_v";
						$data['banner_text'] = "Donate";
						$data['title'] = "Stock";
						$data['quick_link'] = "IssueExternal_v";
					break;
					default;
						
						$data['content_view'] = "issuesnRecpt";
						$data['banner_text'] = "Issues Home";
						$data['title'] = "Stock";
						$data['quick_link'] = "issuenRecpt";
									
			}


		//$this->output->cache(1);	
		$data['service']=Service::getall($facility);		
		$data['drugs'] = Drug::getAll();
		$data['link'] = "IssuesnReceipts";
     	$this -> load -> view("template", $data);
		
	}
	
	public function Insert()
	{
		
		$ids=$_POST['kemsaCode'];		
	    $Available=$_POST['AvStck'];
		$batchN=$_POST['batchNo'];
		$Expiry=$_POST['Expiries'];
		$sNo=$_POST['S11'];
        $qty=$_POST['Qtyissued'];
		$thedate=$_POST['date_issue'];
		$serviceP=$_POST['Servicepoint'];
        $j=sizeof ($ids);
       $count=0;
        $facilityCode=$facility_c=$this -> session -> userdata('news');	
		$usernow=$this -> session -> userdata('identity');

		for($me=0;$me<$j;$me++){
        	        	
			if ($qty[$me]>0) {
				$count++;
				
				
				
				$mydata = array('facility_code' => $facilityCode,	'kemsa_code' => $ids[$me], 's11_No'=>$sNo[$me], 'batch_no' => $batchN[$me] ,
				'expiry_date' => $Expiry[$me] ,'qty_issued'=> $qty[$me] ,
				'issued_to'=>$serviceP,'balanceAsof'=>$Available[$me], 'date_issued'=>date('y-m-d',strtotime($thedate[$me])),'issued_by'=>$usernow);
				
				$u = new Facility_Issues();

    			$u->fromArray($mydata);

    			$u->save();
				//echo "$xraws records inserted";
				
			$q = Doctrine_Query::create()
			->update('Facility_Stock')
				->set('balance', '?', $Available[$me])
					->where("kemsa_code='$ids[$me]' AND batch_no='$batchN[$me]' and facility_code ='$facilityCode'");

			$q->execute();
			
			$inserttransaction = Doctrine_Manager::getInstance()->getCurrentConnection();
			

			$inserttransaction->execute("UPDATE `facility_transaction_table` SET total_issues = (SELECT SUM(qty_issued) 
			FROM facility_issues WHERE kemsa_code = '$ids[$me]' and availability='1' and facility_code='$facilityCode')
                                          WHERE `kemsa_code`= '$ids[$me]' and availability='1' and facility_code='$facilityCode'; ");
			//echo "$numrows records updated";
			
			$inserttransaction1 = Doctrine_Manager::getInstance()->getCurrentConnection();
			

			$inserttransaction1->execute("UPDATE `facility_transaction_table` SET closing_stock = (SELECT SUM(balance)
			 FROM facility_stock WHERE kemsa_code = '$ids[$me]' and availability='1' and facility_code='$facilityCode')
                                          WHERE `kemsa_code`= '$ids[$me]' and availability='1' and facility_code ='$facilityCode'; ");
			}
			
			
			$data['title'] = "Stock";
			$data['drugs'] = Drug::getAll();
			$data['popout'] = "Your issued $count item(s)";
			$data['content_view'] = "issuesnRecpt";
			$data['banner_text'] = "Stock Control Card";
			$data['link'] = "order_management";
     		$data['quick_link'] = "stockcontrol_c";
			$this -> load -> view("template", $data);
			
		}
        
        
		
		
	}

public function InsertExt()
	{
		
		$ids=$_POST['kemsaCode'];
		$mfl=$_POST['mfl'];			
	    $Available=$_POST['AvStck'];
		$batchN=$_POST['batchN'];
		$Expiry=$_POST['Expiries'];
		$sNo=$_POST['S11'];
        $qty=$_POST['Qtyissued'];
		$thedate=$_POST['date_issue'];
        $j=sizeof ($ids);
       $count=0;
	   $facilityCode=$facility_c=$this -> session -> userdata('news');
       $usernow=$this -> session -> userdata('identity'); 
		
		
		for($me=0;$me<$j;$me++){
        	        	
			if ($qty[$me]>0) {
				$count++;
				
				
				
				$mydata = array('facility_code' => $facilityCode,	'kemsa_code' => $ids[$me], 's11_No'=>$sNo[$me], 'batch_no' => $batchN[$me] ,'expiry_date' => $Expiry[$me] ,'qty_issued'=> $qty[$me] ,'balanceAsof'=>$Available[$me],
				 'date_issued'=>date('y-m-d',strtotime($thedate[$me])),'issued_to'=>$mfl[$me],'issued_by'=>$usernow);
				
				$u = new Facility_Issues();

    			$u->fromArray($mydata);

    			$u->save();
				//echo "$xraws records inserted";
				
			$q = Doctrine_Query::create()
			->update('Facility_Stock')
				->set('balance', '?', $Available[$me])
					->where("kemsa_code='$ids[$me]' AND batch_no='$batchN[$me]'");

			$q->execute();
			
			$inserttransaction = Doctrine_Manager::getInstance()->getCurrentConnection();
			

			$inserttransaction->execute("UPDATE `facility_transaction_table` SET total_issues = (SELECT SUM(qty_issued) FROM facility_issues WHERE kemsa_code = '$ids[$me]')
                                          WHERE `kemsa_code`= '$ids[$me]'; ");
			//echo "$numrows records updated";
			
			$inserttransaction1 = Doctrine_Manager::getInstance()->getCurrentConnection();
			

			$inserttransaction1->execute("UPDATE `facility_transaction_table` SET closing_stock = (SELECT SUM(balance) FROM facility_stock WHERE kemsa_code = '$ids[$me]')
                                          WHERE `kemsa_code`= '$ids[$me]'; ");
			}
			
			
			$data['title'] = "Stock";
			$data['drugs'] = Drug::getAll();
			$data['popout'] = "Your Donated $count item(s)";
			$data['content_view'] = "issuesnRecpt";
			$data['banner_text'] = "Stock Control Card";
			$data['link'] = "order_management";
     		$data['quick_link'] = "stockcontrol_c";
			$this -> load -> view("template", $data);
        	
		}
        
        
		
		
	}
	
	}