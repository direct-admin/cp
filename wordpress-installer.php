<?php include ('library/autoload.php');
include('include/sessioncheck.php');
include('include/header.php'); 
$file_handler = new DirFileHandler();
?>

<div id="page-wrapper">
            <div class="row">
                <div class="col-lg-12">
                
                    <h1 class="page-header"> <?php echo WORDPRESS_INSTALLER ?></h1>
                </div>
                <!-- /.col-lg-12 -->
            </div>
            <!-- /.row -->
            <div class="row">
             <div class="col-lg-12">
 
 
                    <div class="panel panel-default">
  <div class="panel-heading">
  
     <?php echo WORDPRESS_INSTALLER ?>

  </div>
                    
                    <div class="panel-body">
                    
                    
                                
<?php

if($_SERVER['REQUEST_METHOD'] == 'POST')
{
$valid = new FormValidation($_POST);
$message = $valid->RequiredData(array("www_path" =>WORDPRESS_INSTALLER_SELECT_DOMAIN,"db_user" =>WORDPRESS_INSTALLATION_DB_USER,"admin_username" =>WORDPRESS_ADMIN_USERNAME,"admin_password" =>WORDPRESS_ADMIN_PASSWORD,"admin_emailid" =>WORDPRESS_ADMIN_EMAILID,"site_title" =>WORDPRESS_SITE_TITLE,"site_url" =>WORDPRESS_SITE_URL));
$message = $valid->EmailCheck(array("admin_emailid" =>WORDPRESS_ADMIN_EMAILID));
$message = $valid->ValidationErrors();


if(!empty($message)) { echo '<div class="alert alert-danger"><i class="fa fa-ban-circle"></i>'.$message.'</div>';}

else
{
$installation_folder = $global->clean_input($_POST['www_path'])."/".$global->clean_input($_POST['dir_folder']);

if($file_handler->CheckFolderExists($installation_folder))
{

$installation_folder .= "/";

$db_deails = $db->fetchOne('Select * from mysqlusers where mysqluserid=:mysqluserid',array(":mysqluserid"=>$global->clean_input($_POST['db_user'])));

//********************************************* Wordpress Installation Start Here *******************////////////////

Command('wget', array('-O','/var/tmp/latest.tar.gz','http://wordpress.org/latest.tar.gz'));

Command('tar', array('zxf','/var/tmp/latest.tar.gz','-C','/var/tmp/'));

Command('cp', array('-a','/var/tmp/wordpress/.',$installation_folder));

Command('wget', array('-O','/var/tmp/wp.keys','https://api.wordpress.org/secret-key/1.1/salt/'));

Command('cp', array($installation_folder.'wp-config-sample.php',$installation_folder.'wp-config.php'));

Command('chmod', array('-R','0777',$installation_folder.'wp-config.php'));

$params = array('-i','s|database_name_here|'.$db_deails['dbname'].'|',$installation_folder.'wp-config.php');

Command('sed',$params);


$params = array('-i','s|username_here|'.$db_deails['username'].'|',$installation_folder.'wp-config.php');

Command('sed',$params);

$params = array('-i','s|password_here|'.$db_deails['password'].'|',$installation_folder.'wp-config.php');

Command('sed',$params);


$params = array('-i','/#@-/r /var/tmp/wp.keys',$installation_folder.'wp-config.php');

Command('sed',$params);


$params = array('-i','/#@+/,/#@-/d',$installation_folder.'wp-config.php');

Command('sed',$params);


$post['weblog_title'] = $global->clean_input($_POST['site_title']);
$post['user_name'] = $global->clean_input($_POST['admin_username']);
$post['admin_password'] = $global->clean_input($_POST['admin_password']);
$post['admin_password2'] = $global->clean_input($_POST['admin_password']);
$post['admin_email'] = $global->clean_input($_POST['admin_emailid']);

$rest = substr($global->clean_input($_POST['site_url']), -1);

if($rest != "/")
{
$web_url = $global->clean_input($_POST['site_url']) . "/";
}
else
{
	$web_url = $global->clean_input($_POST['site_url']);
}

curlUsingPost($web_url.'wp-admin/install.php?step=2',$post);



//********************************************* Wordpress Installation Start Here *******************////////////////


echo '<div class="alert alert-success"><i class="fa fa-ok-sign"></i><strong>'.WELLDONE.'</strong>&nbsp;&nbsp;'.WORDPRESS_INSTALLATION_DONE.'</a></div>';
}
else
{
echo '<div class="alert alert-danger"><i class="fa fa-ban-circle"></i><strong>'.SORRY.'</strong>&nbsp;&nbsp;'.WORDPRESS_INSTALLATION_PATH_INVALID.'</div>';	
}



}
}


?>

<?php

$domains = $db->fetchAll("SELECT * FROM  `domains` where type=0");

$subdomains = $db->fetchAll("SELECT * FROM  `subdomains` where type=0");

for($i=0;$i<count($domains);$i++)
{
$domain_select[$i]['path'] = $domains[$i]['www_path'];
$domain_select[$i]['domain'] = $domains[$i]['domain_name'];
}

for($j=0;$j<count($subdomains);$j++)
{
$sub_domain_select[$j]['path'] = $subdomains[$j]['www_path'];
$sub_domain_select[$j]['domain'] = $subdomains[$j]['subname'].".".$subdomains[$j]['domain_name'];
}

$new_domain_select = array_merge($domain_select,$sub_domain_select);


$dbusers = $db->fetchAll("SELECT * FROM  `mysqlusers`");

for($j=0;$j<count($dbusers);$j++)
{
$db_select[$j]['id'] = $dbusers[$j]['mysqluserid'];
$db_select[$j]['db'] = MYSQL_DATABASE."=".$dbusers[$j]['dbname']." --> ".MYSQL_USERS."=".$dbusers[$j]['username'];
}

$fieldarray = array(

array("fieldname" => "www_path","fielddesc" =>WORDPRESS_INSTALLER_SELECT_DOMAIN,"fieldtype" => "select","fielddefaultvalue" =>$new_domain_select, "fieldvalue"=> "path", "fieldvaluedesc"=> "domain","data-required"=>"true", "selectedvalue"=>""),

array("fieldname" => "dir_folder","fielddesc" =>WORDPRESS_INSTALLATION_DIRECTORY,"fieldtype" => "text","fieldplaceholder" =>WORDPRESS_INSTALLATION_DIRECTORY_PLACEHOLDER,"fieldvalue" =>"","data-required"=>"false","data-type"=>"","validator"=>""),

array("fieldname" => "db_user","fielddesc" =>WORDPRESS_INSTALLATION_DB_USER,"fieldtype" => "select","fielddefaultvalue" =>$db_select, "fieldvalue"=> "id", "fieldvaluedesc"=> "db","data-required"=>"true", "selectedvalue"=>""),

array("fieldname" => "admin_username","fielddesc" =>WORDPRESS_ADMIN_USERNAME,"fieldtype" => "text","fieldplaceholder" =>WORDPRESS_ADMIN_USERNAME_PLACEHOLDER,"fieldvalue" =>"","data-required"=>"true","data-type"=>"","validator"=>""),

array("fieldname" => "admin_password","fielddesc" =>WORDPRESS_ADMIN_PASSWORD,"fieldtype" => "password","fieldplaceholder" =>WORDPRESS_ADMIN_PASSWORD_PLACEHOLDER,"fieldvalue" =>"","data-required"=>"true","data-type"=>"","validator"=>""),

array("fieldname" => "admin_emailid","fielddesc" =>WORDPRESS_ADMIN_EMAILID,"fieldtype" => "email","fieldplaceholder" =>WORDPRESS_ADMIN_EMAILID_PLACEHOLDER,"fieldvalue" =>"","data-required"=>"true","data-type"=>"email","validator"=>""),


array("fieldname" => "site_title","fielddesc" =>WORDPRESS_SITE_TITLE,"fieldtype" => "text","fieldplaceholder" =>WORDPRESS_SITE_TITLE_PLACEHOLDER,"fieldvalue" =>"","data-required"=>"true","data-type"=>"","validator"=>""),

array("fieldname" => "site_url","fielddesc" =>WORDPRESS_SITE_URL,"fieldtype" => "text","fieldplaceholder" =>WORDPRESS_SITE_URL_PLACEHOLDER,"fieldvalue" =>"","data-required"=>"true","data-type"=>"","validator"=>"")


);

$buttonarray = array ( array("buttontype" => "submit","buttoncss" => "btn btn-success","buttonname" => INSTALL),
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
        
        
