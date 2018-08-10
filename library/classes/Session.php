<?php
/**
 * Database stored session class
 * 
 * @author Ben Phelps
 * @version 1.0
 * @copyright Ben Phelps - BenPhelps.me, 30 June, 2010
 * @package Session
 **/

/**
 * Session Class
 * Store session data in database, create, set, remove, destroy
 * @package Session
 * @author Ben Phelps
 **/
class Session {
	
	
 	private $session_temp = '';
	
	/**
	 * Class constructor, connects to the database
	 *
	 * @return void
	 * @author Ben Phelps
	 **/
	function __construct($config)
	{
		mysql_connect($config['host'], $config['user'], $config['pass']);
		mysql_select_db($config['db']);
	}

	/**
	 * Remove array entree based on its key
	 *
	 * @return array
	 * @access private
	 * @author Unknown (macnimble@gmail.com)
	 **/
	private function remove_key()
	{
		// get arguments passed to the function
		$args  = func_get_args();
		// ?? do magic
		return array_diff_key($args[0],array_flip(array_slice($args,1)));
	}

	/**
	 * Create a new session
	 *
	 * @return boolean
	 * @access public
	 * @author Ben Phelps
	 **/
	public function create()
	{
		// check if we have a session already
		if(isset($_COOKIE['session']))
		{
			// send false if we do
			return FALSE;
		}
		else 
		{
			// we dont have one set so lets make one
			
			// create a unique id, this is kinda overkill but it will be unique
			$key = sha1(uniqid(sha1(uniqid(null, true)), true));
			
			// store the session key in the class
			$this->session_temp = $key;
			
			// set a cookie to expire in one hour
			setcookie('session', $key, time()+3600);
			
			// create an empty seesion and serialize it
			$session = serialize(array());
			
			// read the browser from server global
			$browser = mysql_real_escape_string($_SERVER['HTTP_USER_AGENT']);
			
			// read the ip from server global
			$ip = $_SERVER['REMOTE_ADDR'];
				
			// build the sql
			$sql = "INSERT INTO `session` (`id`, `data`, `key`, `browser`, `ip`)
					VALUES (NULL, '{$session}', '{$key}', '{$browser}', '{$ip}');";
					
			// run the sql
			$query = mysql_query($sql);
			
			// return true
			return TRUE;
		}
	}

	/**
	 * Read the array from the database
	 *
	 * @return array
	 * @access private
	 * @author Ben Phelps
	 **/
	private function read()
	{
		// pull the key from temp storage or the session value
		$key = (isset($_COOKIE['session'])?$_COOKIE['session']:$this->session_temp);
		
		// pull the browser from server global
		$browser = mysql_real_escape_string($_SERVER['HTTP_USER_AGENT']);
		
		// pull ip from server global
		$ip = $_SERVER['REMOTE_ADDR'];
		
		// build the sql
		$query = "SELECT * FROM `session` WHERE `key` = '{$key}' AND `browser` = '{$browser}' AND `ip` = '{$ip}';";
		
		// run the sql
		$result = mysql_query($query);
		$result = mysql_fetch_array($result);
		
		// turn the string into an array
		$result = unserialize($result['data']);
		
		// return an array
		return $result;
	}
	
	/**
	 * Save an array to the database
	 *
	 * @param array
	 * @return null
	 * @access private
	 * @author Ben Phelps
	 **/
	private function save($session)
	{
		// turn the array into a string
		$session = serialize($session);
		
		// pull the key from temp storage or the session value
		$key = (isset($_COOKIE['session'])?$_COOKIE['session']:$this->session_temp);
		
		// pull the browser from server global
		$browser = mysql_real_escape_string($_SERVER['HTTP_USER_AGENT']);
		
		// pull ip from server global
		$ip = $_SERVER['REMOTE_ADDR'];
		
		// uild the sql
		$sql = "UPDATE `session` SET `data` = '{$session}' WHERE `key` = '{$key}';";
		
		// run the sql
		$query = mysql_query($sql);
	}
	
	/**
	 * Return the raw session array
	 *
	 * @return array
	 * @access public
	 * @see read()
	 * @author Ben Phelps
	 **/
	public function raw()
	{
		// return an array from read();
		return $this->read();
	}
	
	/**
	 * Check if there is a session active
	 *
	 * @return boolean
	 * @access public
	 * @author Ben Phelps
	 **/
	public function active()
	{
		// check if we have a seesion set
		if(isset($_COOKIE['session']) || isset($this->session_temp))
		{
			// return true that we do
			return TRUE;
		}
		else
		{	
			// false if we dont
			return FALSE;
		}
	}
	
	/**
	 * Destroy the session cookie ending any session
	 *
	 * @return void
	 * @access public
	 * @author Ben Phelps
	 **/
	public function destroy()
	{
		// set the seesion to null
		$this->session_temp = NULL;
		
		// set php to delete in garbage collection
		unset($this->session_temp);
		
		// set cookie to a date in the past
		setcookie('session', 'NULL', time()-3600);
	}
	
	/**
	 * Set a session variable 
	 *
	 * @return boolean
	 * @access public
	 * @author Ben Phelps
	 **/
	public function set($key, $value, $overwrite = true)
	{
		// pull the seesion data from the database
		$session = $this->read();
		
		// check if we have one set. and check if we are overwriting
		if( isset($session[$key]) && $overwrite == false)
		{
			// one is set and overwrite is false
			return FALSE;
		}
		else
		{
			// if one is set, overwite is true so we ignore it
			
			// set the value
			$session[$key] = $value;
			
			// save the new array to the database
			$this->save($session);
			
			// return true
			return TRUE;
		}
	}
	
	/**
	 * Fetch a session value 
	 *
	 * @return string|boolean
	 * @access public
	 * @author Ben Phelps
	 **/
	public function get($key)
	{
		// pull session array from database
		$session = $this->read();
		
		// check if the value is set
		if(isset($session[$key]))
		{
			// it was, so return it
			return $session[$key];
		}
		else
		{
			// it was not so return false
			return FALSE;
		}
	}
	
	/**
	 * Delete a session value
	 *
	 * @return boolean
	 * @access public
	 * @author Ben Phelps
	 **/
	public function drop($key)
	{
		// read the session array from the database
		$session = $this->read();
		
		// check if it is set
		if(isset($session[$key]))
		{
			// it is so we can delete it
			$session = $this->remove_key($session, $key);
			
			// save the new array
			$this->save($session);
			
			// send true
			return TRUE;
		}
		else
		{
			// was nt found in the array so send false
			return FALSE;
		}
	}
}
?>