<?php include ('library/autoload.php');
include('include/sessioncheck.php');
include('include/header.php'); 
?>

<div id="page-wrapper">
            <div class="row">
                <div class="col-lg-12">
                
                    <h1 class="page-header"> <?php echo PROMOTIONAL_OFFERS_HEADING ?></h1>
                </div>
                <!-- /.col-lg-12 -->
            </div>
            <!-- /.row -->
            <div class="row">
             <div class="col-lg-12">
 
 
                    <div class="panel panel-default">
  <div class="panel-heading">
  
     <?php echo PROMOTIONAL_OFFERS_HEADING ?>
  
  
  

  </div>
                    
                    <div class="panel-body">


<div>

  <!-- Nav tabs -->
  <ul class="nav nav-tabs" role="tablist">
    <li role="presentation" class="active"><a href="#home" aria-controls="home" role="tab" data-toggle="tab"><?php echo DOMAIN_PROMOTIONS  ?></a></li>
    <li role="presentation"><a href="#profile" aria-controls="profile" role="tab" data-toggle="tab"><?php echo HOSTING_PROMOTIONS  ?></a></li>
    <li role="presentation"><a href="#messages" aria-controls="messages" role="tab" data-toggle="tab"><?php echo OTHERS_PROMOTIONS  ?></a></li>
  </ul>

  <!-- Tab panes -->
  <div class="tab-content">
    <div role="tabpanel" class="tab-pane fade in active" id="home">
    
     <?php
	
	echo base64_decode($global->DownloadPage("http://zincksoft.com/license/zncp/domainpromo.php?key=".$config['serialkey']));
	
    ?>
    
    </div>
    <div role="tabpanel" class="tab-pane fade" id="profile">
    
     <?php
	
	echo base64_decode($global->DownloadPage("http://zincksoft.com/license/zncp/hostingpromo.php?key=".$config['serialkey']));
	
    ?>
    
    </div>
    <div role="tabpanel" class="tab-pane fade" id="messages">
    
     <?php
	
	echo base64_decode($global->DownloadPage("http://zincksoft.com/license/zncp/otherpromo.php?key=".$config['serialkey']));
	
    ?>
    
    </div>
  </div>

</div>


                 
                    </div>
                  
                
              </div>   
               
                
            </div>

        </div>
        
        <?php include 'include/footer.php' ?>
        
        
