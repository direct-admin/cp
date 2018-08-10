<?php include ('library/autoload.php');
include('include/sessioncheck.php');
include('include/header.php'); 
?>

<div id="page-wrapper">
            <div class="row">
                <div class="col-lg-12">
                
                    <h1 class="page-header"> <?php echo ADD_MYSQL_USER ?></h1>
                </div>
                <!-- /.col-lg-12 -->
            </div>
            <!-- /.row -->
            <div class="row">
             <div class="col-lg-12">
 
 
                    <div class="panel panel-default">
  <div class="panel-heading">
  
     <?php echo ADD_MYSQL_USER ?>
  
  
  <div class="pull-right">
                                <div class="btn-group">
                                    <button type="button" class="btn btn-default btn-xs dropdown-toggle" data-toggle="dropdown">
                                        Actions
                                        <span class="caret"></span>
                                    </button>
                                    <ul class="dropdown-menu pull-right" role="menu">
                                        <li><a href="mysqlusers.php"><?php echo MANAGE_MYSQL_USERS  ?></a>
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
$message = $valid->RequiredData(array("dbname" =>MYSQL_DB_NAME,"username" =>MYSQL_USER_NAME,"password" =>MYSQL_MYSQL_PASSWORD));
$message = $valid->ValidName(array("username" =>MYSQL_USER_NAME));
$message = $valid->ValidationErrors();


if(!empty($message)) { echo '<div class="alert alert-danger"><i class="fa fa-ban-circle"></i>'.$message.'</div>';}

else
{
	
$userexist = $db->fetchOne("Select * from mysqlusers where username=':username'",array(":username"=>$global->clean_input($_POST['username'])));

if(empty($userexist))
{
$inserted=$global->post2array($_POST);
$db->insert('mysqlusers',$inserted);

$db->execute("CREATE USER ".$global->clean_input($_POST['username'])."@localhost IDENTIFIED BY '". $_POST['password']."';");

$db->execute('GRANT ALL ON '.$global->clean_input($_POST['dbname']).'.* TO '.$global->clean_input($_POST['username']).'@localhost;');

echo '<div class="alert alert-success"><i class="fa fa-ok-sign"></i><strong>'.WELLDONE.'</strong>&nbsp;&nbsp;'.ONE_RECORD_SAVED.'</a></div>';
}
else
{
echo '<div class="alert alert-danger"><i class="fa fa-ban-circle"></i><strong>'.SORRY.'</strong>&nbsp;&nbsp;'.MYSQL_DB_EXIST.'</div>';	
	
}



}
}


$dbnames = $db->fetchAll("Select dbid,dbname from mysqldb");

$fieldarray = array(array("fieldname" => "dbname","fielddesc" =>MYSQL_DB_NAME,"fieldtype" => "select","fielddefaultvalue" =>$dbnames, "fieldvalue"=> "dbname", "fieldvaluedesc"=> "dbname","data-required"=>"true", "selectedvalue"=>""),
array("fieldname" => "username","fielddesc" =>MYSQL_USER_NAME,"fieldtype" => "text","fieldplaceholder" =>MYSQL_USER_NAME_PLACEHOLDER,"fieldvalue" =>"","data-required"=>"true","data-type"=>"","validator"=>"data-minlength='6'"),
array("fieldname" => "password","fielddesc" => MYSQL_MYSQL_PASSWORD,"fieldtype" => "password","fieldplaceholder" =>MYSQL_PASSWORD_PLACEHOLDER,"fieldvalue" => "","data-type" => "","data-required" => "true","validator" => "data-minlength='6'")
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
        
        
