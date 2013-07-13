<?php
class Lab_Commodity_Orders extends Doctrine_Record {
	public function setTableDefinition() {
		$this -> hasColumn('id','int');
		$this -> hasColumn('facility_code','varchar', 50);
		$this -> hasColumn('district_id','int');
		$this -> hasColumn('order_date','date');
		$this -> hasColumn('vct','int');
		$this -> hasColumn('pitc','int');
		$this -> hasColumn('pmtct','int');
		$this -> hasColumn('b_screening','int');
		$this -> hasColumn('other','int');
		$this -> hasColumn('rdt_under_tests','int');
		$this -> hasColumn('rdt_under_pos','int');
		$this -> hasColumn('rdt_btwn_tests','int');
		$this -> hasColumn('rdt_btwn_pos','int');
		$this -> hasColumn('rdt_over_tests','int');
		$this -> hasColumn('rdt_over_pos','int');
		$this -> hasColumn('micro_under_tests','int');
		$this -> hasColumn('micro_under_pos','int');
		$this -> hasColumn('micro_btwn_tests','int');
		$this -> hasColumn('micro_btwn_pos','int');
		$this -> hasColumn('micro_over_tests','int');
		$this -> hasColumn('micro_over_pos','int');
		$this -> hasColumn('beg_date','date');
		$this -> hasColumn('end_date','date');
		$this -> hasColumn('explanation','int');
		$this -> hasColumn('moh_642','int');
		$this -> hasColumn('moh_643','int');
		$this -> hasColumn('compiled_by','int');
		$this -> hasColumn('created_at','timestamp');	
	}
	public function setUp() {
		$this -> setTableName('lab_commodity_orders');
		$this->hasMany('Facilities as facility', array(
            'local' => 'facility_code',
            'foreign' => 'facility_code'
        ));
		$this->hasMany('lab_commodity_details as order_details', array(
            'local' => 'id',
            'foreign' => 'order_id'
        ));
	}
	
	public static function save_lab_commodity_order($data_array){
		$o = new Lab_Commodity_Orders();
	    $o->fromArray($data_array);
		$o->save();		
		return TRUE;
	}
	//get the latest order id for a given facility
	public static function get_new_order($facility_code){
		$query = Doctrine_Query::create() -> 
		select("Max(id) as maxId")-> 
		from("lab_commodity_orders") ->
		where("facility_code='$facility_code'");
		$orderNumber = $query -> execute();	
		return $orderNumber[0];
	}
	//gets the orders that are associated with a given district
	public static function get_district_orders($district){
		
		$query=Doctrine_Manager::getInstance()->getCurrentConnection()->fetchAll("SELECT lab_commodity_orders.id, lab_commodity_orders.facility_code, facilities.facility_name, user.fname, user.lname, lab_commodity_orders.order_date
		FROM lab_commodity_orders, facilities, user
		WHERE district_id =$district
		AND lab_commodity_orders.facility_code = facilities.facility_code
		AND user.id = lab_commodity_orders.compiled_by
		ORDER BY lab_commodity_orders.id");
		return $query;
	}
	public static function get_recent_lab_orders($facility_code){
	$last_month=date('m');
	$month_ago=date('Y-'.$last_month.'-d');
	// $facility_code=12889;
	
	$query = Doctrine_Query::create() -> select("facility_code, order_date") 
	-> from("Lab_Commodity_Orders")-> where("month(order_date)=$last_month")->andWhere("facility_code='$facility_code'");
	$stocktake = $query ->execute()->toArray();
	return $query->count();

}
	
}
?>