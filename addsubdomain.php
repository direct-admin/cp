<?php include ('library/autoload.php');
include('include/sessioncheck.php');
include('include/header.php'); 
?>

<div id="page-wrapper">
            <div class="row">
                <div class="col-lg-12">
                
                    <h1 class="page-header"> <?php echo ADD_NEW_SUBDOMAIN ?></h1>
                </div>
                <!-- /.col-lg-12 -->
            </div>
            <!-- /.row -->
            <div class="row">
             <div class="col-lg-12">
 
 
                    <div class="panel panel-default">
  <div class="panel-heading">
  
     <?php echo ADD_NEW_SUBDOMAIN ?>
  
  
  <div class="pull-right">
                                <div class="btn-group">
                                    <button type="button" class="btn btn-default btn-xs dropdown-toggle" data-toggle="dropdown">
                                        Actions
                                        <span class="caret"></span>
                                    </button>
                                    <ul class="dropdown-menu pull-right" role="menu">
                                        <li><a href="subdomains.php"><?php echo MANAGE_ALL_SUBDOMAINS  ?></a>
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
$message = $valid->RequiredData(array("subname" =>SUB_DOMAIN_NAME));
$message = $valid->ValidName(array("subname" =>SUB_DOMAIN_NAME));
$message = $valid->ValidationErrors();


if(!empty($message)) { echo '<div class="alert alert-danger"><i class="fa fa-ban-circle"></i>'.$message.'</div>';}

else
{
	
$subdomain = $_POST['subname'] . "." . $_POST['domain_name'];
	
$dbexist = $db->fetchOne("Select * from subdomains where subname=':subname'", array(":subname"=>$_POST['subname']));

if(empty($dbexist))
{
$file_handler = new DirFileHandler();

$domain_dir = "/var/www/html/". str_replace(".","_",$subdomain);

if(!$file_handler->CheckFolderExists($domain_dir))
{

$inserted=$global->post2array($_POST);
$inserted['www_path'] = $domain_dir;
$db->insert('subdomains',$inserted);
$inserted['serialkey']= $config['serialkey'];
$global->curlUsingPost('http://'.$system['systemip'].':'.$system['panelport'].'/API/vhost_domain.php',$inserted);

$file_handler->CreateDirectory($domain_dir);

echo '<div class="alert alert-success"><i class="fa fa-ok-sign"></i><strong>'.WELLDONE.'</strong>&nbsp;&nbsp;'.ONE_RECORD_SAVED.'</a></div>';

}
else
{
echo '<div class="alert alert-danger"><i class="fa fa-ok-sign"></i><strong>'.SORRY.'</strong>&nbsp;&nbsp;'.DOMAIN_DIR_ALREADY_EXIST.'</a></div>';
	
}

}
else
{
echo '<div class="alert alert-danger"><i class="fa fa-ban-circle"></i><strong>'.SORRY.'</strong>&nbsp;&nbsp;'.DOMAIN_ALREADY_EXIST.'</div>';	
	
}



}
}


?>


         
  
  
  <?php
  
$domains = $db->fetchAll("SELECT * FROM  `domains` where type=0");

$fieldarray = array(

array("fieldname" => "subname","fielddesc" =>SUB_DOMAIN_NAME,"fieldtype" => "selectgroup","fieldplaceholder" =>SUB_DOMAIN_NAME_PLACEHOLDER,"fieldvalue" =>"","data-required"=>"true","data-type"=>"","validator"=>"","selectgroup"=>$domains,"selectgroupvaluefield"=>"domain_name","selectgrouptextfield"=>"domain_name","selectgroupfieldname"=>"domain_name","prepend"=>".")
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
        
        
