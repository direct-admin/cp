<?php

require_once('DB.php');

class DbConfig extends DB {
	
	protected $_schema = DBSCHEMA;
	protected $_hostname = DBHOST;
	protected $_database = DBNAME;
	protected $_username = DBUSER;
	protected $_password = DBPASS;
	
	
	public function __construct(array $array=null){
		
		if(!empty($array)){
			
			foreach($array as $key => $value){
				
				$this->{$key} = $value;
				
			}
			
		}
		
		parent::__construct();
		
	}



}