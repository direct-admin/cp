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

$crons = $db->fetchAll('Select * from cronjobs');

$cronfile="";

for($i=0;$i<count($crons);$i++)
{
	
	$cronfile .= "# CRON NAME: " . $crons[$i]['name'] . "" . $file_handler->NewLine();
	
    $cronfile .= "" . $crons[$i]['time'] . " " . $system['php_exe'] . " -d suhosin.executor.func.blacklist=\"passthru, show_source, shell_exec, system, pcntl_exec, popen, pclose, proc_open, proc_nice, proc_terminate, proc_get_status, proc_close, leak, apache_child_terminate, posix_kill, posix_mkfifo, posix_setpgid, posix_setsid, posix_setuid, escapeshellcmd, escapeshellarg, exec\" -d open_basedir=\"" . $system['host_dir']  . "/" . $system['openbase_seperator'] . $system['openbase_temp'] . "\" " . $crons[$i]['script'] . "" . $file_handler->NewLine();
					
    $cronfile .= "# END CRON NAME: " . $crons[$i]['name'] . "" . $file_handler->NewLine() . $file_handler->NewLine();
	
}


$file_handler->UpdateFile($system['cron_path'], 0644, $cronfile);