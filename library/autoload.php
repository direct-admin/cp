<?php require_once('dbconfig.php');
require_once('config.php');
//ini_set('display_errors',1); 
//error_reporting(E_ALL);

//require_once('compressor.php');
function __autoload($class_name) {
	$class = explode("_",$class_name);
	$path = implode("/",$class).".php";
	require_once($path);
}

include 'include/htmlcompressor.php';

$global = new CommonFunctions();
$db = new DbConfig();
$formobj = new FormClass();
$encrypt = new Encryption();

$config = $db->fetchOne('Select * from settings where id=1');
$system = $db->fetchOne('Select * from system where id=1');
$global->SetWebLanguage($config['defaultadminlang']);
$global->SetTimeZone($config['timezone']);

// Session Create
$sess = new Session(array('host' => DBHOST,'user' => DBUSER,'pass' => DBPASS,'db' => DBNAME));

// create a new session
$sess->create();