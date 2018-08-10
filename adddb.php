<?php include ('library/autoload.php');
include('include/sessioncheck.php');
include('include/header.php'); 
?>

<div id="page-wrapper">
            <div class="row">
                <div class="col-lg-12">
                
                    <h1 class="page-header"> <?php echo ADD_NEW_DB ?></h1>
                </div>
                <!-- /.col-lg-12 -->
            </div>
            <!-- /.row -->
            <div class="row">
             <div class="col-lg-12">
 
 
                    <div class="panel panel-default">
  <div class="panel-heading">
  
     <?php echo ADD_NEW_DB ?>
  
  
  <div class="pull-right">
                                <div class="btn-group">
                                    <button type="button" class="btn btn-default btn-xs dropdown-toggle" data-toggle="dropdown">
                                        Actions
                                        <span class="caret"></span>
                                    </button>
                                    <ul class="dropdown-menu pull-right" role="menu">
                                        <li><a href="mysqldb.php"><?php echo MANAGE_MYSQLDB  ?></a>
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
$message = $valid->RequiredData(array("dbname" =>DB_NAME));
$message = $valid->ValidName(array("dbname" =>DB_NAME));
$message = $valid->ValidationErrors();


if(!empty($message)) { echo '<div class="alert alert-danger"><i class="fa fa-ban-circle"></i>'.$message.'</div>';}

else
{
	
$dbexist = $db->fetchOne("Select * from mysqldb where dbname=':dbname'", array(":dbname"=>$global->clean_input($_POST['dbname'])));

if(empty($dbexist))
{
$inserted=$global->post2array($_POST);
$db->insert('mysqldb',$inserted);

$db->execute('Create database  '. $global->clean_input($_POST['dbname']) . ";");

echo '<div class="alert alert-success"><i class="fa fa-ok-sign"></i><strong>'.WELLDONE.'</strong>&nbsp;&nbsp;'.ONE_RECORD_SAVED.'</a></div>';
}
else
{
echo '<div class="alert alert-danger"><i class="fa fa-ban-circle"></i><strong>'.SORRY.'</strong>&nbsp;&nbsp;'.MYSQL_DB_EXIST.'</div>';	
	
}



}
}


?>


         
  
  
  <?php

$fieldarray = array(

array("fieldname" => "dbname","fielddesc" =>DB_NAME,"fieldtype" => "text","fieldplaceholder" =>DB_NAME_PLACEHOLDER,"fieldvalue" =>"","data-required"=>"true","data-type"=>"","validator"=>"")
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
        
        
