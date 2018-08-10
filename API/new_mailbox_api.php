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


$domaincheck = $db->fetchOne("SELECT domain FROM domain WHERE domain='".$data['domain']."'");

if(empty($domaincheck))
{

$domain['domain'] = $data['domain'];
$domain['description'] = "";
$domain['aliases'] = 0;
$domain['mailboxes'] = 0;
$domain['maxquota'] = 0;
$domain['quota'] = 0;
$domain['transport'] = "";
$domain['backupmx'] = 0;
$domain['created'] = date("Y-m-d H:i:s");
$domain['modified'] = date("Y-m-d H:i:s");
$domain['active'] = 1;

$db->insert('domain',$domain);	

}


$mailboxcheck = $db->fetchOne("SELECT username FROM mailbox WHERE username='".$data['mailboxname']."@".$data['domain']."'");

if(empty($mailboxcheck))
{

$mailbox['username'] = $data['mailboxname']."@".$data['domain'];
$mailbox['password'] = '{PLAIN-MD5}' . md5($data['password']);
$mailbox['name'] = $data['mailboxname']."@".$data['domain'];
$mailbox['maildir'] = $data['domain'] . "/" . $data['mailboxname']."@".$data['domain'] . "/";
$mailbox['local_part'] = $data['mailboxname']."@".$data['domain'];
$mailbox['quota'] = 0;
$mailbox['domain'] = $data['domain'];
$mailbox['created'] = date("Y-m-d H:i:s");
$mailbox['modified'] = date("Y-m-d H:i:s");
$mailbox['active'] = 1;

$db->insert('mailbox',$mailbox);	

}




$aliascheck = $db->fetchOne("SELECT address FROM alias WHERE address='".$data['mailboxname']."@".$data['domain']."'");

if(empty($aliascheck))
{

$alias['address'] = $data['mailboxname']."@".$data['domain'];
$alias['goto'] = $data['mailboxname']."@".$data['domain'];
$alias['domain'] = $data['domain'];
$alias['created'] = date("Y-m-d H:i:s");
$alias['modified'] = date("Y-m-d H:i:s");
$alias['active'] = 1;

$db->insert('alias',$alias);	

}




