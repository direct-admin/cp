<?php 

class FormValidation
{
	
	public $message;
	
	private $postdata = array();
	
	public function __construct($postdata = array())
	{
	$this->postdata = $postdata;
	}
	
	public function ValidateData($validation = array())
	{
	return $this->postdata;	
	}
	
	
	
	public function RequiredData($requiredfields = array())
	{
		
		foreach ($requiredfields as $fieldname => $fielddesc)
		{
		if(empty($_POST[$fieldname]))
		{
			$this->message .= $fielddesc . " is Mandatory.<br>";
		}
		}
		
		//return "<div class='alert alert-danger'><i class='fa fa-ban-circle'></i>".$this->message ."</div>";
	}
	
	
	public static function textHit($string, $exclude=""){
		if(empty($exclude)) return false;
		if(is_array($exclude)){
			foreach($exclude as $text){
				if(strstr($string, $text)) return true;
			}
		}else{
			if(strstr($string, $exclude)) return true;
		}
		return false;
	}
	
	public function Email($string, $exclude=""){
		if(self::textHit($string, $exclude)) return false;
		return (bool)preg_match("/^([a-z0-9])(([-a-z0-9._])*([a-z0-9]))*\@([a-z0-9])(([a-z0-9-])*([a-z0-9]))+(\.([a-z0-9])([-a-z0-9_-])?([a-z0-9])+)+$/i", $string);
	}
	
	public function EmailCheck($requiredfields = array())
	{
		
		foreach ($requiredfields as $fieldname => $fielddesc)
		{
		if($this->Email($_POST[$fieldname]) == false)
		{
			$this->message .= $fielddesc . " Should Be Valid Email ID.<br>";
		}
		}
		
	}
	
	
	public function AlphaNumeric($requiredfields = array())
	{
		
		foreach ($requiredfields as $fieldname => $fielddesc)
		{
		if(preg_match("/^[0-9a-zA-Z]+$/",$_POST[$fieldname]) == false)
		{
			$this->message .= $fielddesc . " Should Be Alpha Numeric.<br>";
		}
		}
		
	}
	
	public function ValidName($requiredfields = array())
	{
		foreach ($requiredfields as $fieldname => $fielddesc)
		{
		if(preg_match("/^[0-9a-zA-Z]+$/",$_POST[$fieldname]) == false)
		{
			$this->message .= $fielddesc . " Should Be Valid , Start with Alphabet and contains only Alphabet and Numbers.<br>";
		}
		}
	}
	
	
	/**
     * Checks vaid domain name format.
	 */
	 
	  public function IsValidDomainName($requiredfields = array()) {
		  
		foreach ($requiredfields as $fieldname => $fielddesc)
		{
		
		$domainname = $_POST[$fieldname];
			
        if (stristr($domainname, '.')) {
            $part = explode(".", $domainname);
            foreach ($part as $check) {
                if (!preg_match('/^[a-z\d][a-z\d-]{0,62}$/i', $check) || preg_match('/-$/', $check)) {
                    //return false;
					
					$this->message .= $fielddesc . " Should Be Valid.<br>";
                }
            }
        } else {
            //return false;
			
			$this->message .= $fielddesc . " Should Be Valid.<br>";
        }
        //return true;
		
		}
    }
	
	
	/**
     * Checks vaid IPV4 or IPV6 format.
	 */
	 
	 public function IPV4_IPV6($requiredfields = array(), $type = "IPV4")
	 {
		 
		foreach ($requiredfields as $fieldname => $fielddesc)
		{
			
			if($type == "IPV4")
			{
				if (!filter_var($_POST[$fieldname], FILTER_VALIDATE_IP) === true) {
					
					$this->message .= $fielddesc . " Should Be Valid IP.<br>";
				}
				
			}
			else if ($type == "IPV6")
			{
				if (!filter_var($_POST[$fieldname], FILTER_VALIDATE_IP, FILTER_FLAG_IPV6) === true) {
					
					$this->message .= $fielddesc . " Should Be Valid IPv6 address.<br>";
					
				}
				
			}
			
			
		}
		 
		 
	 }
	
	
	
	
	/**
     * Checks that a user name is of a valid format.
	 */
	 
	 public function IsValidUserName($username) {
        if (!preg_match('/^[a-z\d][a-z\d-]{0,62}$/i', $username) || preg_match('/-$/', $username))
		{
            $this->message .= $fielddesc . " Should Be Valid.<br>";
		}
    }
	
	
	
	public function ValidationErrors(){
	return $this->message;
	}
	
}

