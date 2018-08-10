<?php include ('library/autoload.php');
include('include/sessioncheck.php');
include('include/header.php'); 
?>

<div id="page-wrapper">
            <div class="row">
                <div class="col-lg-12">
                
                    <h1 class="page-header"> <?php echo CHANGE_PASSWORD ?></h1>
                </div>
                <!-- /.col-lg-12 -->
            </div>
            <!-- /.row -->
            <div class="row">
             <div class="col-lg-12">
 
 
                    <div class="panel panel-default">
  <div class="panel-heading">
  
     <?php echo CHANGE_PASSWORD ?>
  

  </div>
                    
                    <div class="panel-body">
                    
                    
                                
<?php

if($_SERVER['REQUEST_METHOD'] == 'POST')
{
$valid = new FormValidation($_POST);
$message = $valid->RequiredData(array("username" =>PANEL_USERNAME,"oldpassword" =>PANEL_OLD_PASSWORD,"newpassword" =>PANEL_NEW_PASSWORD));
$message = $valid->AlphaNumeric(array("username" =>PANEL_USERNAME));
$message = $valid->ValidationErrors();


if(!empty($message)) { echo '<div class="alert alert-danger"><i class="fa fa-ban-circle"></i>'.$message.'</div>';}

else
{
	
$authid = $db->fetchOne("Select * from auth where authid=1");

if($encrypt->encode($_POST['oldpassword']) == $authid['password'])
{
$updated['password']=$encrypt->encode($_POST['newpassword']);
$db->update('auth',$updated,"1","authid");

echo '<div class="alert alert-success"><i class="fa fa-ok-sign"></i><strong>'.WELLDONE.'</strong>&nbsp;&nbsp;'.ONE_RECORD_SAVED.'</a></div>';
}
else
{
echo '<div class="alert alert-danger"><i class="fa fa-ban-circle"></i><strong>'.SORRY.'</strong>&nbsp;&nbsp;'.INVALID_OLD_PASSWORD.'</div>';	
	
}



}
}


$fieldarray = array(array("fieldname" => "username","fielddesc" =>PANEL_USERNAME,"fieldtype" => "text","fieldplaceholder" =>PANEL_USERNAME_PLACEHOLDER,"fieldvalue" =>"","data-required"=>"true","data-type"=>"","validator"=>"data-minlength='6'"),
array("fieldname" => "oldpassword","fielddesc" => PANEL_OLD_PASSWORD,"fieldtype" => "password","fieldplaceholder" =>PANEL_OLD_PASSWORD_PLACEHOLDER,"fieldvalue" => "","data-type" => "","data-required" => "true","validator" => "data-minlength='6'"),
array("fieldname" => "newpassword","fielddesc" => PANEL_NEW_PASSWORD,"fieldtype" => "password","fieldplaceholder" =>PANEL_NEW_PASSWORD_PLACEHOLDER,"fieldvalue" => "","data-type" => "","data-required" => "true","validator" => "data-minlength='6'")
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
        
        
