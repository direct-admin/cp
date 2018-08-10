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

$config = $db->fetchOne('Select * from settings where id=1');
$system = $db->fetchOne('Select * from system where id=1');

$dnsmanager = $db->fetchOne('Select * from dnsmanager where dnsid=:dnsid',array(":dnsid"=>$global->clean_input($_POST['dnsid'])));

$dns = $db->fetchAll('Select * from dns where dnsid=:dnsid order by dns_type asc',array(":dnsid"=>$global->clean_input($_POST['dnsid'])));

/* Genrate Zone Files */


				$zonefile = "$" . "TTL 10800" . $file_handler->NewLine();
                $zonefile .= "@ IN SOA " . $dnsmanager['domain_name'] . ". ";
                $zonefile .= "postmaster." . $dnsmanager['domain_name'] . ". (" . $file_handler->NewLine();
                $zonefile .= " " . date("Ymdt") . " ;serial" . $file_handler->NewLine();
                $zonefile .= " " . $system['refresh_ttl'] . " ;refresh after 6 hours" . $file_handler->NewLine();
                $zonefile .= " " . $system['retry_ttl'] . " ;retry after 1 hour" . $file_handler->NewLine();
                $zonefile .= " " . $system['expire_ttl'] . " ;expire after 1 week" . $file_handler->NewLine();
                $zonefile .= " " . $system['minimum_ttl'] . " ) ;minimum TTL of 1 day" . $file_handler->NewLine();
				
				

for($j=0;$j<count($dns);$j++)
{
					if ($dns[$j]['dns_type'] == "A") {
                        $zonefile .= $dns[$j]['dns_host'] . " " . $dns[$j]['dns_ttl'] . " IN A " . $dns[$j]['dns_target'] . $file_handler->NewLine();
                    }
                    if ($dns[$j]['dns_type'] == "AAAA") {
                        $zonefile .= $dns[$j]['dns_host'] . " " . $dns[$j]['dns_ttl'] . " IN AAAA " . $dns[$j]['dns_target'] . $file_handler->NewLine();
                    }
                    if ($dns[$j]['dns_type'] == "CNAME") {
                        $zonefile .= $dns[$j]['dns_host'] . " " . $dns[$j]['dns_ttl'] . " IN CNAME " . $dns[$j]['dns_target'] . $file_handler->NewLine();
                    }
                    if ($dns[$j]['dns_type'] == "MX") {
                        $zonefile .= $dns[$j]['dns_host'] . " " . $dns[$j]['dns_ttl'] . " IN MX " . $dns[$j]['dns_priority'] . " " . $dns[$j]['dns_target'] . "." . $file_handler->NewLine();
                    }
                    if ($dns[$j]['dns_type'] == "TXT") {
                        $zonefile .= $dns[$j]['dns_host'] . " " . $dns[$j]['dns_ttl'] . " IN TXT \"" . stripslashes($dns[$j]['dns_target']) . "\"" . $file_handler->NewLine();
                    }
                    if ($dns[$j]['dns_type'] == "SRV") {
                        $zonefile .= $dns[$j]['dns_host'] . " " . $dns[$j]['dns_ttl'] . " IN SRV " . $dns[$j]['dns_priority'] . " " . $dns[$j]['dns_weight'] . " " . $dns[$j]['dns_port'] . " " . $dns[$j]['dns_target'] . "." . $file_handler->NewLine();
                    }
                    if ($dns[$j]['dns_type'] == "SPF") {
                        $zonefile .= $dns[$j]['dns_host'] . " " . $dns[$j]['dns_ttl'] . " IN SPF \"" . stripslashes($dns[$j]['dns_target']) . "\"" . $file_handler->NewLine();
                    }
                    if ($dns[$j]['dns_type'] == "NS") {
                        $zonefile .= $dns[$j]['dns_host'] . " " . $dns[$j]['dns_ttl'] . " IN NS " . $dns[$j]['dns_target'] . "." . $file_handler->NewLine();
                    }
		
}
	



/* check for zone file existence and update or create new zone file */

$zone_file_path = $system['zone_path'] . '/' . $dnsmanager['domain_name'] . '.db';

if(!$file_handler->CheckFileExists($zone_file_path))
{
$file_handler->CreateFile($zone_file_path, 0777, $zonefile);
}
else
{
$file_handler->UpdateFile($zone_file_path, 0777, $zonefile);
}

