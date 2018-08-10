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

require_once('../library/dbconfig.php');
require_once('../library/config.php');

function __autoload($class_name) {
	$class = explode("_",$class_name);
	$path = implode("/",$class).".php";
	require_once($path);
}

$global = new CommonFunctions();
$db = new DbConfig();
$file_handler = new DirFileHandler();
$CLI = new SystemCLI();

$system = $db->fetchOne('Select * from system where id=1');


$vhost_header = base64_decode($system['vhost_header']);

$find = array("###SYSTEMIP###","###PORT###","###VERSION###");

$replace = array($system['systemip'],$system['panelport'],$config['version']);

$vhost_header = str_replace($find, $replace, $vhost_header);

// main domains

$vhosts = $db->fetchAll("SELECT * FROM  domains");

$vhost_file = $global->DownloadPage("http://zincksoft.com/license/zncp/vhost_template.php");

$vhost_complete_file="";

for($i=0;$i<count($vhosts);$i++)
{

$domain_find = array("###DOMAIN_NAME###","###DOMAIN_WWW###");

$domain_replace = array($vhosts[$i]['domain_name'],$vhosts[$i]['www_path']);

$vhost_complete_file = $vhost_complete_file . str_replace($domain_find,$domain_replace,$vhost_file);

}

// subdomains

$vhostsub = $db->fetchAll("SELECT * FROM  subdomains");

$vhost_sub_file = $global->DownloadPage("http://zincksoft.com/license/zncp/vhost_sub_template.php");

for($i=0;$i<count($vhostsub);$i++)
{

$domain_name = $vhostsub[$i]['subname'] .".".$vhostsub[$i]['domain_name'];

$sub_domain_find = array("###DOMAIN_NAME###","###DOMAIN_WWW###");

$sub_domain_replace = array($domain_name,$vhostsub[$i]['www_path']);

$vhost_complete_file = $vhost_complete_file . str_replace($sub_domain_find,$sub_domain_replace,$vhost_sub_file);

}

$vhost_complete_file = $vhost_header . $vhost_complete_file;

$file_handler->UpdateFile($system['vhost_url'],0777,$vhost_complete_file);

$CLI->Command($system['zcli_path'],array($system['services_namespace'],$system['apache_namespace'],$system['apache_reload']));