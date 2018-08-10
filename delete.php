<?php require_once('library/autoload.php'); 
require_once('include/sessioncheck.php');

// delete mailbox
if($_GET['type'] ==0)
{

$mailboxcheck = $db->fetchOne("SELECT mailboxname FROM mailboxes WHERE mailboxid=:mailboxid", array(":mailboxid"=>$_GET['id']));

$delete['domain'] = $system['domain'];
$delete['mailboxname']=$mailboxcheck['mailboxname'];
$delete['postfix'] = $encrypt->encode($system['postfix_access']);
$delete['serialkey']= $config['serialkey'];

$global->curlUsingPost('http://'.$system['systemip'].':'.$system['panelport'].'/API/delete_mailbox_api.php',$delete);

$db->delete('mailboxes',$_GET['id'],'mailboxid');

$global->redirect('mailbox.php');	
}


// delete ftp account
if($_GET['type'] ==1)
{

$ftpcheck = $db->fetchOne("SELECT ftpuser FROM ftpuser WHERE ftpid=:ftpid", array(":ftpid"=>$_GET['id']));

$delete['domain'] = $system['domain'];
$delete['ftpuser']=$ftpcheck['ftpuser'];
$delete['proftpd'] = $encrypt->encode($system['proftpd_access']);
$delete['serialkey']= $config['serialkey'];
$global->curlUsingPost('http://'.$system['systemip'].':'.$system['panelport'].'/API/delete_ftpuser_api.php',$delete);

$db->delete('ftpuser',$_GET['id'],'ftpid');

$global->redirect('ftpuser.php');	
}

// drop mysql database
if($_GET['type'] ==2)
{

$dbcheck = $db->fetchOne("SELECT * FROM mysqldb WHERE dbid=:dbid", array(":dbid"=>$_GET['id']));

if(!empty($dbcheck))
{
$db->delete('mysqldb',$_GET['id'],'dbid');
$db->execute('drop database ' . $dbcheck['dbname']);
}

$global->redirect('mysqldb.php');	
}

// drop mysql user
if($_GET['type'] ==3)
{

$usercheck = $db->fetchOne("SELECT * FROM mysqlusers WHERE mysqluserid=:mysqluserid", array(":mysqluserid"=>$_GET['id']));

if(!empty($usercheck))
{
$db->delete('mysqlusers',$_GET['id'],'mysqluserid');
$db->execute('DROP USER '.$usercheck['username'].'@localhost;');
}

$global->redirect('mysqlusers.php');	
}


// delete domain
if($_GET['type'] ==4)
{

$db->delete('domains',$_GET['id'],'domainid');

$delete['valid'] = 0;
$delete['serialkey']= $config['serialkey'];
$global->curlUsingGet('http://'.$system['systemip'].':'.$system['panelport'].'/API/vhost_domain.php',$delete);

$global->redirect('domains.php');	
}

// delete subdomain
if($_GET['type'] ==5)
{

$db->delete('subdomains',$_GET['id'],'subdomainid');

$delete['valid'] = 0;
$delete['serialkey']= $config['serialkey'];
$global->curlUsingGet('http://'.$system['systemip'].':'.$system['panelport'].'/API/vhost_domain.php',$delete);

$global->redirect('subdomains.php');	
}


// delete DNS A Record
if($_GET['type'] ==6)
{

$db->delete('dns',$_GET['dnsid'],'dnssetid');

$global->redirect('editarecords.php?id='.$_GET['id']);	
}


// delete Cron Jobs
if($_GET['type'] ==7)
{

$db->delete('cronjobs',$_GET['id'],'jobid');

$global->redirect('cronjobs.php');	
}


// delete DNS AAA Record
if($_GET['type'] ==8)
{

$db->delete('dns',$_GET['dnsid'],'dnssetid');

$global->redirect('editaaarecords.php?id='.$_GET['id']);	
}


// delete DNS CNAME Record
if($_GET['type'] ==9)
{

$db->delete('dns',$_GET['dnsid'],'dnssetid');

$global->redirect('editcnamerecords.php?id='.$_GET['id']);	
}


// delete DNS MX Record
if($_GET['type'] ==10)
{

$db->delete('dns',$_GET['dnsid'],'dnssetid');

$global->redirect('editmxrecords.php?id='.$_GET['id']);	
}


// delete DNS NS Record
if($_GET['type'] ==11)
{

$db->delete('dns',$_GET['dnsid'],'dnssetid');

$global->redirect('editnsrecords.php?id='.$_GET['id']);	
}



// delete DNS SPF Record
if($_GET['type'] ==12)
{

$db->delete('dns',$_GET['dnsid'],'dnssetid');

$global->redirect('editspfrecords.php?id='.$_GET['id']);	
}


// delete DNS SRV Record
if($_GET['type'] ==13)
{

$db->delete('dns',$_GET['dnsid'],'dnssetid');

$global->redirect('editsrvrecords.php?id='.$_GET['id']);	
}


// delete DNS TXT Record
if($_GET['type'] ==14)
{

$db->delete('dns',$_GET['dnsid'],'dnssetid');

$global->redirect('edittxtrecords.php?id='.$_GET['id']);	
}


// delete DNS Zone Record
if($_GET['type'] ==15)
{

$db->delete('dnsmanager',$_GET['id'],'dnsid');

$db->delete('dns',$_GET['id'],'dnsid');

$delete['serialkey']= $config['serialkey'];
$global->curlUsingGet('http://'.$system['systemip'].':'.$system['panelport'].'/API/new_dns.php',$delete);


$global->redirect('dnsmanager.php');	
}