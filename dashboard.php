<?php include ('library/autoload.php');
include('include/sessioncheck.php');
include('include/header.php'); 

$mailboxcount = $db->fetchOne('Select count(*) as num from mailboxes');

$dbcount = $db->fetchOne('Select count(*) as num from mysqldb');

$ftpcount = $db->fetchOne('Select count(*) as num from ftpuser');

$domaincount = $db->fetchOne('Select count(*) as num from domains');

?>

<div id="page-wrapper">
            <div class="row">
                <div class="col-lg-12">
                    <h1 class="page-header">Dashboard</h1>
                </div>
                <!-- /.col-lg-12 -->
            </div>
            
            
            <div class="row">
                <div class="col-lg-3 col-md-6">
                    <div class="panel panel-primary">
                        <div class="panel-heading">
                            <div class="row">
                                <div class="col-xs-3">
                                    <i class="fa fa-envelope fa-5x"></i>
                                </div>
                                <div class="col-xs-9 text-right">
                                    <div class="huge"><?php echo $mailboxcount['num']  ?></div>
                                    <div><?php echo TOTAL_MAILBOXES  ?></div>
                                </div>
                            </div>
                        </div>
                        <a href="mailbox.php">
                            <div class="panel-footer">
                                <span class="pull-left"><?php echo VIEW_DETAILS  ?></span>
                                <span class="pull-right"><i class="fa fa-arrow-circle-right"></i></span>
                                <div class="clearfix"></div>
                            </div>
                        </a>
                    </div>
                </div>
                <div class="col-lg-3 col-md-6">
                    <div class="panel panel-yellow">
                        <div class="panel-heading">
                            <div class="row">
                                <div class="col-xs-3">
                                    <i class="fa fa-sitemap fa-5x"></i>
                                </div>
                                <div class="col-xs-9 text-right">
                                    <div class="huge"><?php echo $ftpcount['num']  ?></div>
                                    <div><?php echo TOTAL_FTP_ACCOUNTS  ?></div>
                                </div>
                            </div>
                        </div>
                        <a href="ftpuser.php">
                            <div class="panel-footer">
                                <span class="pull-left"><?php echo VIEW_DETAILS  ?></span>
                                <span class="pull-right"><i class="fa fa-arrow-circle-right"></i></span>
                                <div class="clearfix"></div>
                            </div>
                        </a>
                    </div>
                </div>
                
                <div class="col-lg-3 col-md-6">
                    <div class="panel panel-green">
                        <div class="panel-heading">
                            <div class="row">
                                <div class="col-xs-3">
                                    <i class="fa fa-tasks fa-5x"></i>
                                </div>
                                <div class="col-xs-9 text-right">
                                    <div class="huge"><?php echo $dbcount['num']  ?></div>
                                    <div><?php echo TOTAL_DATABASE  ?></div>
                                </div>
                            </div>
                        </div>
                        <a href="mysqldb.php">
                            <div class="panel-footer">
                                <span class="pull-left"><?php echo VIEW_DETAILS  ?></span>
                                <span class="pull-right"><i class="fa fa-arrow-circle-right"></i></span>
                                <div class="clearfix"></div>
                            </div>
                        </a>
                    </div>
                </div>
                
                
                <div class="col-lg-3 col-md-6">
                    <div class="panel panel-red">
                        <div class="panel-heading">
                            <div class="row">
                                <div class="col-xs-3">
                                    <i class="fa fa-globe fa-5x"></i>
                                </div>
                                <div class="col-xs-9 text-right">
                                    <div class="huge"><?php echo $domaincount['num']  ?></div>
                                    <div><?php echo TOTAL_DOMAINS  ?></div>
                                </div>
                            </div>
                        </div>
                        <a href="domains.php">
                            <div class="panel-footer">
                                <span class="pull-left"><?php echo VIEW_DETAILS  ?></span>
                                <span class="pull-right"><i class="fa fa-arrow-circle-right"></i></span>
                                <div class="clearfix"></div>
                            </div>
                        </a>
                    </div>
                </div>
            </div>
            
            
            
            
            
            
            
            <div class="row">
                <div class="col-lg-3 col-md-6">
                
                <div class="panel panel-default">
  <div class="panel-heading">
    <h3 class="panel-title"><?php echo ACCOUNT_INFORMATION  ?></h3>
  </div>
  <div class="panel-body">
   
   <table class="table table-hover table-bordered table-striped">
   
   
        <tr>
          <td><strong><?php echo ACCOUNT_NAME  ?>:</strong></td><td> <?php echo $sess->get('username')  ?></td>
        </tr>
        
        
        <tr>
          <td><strong><?php echo ACCOUNT_TYPE  ?>:</strong></td><td> <?php echo ADMINISTRATOR  ?></td>
        </tr>
        
        
        <tr>
          <td><strong><?php echo ACCOUNT_EMAILID  ?>:</strong></td><td> <?php echo $config['emailid']  ?></td>
        </tr>
        
        <tr>
          <td><strong><?php echo TIME_ZONE  ?>:</strong></td><td> <?php echo $config['timezone']  ?></td>
        </tr>
        
        
        <tr>
          <td><strong><?php echo PRODUCT_NAME  ?>:</strong></td><td> <?php echo $config['productname']  ?></td>
        </tr>
        
        
         <tr>
          <td><strong><?php echo CP_VERSION  ?>:</strong></td><td> <?php echo $config['version']  ?></td>
        </tr>
        
        
        <tr>
          <td><strong><?php echo PRODUCT_SERIAL_KEY  ?>:</strong></td><td> <?php echo substr($config['serialkey'], 0, 20);  ?></td>
        </tr>
        
   
   </table>
   
  </div>
</div>
                
                </div>
                
                
                
                
                
                
                <div class="col-lg-3 col-md-6">
                
                <div class="panel panel-default">
  <div class="panel-heading">
    <h3 class="panel-title"><?php echo SERVER_INFORMATION  ?></h3>
  </div>
  <div class="panel-body">
    
    
    <table class="table table-hover table-bordered table-striped">
   
   
       <tr>
          <td><strong><?php echo SERVER_IP  ?>:</strong> </td>
          <td><?php echo $system['systemip']  ?></td>
        </tr>
        
        
        <tr>
          <td><strong><?php echo SERVER_OS  ?>:</strong> </td>
          <td><?php echo PHP_OS  ?></td>
        </tr>
        
        
        <tr>
          <td><strong><?php echo APACHE_VERSION  ?>:</strong></td> 
          <td>
		  <?php 
		  
		  function apacheversion() {
		   $ver = explode("/",$_SERVER['SERVER_SOFTWARE']);
		   $apver = explode("(",$ver[1]);
		   return $apver[0];
			}


			echo apacheversion()  ?></td>
        </tr>
        
        <tr>
          <td><strong><?php echo SERVER_PHP_VERSION  ?>:</strong></td>
          <td> <?php echo phpversion()  ?></td>
        </tr>
        
        
        <tr>
          <td><strong><?php echo MYSQL_VERSION  ?>:</strong> </td>
          <td><?php echo mysql_get_server_info()  ?></td>
        </tr>
        
        
        
      
   
   </table>
   
   
  </div>
</div>
                
                </div>
                
                
                
                
                
                
                
                
                
                <div class="col-lg-3 col-md-6">
                
                <div class="panel panel-default">
  <div class="panel-heading">
    <h3 class="panel-title"><?php echo SERVICE_STATUS  ?></h3>
  </div>
  <div class="panel-body">
    
    <?php $report = $global->server_report(); ?>
    
    
    
    <table class="table table-hover table-bordered table-striped">
   
   <thead>
   <tr>
   <th>Service</th>
   <th>Status</th>
   </tr>
   </thead>
   
   <tbody>
   
   		<tr>
        <td>FTP</td>
        <td><?php echo $report['FTP'] ? "<i class='fa fa-check'></i>" : "<i class='fa fa-times'></i>"; ?>
        </tr>
        
        <tr>
        <td>SSH</td>
        <td><?php echo $report['SSH'] ? "<i class='fa fa-check'></i>" : "<i class='fa fa-times'></i>"; ?></td>
    	</tr>
        
        <tr>
        <td>SMTP</td>
        <td><?php echo $report['SMTP'] ? "<i class='fa fa-check'></i>" : "<i class='fa fa-times'></i>"; ?></td>
    </tr>
    <tr>
        <td>HTTP</td>
        <td><?php echo $report['HTTP'] ? "<i class='fa fa-check'></i>" : "<i class='fa fa-times'></i>"; ?></td>
    </tr>
    <tr>
        <td>POP3</td>
        <td><?php echo $report['POP3'] ? "<i class='fa fa-check'></i>" : "<i class='fa fa-times'></i>"; ?></td>
    </tr>
    <tr>
        <td>IMAP</td>
        <td><?php echo $report['IMAP'] ? "<i class='fa fa-check'></i>" : "<i class='fa fa-times'></i>"; ?></td>
    </tr>
    <tr>
        <td>MySQL</td>
        <td><?php echo $report['MySQL'] ? "<i class='fa fa-check'></i>" : "<i class='fa fa-times'></i>"; ?></td>
    </tr>
   
   </tbody>
       
        
      
      
        
        
      
   
   </table>
    
    
  </div>
</div>
                
                </div>
                
                
                
                
                
                <div class="col-lg-3 col-md-6">
                
                <div class="panel panel-default">
  <div class="panel-heading">
    <h3 class="panel-title"><?php echo NEWS_OFFERS  ?></h3>
  </div>
  <div class="panel-body">
    
    
    <?php
	
	echo base64_decode($global->DownloadPage("http://zincksoft.com/license/zncp/mainpromo.php?key=".$config['serialkey']));
	
    ?>
    
    
  </div>
</div>
                
                </div>
                
                </div>
            

   
        
        
<?php include('include/footer.php');  ?>