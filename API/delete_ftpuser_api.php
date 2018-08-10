<?php 
if(empty($_POST) || !($_POST))
{
echo "Permission Denied";
die();	
}


if(!isset($_POST['serialkey']) || empty($_POST['serialkey']))
{
echo "Permission Denied";
die();	
}


$data = $_POST;


require_once('../library/config.php');

function __autoload($class_name) {
	$class = explode("_",$class_name);
	$path = implode("/",$class).".php";
	require_once($path);
}

$global = new CommonFunctions();
$encrypt = new Encryption();

define("DBSCHEMA", "mysql");
define("DBHOST", "localhost");
define("DBUSER", "proftpd");
define("DBPASS", $encrypt->decode($data['proftpd']));
define("DBNAME", "zinck_proftpd");

$db = new DbConfig();

$ftpcheck = $db->fetchOne("SELECT userid FROM ftpuser WHERE userid='".$data['ftpuser']."'");

if(!empty($ftpcheck))
{
	
$db->delete('ftpuser',$data['ftpuser'],'userid');

}
