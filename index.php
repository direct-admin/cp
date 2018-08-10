<?php include ('library/autoload.php');
if(!isset($_SESSION['failedlogincount']))
{
$_SESSION['failedlogincount'] =0;
}
	
$banip = $db->fetchOne('Select * from banip where ip=":ip"',array(":ip"=>getenv('REMOTE_ADDR')));

if(!empty($banip))
{
$global->redirect('banip.php');	
}

?>
<!DOCTYPE html>
<html lang="en">

<head>

    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="">
    <meta name="author" content="">

    <title><?php echo $config['productname'] . " "  . $config['version'] ?></title>

    <!-- Bootstrap Core CSS -->
    <link href="css/bootstrap.min.css" rel="stylesheet">
    
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.2.0/css/bootstrap-theme.min.css">

    <!-- MetisMenu CSS -->
    <link href="css/plugins/metisMenu/metisMenu.min.css" rel="stylesheet">

    <!-- Custom CSS -->
    <link href="css/sb-admin-2.css" rel="stylesheet">

    <!-- Custom Fonts -->
    <link href="font-awesome-4.1.0/css/font-awesome.min.css" rel="stylesheet" type="text/css">

    <!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
    <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
    <!--[if lt IE 9]>
        <script src="https://oss.maxcdn.com/libs/html5shiv/3.7.0/html5shiv.js"></script>
        <script src="https://oss.maxcdn.com/libs/respond.js/1.4.2/respond.min.js"></script>
    <![endif]-->

</head>

<body>

    <div class="container">
        <div class="row">
            <div class="col-md-4 col-md-offset-4">
                <div class="login-panel panel panel-default">
                    <div class="panel-heading">
                        <h3 class="panel-title"><?php echo PLEASE_SIGN_IN  ?></h3>
                    </div>
                    <div class="panel-body">
<?php
if($_SERVER['REQUEST_METHOD'] == 'POST')
{

if($_SESSION['failedlogincount'] > $config['failedlogintry'])
{
echo "<div class='alert alert-danger'><i class='fa fa-ban-circle'></i>".LOGIN_TRY_FAILED ."</div>";
$ban['ip'] = getenv('REMOTE_ADDR');
$ban['timestamp']= time();
$db->insert('banip',$ban);
session_destroy();
}
else
{

$valid = new FormValidation($_POST);
$message = $valid->RequiredData(array("username" => LOGIN_USERNAME,"userpass" => LOGIN_PASSWORD));
$message = $valid->ValidationErrors();

if(!empty($message)) { echo "<div class='alert alert-danger'><i class='fa fa-ban-circle'></i>".$message ."</div>";}
else
{
	
$logincheck = $db->fetchOne('Select * from auth where username="'.$global->clean_input($_POST['username']).'" and password="'.$encrypt->encode($_POST['userpass']).'"');

if(empty($logincheck))
{
$_SESSION['failedlogincount']++;
echo "<div class='alert alert-danger'><i class='fa fa-ban-circle'></i>".LOGIN_INVALID."</div>";
}
else
{

foreach($logincheck as $key=>$value)
{
$sess->set($key, $value);
}

$global->redirect('dashboard.php');
}

}
}
}


$fieldarray = array(array("fieldname" => "username","fielddesc" => LOGIN_USERNAME,"fieldtype" => "text","fieldplaceholder" =>LOGIN_USERNAME_PLACEHOLDER,"fieldvalue" => "","data-type" => "","data-required" => "true","validator" =>"data-minlength='6'"),
array("fieldname" => "userpass","fielddesc" => LOGIN_PASSWORD,"fieldtype" => "password","fieldplaceholder" =>LOGIN_PASSWORD_PLACEHOLDER,"fieldvalue" => "","data-type" => "","data-required" => "true","validator" => "data-minlength='6'")
);

$buttonarray = array ( array("buttontype" => "submit","buttoncss" => "btn btn-lg btn-success btn-block","buttonname" =>LOGIN_SIGNIN));


$formobj->AddFields($fieldarray);

$formobj->AddButtons($buttonarray);

echo $formobj->LoginGenrateForm();

        ?>
        
        
        
                    </div>
                </div>
                
               <p class="text-center"><a href="<?php echo $config['poweredurl'] ?>" target="_blank"><?php echo $config['productname'] . "&nbsp;Ver.&nbsp;" . $config['version'] ?></a></p>  
                
            </div>
        </div>
        
        
        
    </div>



    <!-- jQuery Version 1.11.0 -->
    <script src="js/jquery-1.11.0.js"></script>

    <!-- Bootstrap Core JavaScript -->
    <script src="js/bootstrap.min.js"></script>

    <!-- Metis Menu Plugin JavaScript -->
    <script src="js/plugins/metisMenu/metisMenu.min.js"></script>

    <!-- Custom Theme JavaScript -->
    <script src="js/sb-admin-2.js"></script>
    
     <script src="js/parsley/parsley.min.js"></script>
<script src="js/parsley/parsley.extend.js"></script>

</body>

</html>