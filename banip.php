<?php include ('library/autoload.php');

$currenttime = time();

$banip = $db->fetchOne('Select * from banip where ip=":ip"',array(":ip"=>getenv('REMOTE_ADDR')));

if(!empty($banip))
{
	$ban_duration = ($currenttime - $banip['timestamp']) / 60;
	
	if($ban_duration > 25)
	{
		$db->delete('banip',getenv('REMOTE_ADDR'),'ip');
		$global->redirect('index.php');
	}
}
else
{
$global->redirect('index.php');	
}
?>

<h1>Access Restricted</h1>