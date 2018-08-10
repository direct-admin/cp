<?php include('sessioncheck.php'); ?>
<!DOCTYPE html>
<html lang="en">

<head>

    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="">
    <meta name="author" content="">

    <title><?php echo $config['productname'] . " Ver. " . $config['version'] ?></title>

    <!-- Bootstrap Core CSS -->
    <link href="css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.2.0/css/bootstrap-theme.min.css">
    
    <link rel="stylesheet" type="text/css" href="http://cdnjs.cloudflare.com/ajax/libs/bootstrap-datetimepicker/3.1.3/css/bootstrap-datetimepicker.min.css">

    <!-- MetisMenu CSS -->
    <link href="css/plugins/metisMenu/metisMenu.min.css" rel="stylesheet">
    
    <!-- DataTables CSS -->
    <link href="//cdn.datatables.net/1.10.3/css/jquery.dataTables.min.css" rel="stylesheet">
    <!-- Custom CSS -->
    <link href="css/sb-admin-2.css" rel="stylesheet">

    <!-- Custom Fonts -->
    <!--<link href="font-awesome-4.1.0/css/font-awesome.min.css" rel="stylesheet" type="text/css">-->
    <!--<link rel="stylesheet" href="//maxcdn.bootstrapcdn.com/font-awesome/4.3.0/css/font-awesome.min.css">-->
    
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/font-awesome/4.4.0/css/font-awesome.min.css">

    <!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
    <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
    <!--[if lt IE 9]>
        <script src="https://oss.maxcdn.com/libs/html5shiv/3.7.0/html5shiv.js"></script>
        <script src="https://oss.maxcdn.com/libs/respond.js/1.4.2/respond.min.js"></script>
    <![endif]-->
    

    

    <!-- jQuery Version 1.11.0 -->
    <script src="js/jquery-1.11.0.js"></script>

    <!-- Bootstrap Core JavaScript -->
    <script src="js/bootstrap.min.js"></script>
    <script src="js/moment.min.js"></script>
    <script src="http://cdnjs.cloudflare.com/ajax/libs/bootstrap-datetimepicker/3.1.3/js/bootstrap-datetimepicker.min.js"></script>

    <!-- Metis Menu Plugin JavaScript -->
    <script src="js/plugins/metisMenu/metisMenu.min.js"></script>
    
    <!-- DataTables JavaScript -->
    <script src="js/plugins/dataTables/jquery.dataTables.js"></script>
    <script src="js/plugins/dataTables/dataTables.bootstrap.js"></script>

    <!-- Custom Theme JavaScript -->
    <script src="js/sb-admin-2.js"></script>
    
    <script src="js/fluid.js"></script>
    
    <script src="js/ajax.js"></script>
    
    <script src="js/parsley/parsley.min.js"></script>
<script src="js/parsley/parsley.extend.js"></script>
    
    <script>
    $(document).ready(function() {
        $('#dataTables').DataTable({"aaSorting": [], "bFilter": false, "bPaginate": false});
		$('.datetimepicker').datetimepicker({"format": "YYYY-MM-DD HH:mm:ss"});
		$('.timer').datetimepicker({pickDate: false, "format": "HH:mm:ss"});
		
    });
	
	
    </script>
    
    <script src="//tinymce.cachefly.net/4.1/tinymce.min.js"></script>
<script type="text/javascript">
tinymce.init({
    selector: "textarea",
    plugins: [
        "advlist autolink lists link image charmap print preview anchor",
        "searchreplace visualblocks code fullscreen",
        "insertdatetime media table contextmenu paste"
    ],
    toolbar: "insertfile undo redo | styleselect | bold italic | alignleft aligncenter alignright alignjustify | bullist numlist outdent indent | link image"
});
</script>

</head>

<body>

    <div id="wrapper">

        <!-- Navigation -->
        <nav class="navbar navbar-default navbar-static-top" role="navigation" style="margin-bottom: 0">
            <div class="navbar-header">
                <button type="button" class="navbar-toggle" data-toggle="collapse" data-target=".navbar-collapse">
                    <span class="sr-only">Toggle navigation</span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                </button>
                <a class="navbar-brand" href="dashboard.php"><?php echo $config['productname'] . " Ver. " . $config['version'] ?></a>
            </div>
            <!-- /.navbar-header -->

            
                     
            <div class="navbar-default sidebar" role="navigation">
                <div class="sidebar-nav navbar-collapse">
                    <ul class="nav" id="side-menu">
                        
                        <li>
                            <a  href="dashboard.php"><i class="fa fa-dashboard fa-fw"></i> Dashboard</a>
                        </li>
                        
                        
                        <li>
                            <a href="#"><?php echo MANAGE_DOMAINS  ?></a>
                            <ul class="nav nav-second-level">
                                <li>
                                    <a href="domains.php"><?php echo DOMAINS  ?></a>
                                </li>
                                
                                <li>
                                    <a href="subdomains.php"><?php echo SUBDOMAINS  ?></a>
                                </li>
                                
                                <li>
                                    <a href="dnsmanager.php"><?php echo DNS  ?></a>
                                </li>
                                
                              
                            </ul>
                            <!-- /.nav-second-level -->
                        </li>
                        
                        
                                                
                        
                        <li>
                            <a href="#"><?php echo MANAGE_MAIL  ?></a>
                            <ul class="nav nav-second-level">
                                <li>
                                    <a href="mailbox.php"><?php echo MAILBOXES  ?></a>
                                </li>
                                
                                <li>
                                    <a href="APP/webmail/index.php" target="_blank"><?php echo WEBMAIL  ?></a>
                                </li>
                                
                              
                            </ul>
                            <!-- /.nav-second-level -->
                        </li>
                        
                        
                        
                        <li>
                            <a href="#"><?php echo MANAGE_DATABASE  ?></a>
                            <ul class="nav nav-second-level">
                                <li>
                                    <a href="mysqldb.php"><?php echo MYSQL_DATABASE  ?></a>
                                </li>
                                
                                <li>
                                    <a href="mysqlusers.php"><?php echo MYSQL_USERS  ?></a>
                                </li>
                                
                                <li>
                                    <a href="APP/phpmyadmin/index.php" target="_blank"><?php echo PHPMYADMIN  ?></a>
                                </li>
                                
                              
                            </ul>
                            <!-- /.nav-second-level -->
                        </li>
                        
                        
                        
                        <li>
                            <a href="#"><?php echo MANAGE_FILE  ?></a>
                            <ul class="nav nav-second-level">
                                <li>
                                    <a href="ftpuser.php"><?php echo FTP_USERS  ?></a>
                                </li>
                                
                                <li>
                                    <a href="filemanager.php" target="_blank"><?php echo FILE_MANAGER  ?></a>
                                </li>
                                
                              
                            </ul>
                            <!-- /.nav-second-level -->
                        </li>
                        
                       <li><a href="cronjobs.php"><?php echo CRON_JOBS  ?></a></li>
                        
                        
                       
                       
                       <li>
                            <a href="#"><?php echo SCRIPT_INSTALLERS  ?></a>
                            <ul class="nav nav-second-level">
                                
                                <?php
								
								$installers = $db->fetchAll("Select * from installers order by name asc");
								
								if(!empty($installers))
								{
								
								for($i=0;$i<count($installers);$i++)
								{
									
									echo "<li><a href='".$installers[$i]['file']."'>".$installers[$i]['icon']." ". $installers[$i]['name'] ."</a></li>";
									
								}
								
								}
								
								?>
                                
                                
                                
                            </ul>
                            <!-- /.nav-second-level -->
                        </li>
                        
                        
                       
                        
                         <li>
                            <a href="#"><?php echo UTILITY  ?></a>
                            <ul class="nav nav-second-level">
                                
                                <li>
                                    <a href="phpinfo.php"><?php echo PHP_INFO  ?></a>
                                </li>
                                <li>
                                    <a href="APP/phpsysinfo/index.php" target="_blank"> <?php echo SYSTEM_INFO  ?></a>
                                </li>
                                <li>
                                    <a href="ipblacklistchecker.php"><?php echo IP_BLACKLIST_CHECKER  ?></a>
                                </li>
                            </ul>
                            <!-- /.nav-second-level -->
                        </li>
                        
                        
                         
                        
                        
                         <li><a href="offers.php"><?php echo PROMOTION_OFFERS  ?></a></li>
                        
                        
                        
                        <li>
                            <a href="#"><?php echo SETTINGS  ?></a>
                            <ul class="nav nav-second-level">
                            
                             <li>
                                    <a href="settings.php"><?php echo EDIT_SETTINGS  ?></a>
                                </li>
                                
                                <li>
                                    <a href="changepassword.php"><?php echo CHANGE_PASSWORD  ?></a>
                                </li>
                               
                               
                            </ul>
                            <!-- /.nav-second-level -->
                        </li>
                        
                        
                       <li>
                            <a  href="logout.php"><?php echo LOGOUT  ?></a>
                        </li>
                        
                    </ul>
                </div>
                <!-- /.sidebar-collapse -->
            </div>
            <!-- /.navbar-static-side -->
        </nav>