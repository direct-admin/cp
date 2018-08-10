<?php include ('library/autoload.php');
include('include/sessioncheck.php');
include('include/header.php'); 

if(isset($_GET['id']))
{
	$data = $db->fetchOne("Select * from ftpuser where ftpid=:ftpid", array(":ftpid"=>$global->clean_input($_GET['id'])));
}


?>

<div id="page-wrapper">
            <div class="row">
                <div class="col-lg-12">
                
                    <h1 class="page-header"> <?php echo !isset($_GET['id']) ? ADD_NEW_FTP_USER : EDIT_FTP_USER ?></h1>
                </div>
                <!-- /.col-lg-12 -->
            </div>
            <!-- /.row -->
            <div class="row">
             <div class="col-lg-12">
 
 
                    <div class="panel panel-default">
  <div class="panel-heading">
  
     <?php echo !isset($_GET['id']) ? ADD_NEW_FTP_USER : EDIT_FTP_USER ?>
  
  
  <div class="pull-right">
                                <div class="btn-group">
                                    <button type="button" class="btn btn-default btn-xs dropdown-toggle" data-toggle="dropdown">
                                        Actions
                                        <span class="caret"></span>
                                    </button>
                                    <ul class="dropdown-menu pull-right" role="menu">
                                        <li><a href="ftpuser.php"><?php echo MANAGE_FTP_USERS  ?></a>
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
$message = $valid->RequiredData(array("ftpuser" =>FTP_USER,"password" =>MAILBOX_PASSWORD,"homedir"=>HOME_DIRECTORY));
$message = $valid->AlphaNumeric(array("ftpuser" =>FTP_USER));
$message = $valid->ValidationErrors();


if(!empty($message)) { echo '<div class="alert alert-danger"><i class="fa fa-ban-circle"></i>'.$message.'</div>';}

else
{

if(isset($_GET['id']))
{
$olduser =$data['ftpuser'];
$updated= $global->post2array($_POST);
$db->update('ftpuser',$updated,$_GET['id'],'ftpid');


$domainpath = $db->fetchOne("Select www_path from domain where domain_name=':domain_name'", array(":domain_name"=>$_POST['domain']));

$updated['proftpd'] = $encrypt->encode($system['proftpd_access']);
$updated['homedir'] = $domainpath.$_POST['homedir'];
$updated['oldftpuser']=$olduser;
$updated['serialkey']= $config['serialkey'];
$global->curlUsingPost('http://'.$system['systemip'].':'.$system['panelport'].'/API/update_ftpuser_api.php',$updated);

echo '<div class="alert alert-info"><i class="fa fa-ok-sign"></i><strong>'.HEADSUP.'</strong>&nbsp;&nbsp;'.ONE_RECORD_UPDATED.'</a></div>';

$data = $db->fetchOne("Select * from ftpuser where ftpid='".$_GET['id']."'");

}


else
{
	
$ftpexist = $db->fetchOne("Select * from ftpuser where ftpuser=':ftpuser'", array(":ftpuser"=>$_POST['ftpuser']));

if(empty($ftpexist))
{
$inserted=$global->post2array($_POST);
$db->insert('ftpuser',$inserted);

$domainpath = $db->fetchOne("Select www_path from domain where domain_name=':domain_name'", array(":domain_name"=>$_POST['domain']));

$inserted['proftpd'] = $encrypt->encode($system['proftpd_access']);
$inserted['homedir'] = $domainpath.$_POST['homedir'];
$inserted['serialkey']= $config['serialkey'];

$global->curlUsingPost('http://'.$system['systemip'].':'.$system['panelport'].'/API/new_ftpuser_api.php',$inserted);


echo '<div class="alert alert-success"><i class="fa fa-ok-sign"></i><strong>'.WELLDONE.'</strong>&nbsp;&nbsp;'.ONE_RECORD_SAVED.'</a></div>';
}
else
{
	echo '<div class="alert alert-danger"><i class="fa fa-ban-circle"></i><strong>'.SORRY.'</strong>&nbsp;&nbsp;'.FTP_USER_EXIST.'</div>';	
	
}

}

}
}


?>


         
  
  
  <?php
  
$domains = $db->fetchAll("SELECT * FROM  `domains` where type=0");

$fieldarray = array(

array("fieldname" => "ftpuser","fielddesc" =>FTP_USER,"fieldtype" => "selectgroup","fieldplaceholder" =>FTP_USER_PLACEHOLDER,"fieldvalue" =>isset($_GET['id']) ? $data['ftpuser']:"","data-required"=>"true","data-type"=>"","validator"=>"","selectgroup"=>$domains,"selectgroupvaluefield"=>"domain_name","selectgrouptextfield"=>"domain_name","selectgroupfieldname"=>"domain","prepend"=>"@"),

array("fieldname" => "password","fielddesc" => MAILBOX_PASSWORD,"fieldtype" => "password","fieldplaceholder" =>LOGIN_PASSWORD_PLACEHOLDER,"fieldvalue" => isset($_GET['id']) ? $data['password']:"","data-type" => "","data-required" => "true","validator" => "data-minlength='6'"),
array("fieldname" => "homedir","fielddesc" => HOME_DIRECTORY . " (" . FTP_HOME_DIR_START .")","fieldtype" => "text","fieldplaceholder" =>HOME_DIRECTORY_PLACEHOLDER,"fieldvalue" => isset($_GET['id']) ? $data['homedir']:"/","data-type" => "","data-required" => "true","validator" => "")
);

$buttonarray = array ( array("buttontype" => "submit","buttoncss" => "btn btn-success","buttonname" => (!isset($_GET['id'])) ? SAVE : UPDATE),
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
        
        
