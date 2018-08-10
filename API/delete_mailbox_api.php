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
define("DBUSER", "postfix");
define("DBPASS", $encrypt->decode($data['postfix']));
define("DBNAME", "zinck_postfix");

$db = new DbConfig();

$mailboxcheck = $db->fetchOne("SELECT username FROM mailbox WHERE username='".$data['mailboxname']."@".$data['domain']."'");

if(!empty($mailboxcheck))
{
$db->delete('mailbox',$data['mailboxname']."@".$data['domain'],'username');

$db->delete('alias',$data['mailboxname']."@".$data['domain'],'address');

}
