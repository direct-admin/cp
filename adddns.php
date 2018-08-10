<?php include ('library/autoload.php');
include('include/sessioncheck.php');
include('include/header.php'); 
?>

<div id="page-wrapper">
            <div class="row">
                <div class="col-lg-12">
                
                    <h1 class="page-header"> <?php echo ADD_NEW_DNS ?></h1>
                </div>
                <!-- /.col-lg-12 -->
            </div>
            <!-- /.row -->
            <div class="row">
             <div class="col-lg-12">
 
 
                    <div class="panel panel-default">
  <div class="panel-heading">
  
     <?php echo ADD_NEW_DNS ?>
  
  
  <div class="pull-right">
                                <div class="btn-group">
                                    <button type="button" class="btn btn-default btn-xs dropdown-toggle" data-toggle="dropdown">
                                        Actions
                                        <span class="caret"></span>
                                    </button>
                                    <ul class="dropdown-menu pull-right" role="menu">
                                        <li><a href="dnsmanager.php"><?php echo MANAGE_DNS  ?></a>
                                        </li>
                                        
                                      
                                        
                                    </ul>
                                </div>
                            </div>

  </div>
                    
                    <div class="panel-body">
                    
                    
                                
<?php

if($_SERVER['REQUEST_METHOD'] == 'POST')
{
$valid = new FormValidation($_POST);
$message = $valid->RequiredData(array("domainid" =>SELECT_DOMAIN));
$message = $valid->ValidationErrors();


if(!empty($message)) { echo '<div class="alert alert-danger"><i class="fa fa-ban-circle"></i>'.$message.'</div>';}

else
{
	
$dnsexist = $db->fetchOne("Select * from dnsmanager where domainid=:domainid", array(":domainid"=>$global->clean_input($_POST['domainid'])));

if(empty($dnsexist))
{

$domain_name = $db->fetchOne("SELECT * FROM  `domains` where type=0 and domainid=:domainid", array(":domainid"=>$global->clean_input($_POST['domainid'])));

$inserted=$global->post2array($_POST);
$inserted['domain_name'] = $domain_name['domain_name'];
$db->insert('dnsmanager',$inserted);

$dnsmanager = $db->fetchOne("SELECT * FROM  `dnsmanager` where domainid=:domainid", array(":domainid"=>$global->clean_input($_POST['domainid'])));

// First A Record
$adns['domainid'] = $global->clean_input($_POST['domainid']);
$adns['dnsid'] = $global->clean_input($dnsmanager['dnsid']);
$adns['dns_type'] = 'A';
$adns['dns_host'] = '@';
$adns['dns_ttl'] = '3600';
$adns['dns_target'] = $system['systemip'];
$db->insert('dns',$adns);

// Second A Record
$adns['domainid'] = $global->clean_input($_POST['domainid']);
$adns['dnsid'] = $global->clean_input($dnsmanager['dnsid']);
$adns['dns_type'] = 'A';
$adns['dns_host'] = 'mail';
$adns['dns_ttl'] = '86400';
$adns['dns_target'] = $system['systemip'];
$db->insert('dns',$adns);


// Third A Record
$adns['domainid'] = $global->clean_input($_POST['domainid']);
$adns['dnsid'] = $global->clean_input($dnsmanager['dnsid']);
$adns['dns_type'] = 'A';
$adns['dns_host'] = 'ns1';
$adns['dns_ttl'] = '172800';
$adns['dns_target'] = $system['systemip'];
$db->insert('dns',$adns);


// Fourth A Record
$adns['domainid'] = $global->clean_input($_POST['domainid']);
$adns['dnsid'] = $global->clean_input($dnsmanager['dnsid']);
$adns['dns_type'] = 'A';
$adns['dns_host'] = 'ns2';
$adns['dns_ttl'] = '172800';
$adns['dns_target'] = $system['systemip'];
$db->insert('dns',$adns);



// First CNAME Record
$cdns['domainid'] = $global->clean_input($_POST['domainid']);
$cdns['dnsid'] = $global->clean_input($dnsmanager['dnsid']);
$cdns['dns_type'] = 'CNAME';
$cdns['dns_host'] = 'www';
$cdns['dns_ttl'] = '3600';
$cdns['dns_target'] = '@';
$db->insert('dns',$cdns);

// Second CNAME Record
$cdns['domainid'] = $global->clean_input($_POST['domainid']);
$cdns['dnsid'] = $global->clean_input($dnsmanager['dnsid']);
$cdns['dns_type'] = 'CNAME';
$cdns['dns_host'] = 'ftp';
$cdns['dns_ttl'] = '3600';
$cdns['dns_target'] = '@';
$db->insert('dns',$cdns);


// First MX Record
$mdns['domainid'] = $global->clean_input($_POST['domainid']);
$mdns['dnsid'] = $global->clean_input($dnsmanager['dnsid']);
$mdns['dns_type'] = 'MX';
$mdns['dns_host'] = '@';
$mdns['dns_ttl'] = '86400';
$mdns['dns_target'] = 'mail.'. $domain_name['domain_name'];
$mdns['dns_priority'] = '10';
$db->insert('dns',$mdns);


// First NS Record
$ndns['domainid'] = $global->clean_input($_POST['domainid']);
$ndns['dnsid'] = $global->clean_input($dnsmanager['dnsid']);
$ndns['dns_type'] = 'NS';
$ndns['dns_host'] = '@';
$ndns['dns_ttl'] = '172800';
$ndns['dns_target'] = 'ns1.'. $domain_name['domain_name'];
$db->insert('dns',$ndns);

// Second NS Record
$ndns['domainid'] = $global->clean_input($_POST['domainid']);
$ndns['dnsid'] = $global->clean_input($dnsmanager['dnsid']);
$ndns['dns_type'] = 'NS';
$ndns['dns_host'] = '@';
$ndns['dns_ttl'] = '172800';
$ndns['dns_target'] = 'ns2.'. $domain_name['domain_name'];
$db->insert('dns',$ndns);

$inserted['serialkey']= $config['serialkey'];
$global->curlUsingPost('http://'.$system['systemip'].':'.$system['panelport'].'/API/new_dns.php',$inserted);


echo '<div class="alert alert-success"><i class="fa fa-ok-sign"></i><strong>'.WELLDONE.'</strong>&nbsp;&nbsp;'.DNS_SETTINGS_GENRATED.'</a></div>';
}
else
{
echo '<div class="alert alert-danger"><i class="fa fa-ban-circle"></i><strong>'.SORRY.'</strong>&nbsp;&nbsp;'.DNS_SETTING_ALREADY_EXIST.'</div>';	
	
}



}
}


?>
  
<?php

echo '<div class="alert alert-info"><i class="fa fa-ok-sign"></i><strong>&nbsp;&nbsp;'.DNS_SAVE_NOTIFICATION.'</strong></a></div>';


$domains = $db->fetchAll("SELECT * FROM  `domains` where type=0");


$fieldarray = array(

array("fieldname" => "domainid","fielddesc" =>SELECT_DOMAIN,"fieldtype" => "select","fielddefaultvalue" =>$domains, "fieldvalue"=> "domainid", "fieldvaluedesc"=> "domain_name","data-required"=>"true", "selectedvalue"=>"")

);

$buttonarray = array ( array("buttontype" => "submit","buttoncss" => "btn btn-success","buttonname" => (!isset($_GET['id'])) ? GENERATE_DNS_SETTINGS : GENERATE_DNS_SETTINGS),
array("buttontype" => "reset","buttoncss" => "btn btn-default","buttonname" => RESET)
);


$formobj->AddFields($fieldarray);

$formobj->AddButtons($buttonarray);

echo $formobj->GenrateForm();

?> 

                       
                        
                     
                    </div>
                  
                
              </div>   
               
                
            </div>

        </div>
        
        <?php include 'include/footer.php' ?>
        
        
