<?php
class Log extends Doctrine_Record {
	public function setTableDefinition() {
		$this -> hasColumn('user_id', 'varchar',255);	
		$this -> hasColumn('action', 'varchar',255);	
		
		
	}

	public function setUp() {
		$this -> setTableName('log');
		
	}
}