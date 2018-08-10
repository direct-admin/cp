<?php
/**
 * MainConfig Class
 * @package		CommonFunctions Class
 * @link		http://zincksoft.com
 * @author		Zincksoft.com <info@zincksoft.com>
 * @copyright	2007 - 2014 Zincksoft.com <info@zincksoft.com>
 * @version		1.0.1
**/


class CommonFunctions {
	
	
	public function post2array($post)
	{
		$array = array();
		
		foreach ($post as $key => $value)
		{
			$array[$key] = $value;
		}
		
		return $array;
		
	}
	
	
	
	public function SetWebLanguage($lang){
	include 'lang/'.$lang.'.php';
	}
	
	public function Plugin_SetWebLanguage($lang){
	include $lang;
	}
	
	public function SetTimeZone($timezone){
	date_default_timezone_set($timezone);	
	}
	
	
	/**
 * Page Redirct Function
 */
 
	public function redirect($url) { 
    die('<meta http-equiv="refresh" content="0;URL='.$url.'">'); 
    }
	
	/**
 * Clean Input Fields before Mysql Request
 */
 
	public function clean_input($instr) {
    if(get_magic_quotes_gpc()) {
        $str = stripslashes($instr);
    }
  
   return preg_replace('/[^A-Za-z0-9\-]/', '', $instr); // Removes special chars.
   
//   return $instr;
	}	
	
	
	public function clean_pager($instr){
		
		if($instr < 0)
		{
		$instr =0;	
		}
		
		return preg_replace('/[^a-zA-Z0-9_ %\[\]\.\(\)%&-]/s', '', $instr); // Removes special chars.
		
	}
	
	
	
	// Search and Replace the email template fields with real data
	
	public function templatereplace($template,$find,$replace)
	{
		 $returntemplate = str_replace("[".$find."]", $replace, $template);
		 
		 return $returntemplate;
		
	}
	
	
	
	// *************************** Post Curl Method Function start ************************

	public function curlUsingPost($url, $data)
	{
	
		if(empty($url) OR empty($data))
		{
			return 'Error: invalid Url or Data';
		}
	
		
		//url-ify the data for the POST
		$fields_string = '';
		foreach($data as $key=>$value) { $fields_string .= $key.'='.urlencode($value).'&'; }
		rtrim($fields_string,'&');
	
	
		//open connection
		$ch = curl_init();
	
		//set the url, number of POST vars, POST data
		curl_setopt($ch,CURLOPT_URL,$url);
		curl_setopt($ch,CURLOPT_POST,count($data));
		curl_setopt($ch,CURLOPT_POSTFIELDS,$fields_string);
	
		//curl_setopt($ch,CURLOPT_SSL_VERIFYPEER,true); 
		//curl_setopt($ch,CURLOPT_CAINFO, getcwd().'/cacert.pem'); /* fixed! */
	
		curl_setopt($ch,CURLOPT_CONNECTTIMEOUT,10); # timeout after 10 seconds, you can increase it
		//curl_setopt($ch,CURLOPT_HEADER,false);
		curl_setopt ($ch, CURLOPT_RETURNTRANSFER, 1);  # Set curl to return the data instead of printing it to the browser.
		curl_setopt($ch,  CURLOPT_USERAGENT , "Mozilla/4.0 (compatible; MSIE 8.0; Windows NT 6.1)"); # Some server may refuse your request if you dont pass user agent
		
		//execute post
		$result = curl_exec($ch);
		
	if($result=== false)
	{
	
		$myFile = "curl_errors.txt";
		$fh = fopen($myFile, 'a') or die("can't open file");
		
		$stringData = $url;
		fwrite($fh, $stringData);
		$stringData = "\n**************************************************************\n";
		
		$stringData = $fields_string;
		fwrite($fh, $stringData);
		$stringData = "\n**************************************************************\n";
		
		$stringData = 'Curl error: ' . curl_error($ch);
		fwrite($fh, $stringData);
		$stringData = "\n**************************** END Here **********************************\n";
		fwrite($fh, $stringData);
		fclose($fh);

}
	
		//close connection
		curl_close($ch);
		return $result;
	}
	
	// *************************** Post Curl Method Function end ************************
	
	
	
	// *************************** Get Curl Method Function start ************************

	public function curlUsingGet($url, $data)
	{
	
		if(empty($url) OR empty($data))
		{
			return 'Error: invalid Url or Data';
		}
	
		
		//url-ify the data for the POST
		$fields_string = '';
		foreach($data as $key=>$value) { $fields_string .= $key.'='.urlencode($value).'&'; }
		rtrim($fields_string,'&');
		
		//Final url
		$destination = $url . "?" . $fields_string;
	
	
		//open connection
		$ch = curl_init();
	
		//set the url, number of POST vars, POST data
		curl_setopt($ch,CURLOPT_URL,$destination);
		
		curl_setopt($ch,CURLOPT_CONNECTTIMEOUT,10); # timeout after 10 seconds, you can increase it
		curl_setopt ($ch, CURLOPT_RETURNTRANSFER, 1);  # Set curl to return the data instead of printing it to the browser.
		curl_setopt($ch,  CURLOPT_USERAGENT , "Mozilla/4.0 (compatible; MSIE 8.0; Windows NT 6.1)"); # Some server may refuse your request if you dont pass user agent
		
		//execute post
		$result = curl_exec($ch);
		
	if($result=== false)
	{
	
		$myFile = "curl_errors.txt";
		$fh = fopen($myFile, 'a') or die("can't open file");
		
		$stringData = $url;
		fwrite($fh, $stringData);
		$stringData = "\n**************************************************************\n";
		
		$stringData = $fields_string;
		fwrite($fh, $stringData);
		$stringData = "\n**************************************************************\n";
		
		$stringData = 'Curl error: ' . curl_error($ch);
		fwrite($fh, $stringData);
		$stringData = "\n**************************** END Here **********************************\n";
		fwrite($fh, $stringData);
		fclose($fh);

}
	
		//close connection
		curl_close($ch);
		return $result;
	}
	
	// *************************** Get Curl Method Function end ************************
	
	
	
	// *************************** Get Download Page Curl Method Function start ************************

	public function DownloadPage($url)
	{
	
		if(empty($url))
		{
			return 'Error: invalid Url or Data';
		}
	
		
		//Final url
		$destination = $url ;
	
	
		//open connection
		$ch = curl_init();
	
		//set the url, number of POST vars, POST data
		curl_setopt($ch,CURLOPT_URL,$destination);
		
		curl_setopt($ch,CURLOPT_CONNECTTIMEOUT,10); # timeout after 10 seconds, you can increase it
		curl_setopt ($ch, CURLOPT_RETURNTRANSFER, 1);  # Set curl to return the data instead of printing it to the browser.
		curl_setopt($ch,  CURLOPT_USERAGENT , "Mozilla/4.0 (compatible; MSIE 8.0; Windows NT 6.1)"); # Some server may refuse your request if you dont pass user agent
		
		//execute post
		$result = curl_exec($ch);
		
	if($result=== false)
	{
	
		$myFile = "curl_errors.txt";
		$fh = fopen($myFile, 'a') or die("can't open file");
		
		$stringData = $url;
		fwrite($fh, $stringData);
		$stringData = "\n**************************************************************\n";
		
		$stringData = $fields_string;
		fwrite($fh, $stringData);
		$stringData = "\n**************************************************************\n";
		
		$stringData = 'Curl error: ' . curl_error($ch);
		fwrite($fh, $stringData);
		$stringData = "\n**************************** END Here **********************************\n";
		fwrite($fh, $stringData);
		fclose($fh);

}
	
		//close connection
		curl_close($ch);
		return $result;
	}
	
	// *************************** Get Curl Method Function end ************************
	
	
	
	
	/**
     * Checks vaid domain name format.
	 */
	 
	  public function IsValidDomainName($domainname) {
        if (stristr($domainname, '.')) {
            $part = explode(".", $domainname);
            foreach ($part as $check) {
                if (!preg_match('/^[a-z\d][a-z\d-]{0,62}$/i', $check) || preg_match('/-$/', $check)) {
                    return false;
                }
            }
        } else {
            return false;
        }
        return true;
    }
	
	
	/**
     * Checks that an email address is of a valid format.
	 */
	 public function IsValidEmail($email) {
        if (!preg_match('/^[a-z0-9]+([_\\.-][a-z0-9]+)*@([a-z0-9]+([\.-][a-z0-9]+)*)+\\.[a-z]{2,}$/i', $email))
            return false;
        return true;
    }
	
	
	
	/**
     * Checks that a user name is of a valid format.
	 */
	 
	 public function IsValidUserName($username) {
        if (!preg_match('/^[a-z\d][a-z\d-]{0,62}$/i', $username) || preg_match('/-$/', $username))
            return false;
        return true;
    }
	
	

	
	public function check_port($port) {
    $conn = @fsockopen("127.0.0.1", $port, $errno, $errstr, 0.2);
    if ($conn) {
        fclose($conn);
        return true;
    }
}

public function server_report() {
    $report = array();
    $svcs = array('21'=>'FTP',
                  '22'=>'SSH',
                  '25'=>'SMTP',
                  '80'=>'HTTP',
                  '110'=>'POP3',
                  '143'=>'IMAP',
                  '3306'=>'MySQL');
    foreach ($svcs as $port=>$service) {
        $report[$service] = $this->check_port($port);
    }
    return $report;
}
	
	
	
}