<?php
class Historical_Stock extends Doctrine_Record {

	public function setTableDefinition() {
		
				$this->hasColumn('id', 'int', 11);
				$this->hasColumn('facility_code', 'varchar',20);
				$this->hasColumn('drug_id', 'int', 11);
				$this->hasColumn('description', 'varchar',100);
				$this->hasColumn('unit_size', 'varchar',50);
				$this->hasColumn('consumption_level', 'varchar',50);
				$this->hasColumn('unit_count', 'varchar',40);
				$this->hasColumn('selected_option', 'varchar',20);
				
		
	}
	
	public function setUp() {
		$this->setTableName('historical_stock');	
	}	
	public function get_historical_stock($facility_code){
		$query = Doctrine_Query::create() -> select("*") -> from("historical_stock") -> where("facility_code=$facility_code");
		$stock = $query -> execute();
		return $stock;
	}
	public static function count_historical_stock($facility_code){
		$query = Doctrine_Query::create() -> select("drug_id, SUM(consumption_level) AS quantity1") -> from("historical_stock") -> where("facility_code=$facility_code")->groupby( "drug_id");
		$stocktake = $query ->execute();
		
		return $stocktake;
	}
	public static function load_historical_stock($facility_code){
		$query = Doctrine_Manager::getInstance()->getCurrentConnection()->fetchAll("SELECT d.id, h.`drug_id`, h.`consumption_level`, h.`unit_count`, h.`selected_option`
			FROM drug d LEFT JOIN `historical_stock` h ON d.id=h.drug_id
			AND h.facility_code=$facility_code");
		
		return $query;
	}
	}