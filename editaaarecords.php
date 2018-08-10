<?php include ('library/autoload.php');
include('include/sessioncheck.php');
include('include/header.php'); 

$dnsmanager = $db->fetchOne("Select * from dnsmanager where dnsid =:dnsid", array(":dnsid"=>$global->clean_input($_GET['id'])));

$data = $db->fetchOne("Select * from dns where dnsid =':dnsid'", array(":dnsid"=>$global->clean_input($_GET['id'])));


if(empty($dnsmanager))
{
	
echo "<script>alert('".NO_RECORDS_FOUND."');</script>";

$global->redirect("dnsmanager.php");	
}


?>

<div id="page-wrapper">
            <div class="row">
                <div class="col-lg-12">
                
                    <h1 class="page-header"> <?php echo EDIT_AAA_RECORDS . $dnsmanager['domain_name']; ?></h1>
                </div>
                <!-- /.col-lg-12 -->
            </div>
            <!-- /.row -->
            <div class="row">
             <div class="col-lg-12">
 
 
                    <div class="panel panel-default">
  <div class="panel-heading">
  
     <?php echo EDIT_AAA_RECORDS . $dnsmanager['domain_name']; ?>
  
  
  <div class="pull-right">
                                <div class="btn-group">
                                    <button type="button" class="btn btn-default btn-xs dropdown-toggle" data-toggle="dropdown">
                                        Actions
                                        <span class="caret"></span>
                                    </button>
                                    <ul class="dropdown-menu pull-right" role="menu">
                                        <li><a href="dnsmanager.php"><?php echo DNS  ?></a></li>
                                        <li role="separator" class="divider"></li>
                                        <li><a href="editarecords.php?id=<?php echo $dnsmanager['dnsid']  ?>"><?php echo MENU_EDIT_A_RECORDS  ?></a></li>
                                        <li><a href="editaaarecords.php?id=<?php echo $dnsmanager['dnsid']  ?>"><?php echo MENU_EDIT_AAA_RECORDS  ?></a></li>
                                        <li><a href="editcnamerecords.php?id=<?php echo $dnsmanager['dnsid']  ?>"><?php echo MENU_EDIT_CNAME_RECORDS  ?></a></li>
                                        <li><a href="editmxrecords.php?id=<?php echo $dnsmanager['dnsid']  ?>"><?php echo MENU_EDIT_MX_RECORDS  ?></a></li>
                                        <li><a href="edittxtrecords.php?id=<?php echo $dnsmanager['dnsid']  ?>"><?php echo MENU_EDIT_TXT_RECORDS  ?></a></li>
                                        <li><a href="editsrvrecords.php?id=<?php echo $dnsmanager['dnsid']  ?>"><?php echo MENU_EDIT_SRV_RECORDS  ?></a></li>
                                        <li><a href="editspfrecords.php?id=<?php echo $dnsmanager['dnsid']  ?>"><?php echo MENU_EDIT_SPF_RECORDS  ?></a></li>
                                        <li><a href="editnsrecords.php?id=<?php echo $dnsmanager['dnsid']  ?>"><?php echo MENU_EDIT_NS_RECORDS  ?></a></li>
                                        
                                      
                                        
                                    </ul>
                                </div>
                            </div>

  </div>
                    
                    <div class="panel-body">
                    
                                
<?php

if($_SERVER['REQUEST_METHOD'] == 'POST')
{
	
$valid = new FormValidation($_POST);
$message = $valid->RequiredData(array("dns_host" =>A_HOST_NAME,"dns_ttl" =>A_TTL,"dns_target"=>A_TARGET));
$message = $valid->IPV4_IPV6(array("dns_target"=>A_TARGET),"IPV6");
$message = $valid->ValidationErrors();


if(!empty($message)) { echo '<div class="alert alert-danger"><i class="fa fa-ban-circle"></i>'.$message.'</div>';}

else
{

if(isset($_GET['id']))
{
	
$inserted= $global->post2array($_POST);
$inserted['domainid'] = $dnsmanager['domainid'];
$inserted['dnsid'] = $dnsmanager['dnsid'];
$inserted['dns_type'] = "AAA";

$db->insert('dns',$inserted);

$dnsinsert['serialkey']= $config['serialkey'];
$dnsinsert['dnsid'] = $dnsmanager['dnsid'];
$global->curlUsingPost('http://'.$system['systemip'].':'.$system['panelport'].'/API/edit_dns_zones.php',$dnsinsert);

echo '<div class="alert alert-info"><i class="fa fa-ok-sign"></i><strong>'.HEADSUP.'</strong>&nbsp;&nbsp;'.ONE_RECORD_UPDATED.'</a></div>';

}




}
}


?>
<?php

echo '<div class="alert alert-info"><i class="fa fa-ok-sign"></i><strong>&nbsp;&nbsp;'.DNS_SAVE_NOTIFICATION.'</strong></a></div>';

echo '<p>'.AAA_NOTIFICATION.'</p>';  
  
$fieldarray = array(

array("fieldname" => "dns_host","fielddesc" => A_HOST_NAME,"fieldtype" => "text","fieldplaceholder" =>A_HOST_PLACEHOLDER,"fieldvalue" =>"","data-type" => "","data-required" => "true","validator" => ""),

array("fieldname" => "dns_ttl","fielddesc" => A_TTL,"fieldtype" => "text","fieldplaceholder" =>A_TTL_PLACEHOLDER,"fieldvalue" =>"86400","data-type" => "","data-required" => "true","validator" => ""),

array("fieldname" => "dns_target","fielddesc" => A_TARGET,"fieldtype" => "text","fieldplaceholder" =>A_TARGET_PLACEHOLDER,"fieldvalue" =>"","data-type" => "","data-required" => "true","validator" => "")




);

$buttonarray = array ( array("buttontype" => "submit","buttoncss" => "btn btn-success","buttonname" => ADD_NEW_RECORD)
);


$formobj->AddFields($fieldarray);

$formobj->AddButtons($buttonarray);

echo $formobj->GenrateForm();

?> 

                       
                        
                     
                    </div>
                  
                
              </div>  
              
              
              
<!--  Showing A Records below -->
              
              
              
              <div class="panel panel-default">
  <div class="panel-heading">
  
     <?php echo AAA_DNS_RECORDS . $dnsmanager['domain_name']; ?>
  
  
  <div class="pull-right">
                                <div class="btn-group">
                                    <button type="button" class="btn btn-default btn-xs dropdown-toggle" data-toggle="dropdown">
                                        Actions
                                        <span class="caret"></span>
                                    </button>
                                    <ul class="dropdown-menu pull-right" role="menu">
                                        <li><a href="dnsmanager.php"><?php echo DNS  ?></a>
                                        </li>
                                        
                                      
                                        
                                    </ul>
                                </div>
                            </div>

  </div>
                    
                    <div class="panel-body">
                    

         
  
   <?php
// how many rows to show per page
$rowsPerPage = $config['rowsperpage'];

// by default we show first page
$pageNum = 1;

// if $_GET['page'] defined, use it as page number
if(isset($_GET['page']))
{
$pageNum = filter_var($_GET['page'], FILTER_SANITIZE_ENCODED);
}

// counting the offset
$offset = ($pageNum - 1) * $rowsPerPage;

$self = $_SERVER['PHP_SELF'];

$numrows = $db->fetchOne('Select count(*) as nums from dns where dns_type="AAA" and dnsid=:dnsid', array(":dnsid"=>$global->clean_input($_GET['id'])));
$result = $db->fetchAll("Select * from dns where dns_type='AAA' and dnsid= :dnsid  order by dnssetid asc LIMIT ".$global->clean_pager($offset).", ".$global->clean_pager($rowsPerPage),array(":dnsid"=>$global->clean_input($_GET['id']))); 


$maxPage = ceil($numrows['nums']/$rowsPerPage);
                 
$crud = new TableCrud($result);

$crud->AddHeaders(array(A_HOST_NAME,A_TTL,A_TARGET,ACTIONS));

$crud->Table_Columns(array("dns_host","dns_ttl","dns_target","action"));

$crud->AddActionLinks(array(array("linkdesc" =>"Delete", "linkfile" => "delete.php", "linkparam" =>"dnssetid", "linkalias" => "dnsid", "linkcss" => "btn btn-danger", "linkicon" => "<i class='fa fa-trash-o'></i>", "target"=>"_self", "moreparams"=>"&type=8&id=".$global->clean_input($_GET['id']))));

echo $crud->GenrateTable();

echo $crud->Pagination($maxPage,$self);                 
              
?>  
  
  



                       
                        
                     
                    </div>
                  
                
              </div>
              
              
               
               
                
            </div>

        </div>
        
        <?php include 'include/footer.php' ?>
        
        
