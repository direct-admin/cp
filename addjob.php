<?php include ('library/autoload.php');
include('include/sessioncheck.php');
include('include/header.php'); 
$file_handler = new DirFileHandler();

if(isset($_GET['id']))
{
	$data = $db->fetchOne("Select * from cronjobs where jobid=:jobid", array(":jobid"=>$global->clean_input($_GET['id'])));
}


?>

<div id="page-wrapper">
            <div class="row">
                <div class="col-lg-12">
                
                    <h1 class="page-header"> <?php echo !isset($_GET['id']) ? ADD_NEW_CRON_JOB : EDIT_CRON_JOB ?></h1>
                </div>
                <!-- /.col-lg-12 -->
            </div>
            <!-- /.row -->
            <div class="row">
             <div class="col-lg-12">
 
 
                    <div class="panel panel-default">
  <div class="panel-heading">
  
     <?php echo !isset($_GET['id']) ? ADD_NEW_CRON_JOB : EDIT_CRON_JOB ?>
  
  
  <div class="pull-right">
                                <div class="btn-group">
                                    <button type="button" class="btn btn-default btn-xs dropdown-toggle" data-toggle="dropdown">
                                        Actions
                                        <span class="caret"></span>
                                    </button>
                                    <ul class="dropdown-menu pull-right" role="menu">
                                        <li><a href="cronjobs.php"><?php echo MANAGE_CRON_JOBS  ?></a>
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
$message = $valid->RequiredData(array("name" =>CRON_NAME,"script" =>CRON_SCRIPT_PATH,"time"=>CRON_EXECUTION_TIME));
$message = $valid->ValidationErrors();


if(!empty($message)) { echo '<div class="alert alert-danger"><i class="fa fa-ban-circle"></i>'.$message.'</div>';}

else
{

if(isset($_GET['id']))
{

if($file_handler->CheckFileExists($global->clean_input($_POST['script'])))
{

$updated= $global->post2array($_POST);
$db->update('cronjobs',$updated,$global->clean_input($_GET['id']),'jobid');


$updated['serialkey']= $config['serialkey'];
$global->curlUsingPost('http://'.$system['systemip'].':'.$system['panelport'].'/API/cronjob.php',$updated);

echo '<div class="alert alert-info"><i class="fa fa-ok-sign"></i><strong>'.HEADSUP.'</strong>&nbsp;&nbsp;'.ONE_RECORD_UPDATED.'</a></div>';

$data = $db->fetchOne("Select * from cronjobs where jobid=:jobid" , array(":jobid"=>$global->clean_input($_GET['id'])));

}
else
{
	
echo '<div class="alert alert-error"><i class="fa fa-ok-sign"></i><strong>'.FILE_DOES_NOT_EXIST.'</strong></a></div>';		
}


}


else
{

if($file_handler->CheckFileExists($global->clean_input($_POST['script'])))
{
$inserted=$global->post2array($_POST);
$db->insert('cronjobs',$inserted);

$inserted['serialkey']= $config['serialkey'];
$global->curlUsingPost('http://'.$system['systemip'].':'.$system['panelport'].'/API/cronjob.php',$inserted);


echo '<div class="alert alert-success"><i class="fa fa-ok-sign"></i><strong>'.WELLDONE.'</strong>&nbsp;&nbsp;'.ONE_RECORD_SAVED.'</a></div>';
}

else
{
echo '<div class="alert alert-error"><i class="fa fa-ok-sign"></i><strong>'.FILE_DOES_NOT_EXIST.'</strong></a></div>';	
}


}

}
}


?>

<?php

$crontiming = $db->fetchAll("SELECT * FROM  `cron_timings` order by tid asc");
  
$fieldarray = array(

array("fieldname" => "name","fielddesc" => CRON_NAME ,"fieldtype" => "text","fieldplaceholder" =>CRON_NAME_PLACEHOLDER,"fieldvalue" => isset($_GET['id']) ? $data['name']:"","data-type" => "","data-required" => "true","validator" => ""),

array("fieldname" => "script","fielddesc" => CRON_SCRIPT_PATH ,"fieldtype" => "text","fieldplaceholder" =>CRON_SCRIPT_PATH_PLACEHOLDER,"fieldvalue" => isset($_GET['id']) ? $data['script']:"","data-type" => "","data-required" => "true","validator" => ""),

array("fieldname" => "comment","fielddesc" => CRON_SCRIPT_COMMENT ,"fieldtype" => "text","fieldplaceholder" =>CRON_SCRIPT_COMMENT_PLACEHOLDER,"fieldvalue" => isset($_GET['id']) ? $data['comment']:"","data-type" => "","data-required" => "","validator" => ""),

array("fieldname" => "time","fielddesc" =>CRON_EXECUTION_TIME,"fieldtype" => "select","fielddefaultvalue" =>$crontiming, "fieldvalue"=> "unix_timing", "fieldvaluedesc"=> "english_timing","data-required"=>"true", "selectedvalue"=>isset($_GET['id']) ? $data['time']:"")


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
        
        
