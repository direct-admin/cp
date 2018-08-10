<?php include ('library/autoload.php');
include('include/sessioncheck.php');
include('include/header.php'); 

if(isset($_GET['id']))
{
	
	$data = $db->fetchOne("Select * from mailboxes where mailboxid=:mailboxid", array(":mailboxid"=>$global->clean_input($_GET['id'])));
}


?>

<div id="page-wrapper">
            <div class="row">
                <div class="col-lg-12">
                
                    <h1 class="page-header"> <?php echo !isset($_GET['id']) ? ADD_NEW_MAILBOX : CHANGE_PASSWORD_MAILBOX ?></h1>
                </div>
                <!-- /.col-lg-12 -->
            </div>
            <!-- /.row -->
            <div class="row">
             <div class="col-lg-12">
 
 
                    <div class="panel panel-default">
  <div class="panel-heading">
  
     <?php echo !isset($_GET['id']) ? ADD_NEW_MAILBOX : CHANGE_PASSWORD_MAILBOX ?>
  
  
  <div class="pull-right">
                                <div class="btn-group">
                                    <button type="button" class="btn btn-default btn-xs dropdown-toggle" data-toggle="dropdown">
                                        Actions
                                        <span class="caret"></span>
                                    </button>
                                    <ul class="dropdown-menu pull-right" role="menu">
                                        <li><a href="mailbox.php"><?php echo MANAGE_MAILBOXES  ?></a>
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
$message = $valid->RequiredData(array("mailboxname" =>MAILBOX_NAME,"password" =>MAILBOX_PASSWORD));
$message = $valid->AlphaNumeric(array("mailboxname" =>MAILBOX_NAME));
$message = $valid->ValidationErrors();



if(!empty($message)) { echo '<div class="alert alert-danger"><i class="fa fa-ban-circle"></i>'.$message.'</div>';}

else
{

if(isset($_GET['id']))
{
	
$updated['password']=$_POST['password'];
$db->update('mailboxes',$updated,$_GET['id'],'mailboxid');

$updated['mailboxname']=$data['mailboxname'];
$updated['postfix'] = $encrypt->encode($system['postfix_access']);
$updated['serialkey']= $config['serialkey'];
$global->curlUsingPost('http://'.$system['systemip'].':'.$system['panelport'].'/API/update_mailbox_api.php',$updated);

echo '<div class="alert alert-info"><i class="fa fa-ok-sign"></i><strong>'.HEADSUP.'</strong>&nbsp;&nbsp;'.ONE_RECORD_UPDATED.'</a></div>';
}


else
{
	
$mailboxexist = $db->fetchOne("Select * from mailboxes where mailboxname=:mailboxname", array(":mailboxname"=>$_POST['mailboxname']));

if(empty($mailboxexist))
{
$inserted=$global->post2array($_POST);
$db->insert('mailboxes',$inserted);
$inserted['postfix'] = $encrypt->encode($system['postfix_access']);
$inserted['serialkey']= $config['serialkey'];
$global->curlUsingPost('http://'.$system['systemip'].':'.$system['panelport'].'/API/new_mailbox_api.php',$inserted);


echo '<div class="alert alert-success"><i class="fa fa-ok-sign"></i><strong>'.WELLDONE.'</strong>&nbsp;&nbsp;'.ONE_RECORD_SAVED.'</a></div>';
}
else
{
	echo '<div class="alert alert-danger"><i class="fa fa-ban-circle"></i><strong>'.SORRY.'</strong>&nbsp;&nbsp;'.MAILBOX_EXIST.'</div>';	
	
}

}

}
}


?>


         
  
  
<?php

$domains = $db->fetchAll("SELECT * FROM  `domains` where type=0");

$fieldarray = array(

array("fieldname" => "mailboxname","fielddesc" =>MAILBOX_NAME,"fieldtype" => "selectgroup","fieldplaceholder" =>MAILBOX_PLACEHOLDER,"fieldvalue" =>isset($_GET['id']) ? $data['mailboxname']:"","data-required"=>"true","data-type"=>"","validator"=>"","selectgroup"=>$domains,"selectgroupvaluefield"=>"domain_name","selectgrouptextfield"=>"domain_name","selectgroupfieldname"=>"domain","prepend"=>"@"),

array("fieldname" => "password","fielddesc" => MAILBOX_PASSWORD,"fieldtype" => "password","fieldplaceholder" =>LOGIN_PASSWORD_PLACEHOLDER,"fieldvalue" => "","data-type" => "","data-required" => "true","validator" => "data-minlength='6'")
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
        
        
