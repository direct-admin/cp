<?php include ('library/autoload.php');
include('include/sessioncheck.php');
include('include/header.php'); ?>

<div id="page-wrapper">
            <div class="row">
                <div class="col-lg-12">
                    <h1 class="page-header"><?php echo PHP_INFO  ?></h1>
                </div>
                <!-- /.col-lg-12 -->
            </div>
            <!-- /.row -->
            <div class="row">
             <div class="col-lg-12">
 
 
                    <div class="panel panel-default">
  <div class="panel-heading">
  
    <?php echo PHP_INFO  ?>
    
  </div>
                    
                    <div class="panel-body">
                                
                    
                    
                    <?php echo phpinfo();  ?>               
                        
                        
                     
                    </div>
              </div>   
               
                
            </div>

        </div>
        
        <?php include 'include/footer.php' ?>