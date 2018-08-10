<?php include ('library/autoload.php');
include('include/sessioncheck.php');
include('include/header.php'); 
?>

<div id="page-wrapper">
            <div class="row">
                <div class="col-lg-12">
                
                    <h1 class="page-header"> <?php echo EDIT_SETTINGS ?></h1>
                </div>
                <!-- /.col-lg-12 -->
            </div>
            <!-- /.row -->
            <div class="row">
             <div class="col-lg-12">
 
 
                    <div class="panel panel-default">
  <div class="panel-heading">
  
     <?php echo EDIT_SETTINGS ?>
  

  </div>
                    
                    <div class="panel-body">
                    
                    
                                
<?php

if($_SERVER['REQUEST_METHOD'] == 'POST')
{
$valid = new FormValidation($_POST);
$message = $valid->RequiredData(array("emailid" =>ADMIN_EMAIL_ID,"defaultadminlang" =>DEFAULT_ADMIN_LANGUAGE_FILE,"dateformat" =>SHORT_DATE_FORMAT,"datetimeformat" =>FULL_DATE_FORMAT,"rowsperpage" =>ROWS_PER_PAGE,"failedlogintry" =>FAILED_LOGIN_TRY_COUNT));
$message = $valid->EmailCheck(array("emailid" =>ADMIN_EMAIL_ID));
$message = $valid->ValidationErrors();


if(!empty($message)) { echo '<div class="alert alert-danger"><i class="fa fa-ban-circle"></i>'.$message.'</div>';}

else
{

$updated = $global->post2array($_POST);	

$db->update('settings',$updated,"1","id");

echo '<div class="alert alert-success"><i class="fa fa-ok-sign"></i><strong>'.WELLDONE.'</strong>&nbsp;&nbsp;'.ONE_RECORD_SAVED.'</a></div>';

$config = $db->fetchOne('Select * from settings where id=1');

}
}


$fieldarray = array(array("fieldname" => "emailid","fielddesc" =>ADMIN_EMAIL_ID,"fieldtype" => "email","fieldplaceholder" =>PLACEHOLDER,"fieldvalue" =>$config['emailid'],"data-required"=>"true","data-type"=>"","validator"=>""),

array("fieldname" => "defaultadminlang","fielddesc" =>DEFAULT_ADMIN_LANGUAGE_FILE,"fieldtype" => "text","fieldplaceholder" =>PLACEHOLDER,"fieldvalue" =>$config['defaultadminlang'],"data-required"=>"true","data-type"=>"","validator"=>""),

array("fieldname" => "dateformat","fielddesc" =>SHORT_DATE_FORMAT,"fieldtype" => "text","fieldplaceholder" =>PLACEHOLDER,"fieldvalue" =>$config['dateformat'],"data-required"=>"true","data-type"=>"","validator"=>""),

array("fieldname" => "datetimeformat","fielddesc" =>FULL_DATE_FORMAT,"fieldtype" => "text","fieldplaceholder" =>PLACEHOLDER,"fieldvalue" =>$config['datetimeformat'],"data-required"=>"true","data-type"=>"","validator"=>""),


array("fieldname" => "rowsperpage","fielddesc" =>ROWS_PER_PAGE,"fieldtype" => "text","fieldplaceholder" =>PLACEHOLDER,"fieldvalue" =>$config['rowsperpage'],"data-required"=>"true","data-type"=>"","validator"=>""),


array("fieldname" => "failedlogintry","fielddesc" =>FAILED_LOGIN_TRY_COUNT,"fieldtype" => "text","fieldplaceholder" =>PLACEHOLDER,"fieldvalue" =>$config['failedlogintry'],"data-required"=>"true","data-type"=>"","validator"=>""),

);

$buttonarray = array ( array("buttontype" => "submit","buttoncss" => "btn btn-success","buttonname" => UPDATE),
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
        
        
