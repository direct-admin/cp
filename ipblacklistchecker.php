<?php include ('library/autoload.php');
include('include/sessioncheck.php');
include('include/header.php'); ?>

<div id="page-wrapper">
            <div class="row">
                <div class="col-lg-12">
                    <h1 class="page-header"><?php echo IP_BLACKLIST_CHECKER  ?></h1>
                </div>
                <!-- /.col-lg-12 -->
            </div>
            <!-- /.row -->
            <div class="row">
             <div class="col-lg-12">
 
 
                    <div class="panel panel-default">
  <div class="panel-heading">
  
    <?php echo IP_BLACKLIST_CHECKER  ?>
    
  </div>
                    
                    <div class="panel-body">
                                
                    
                    
<?php

function dnsbllookup($ip){
$listed="";
$dnsbl_lookup=array("dnsbl-1.uceprotect.net","dnsbl-2.uceprotect.net","dnsbl-3.uceprotect.net","dnsbl.dronebl.org","dnsbl.sorbs.net","zen.spamhaus.org"); // Add your preferred list of DNSBL's
if($ip){
$reverse_ip=implode(".",array_reverse(explode(".",$ip)));
foreach($dnsbl_lookup as $host){
if(checkdnsrr($reverse_ip.".".$host.".","A")){
$listed.=$reverse_ip.'.'.$host.' <font color="red">Listed</font><br />';
}
}
}
if($listed){
echo $listed;
}else{
echo IP_CHECKER_MESSAGE . ' <br><br>dnsbl-1.uceprotect.net<br><br>dnsbl-2.uceprotect.net<br><br>dnsbl-3.uceprotect.net<br><br>dnsbl.dronebl.org<br><br>dnsbl.sorbs.net<br><br>zen.spamhaus.org';
}
}
$ip=$system['systemip'];
if(filter_var($ip,FILTER_VALIDATE_IP)){
echo dnsbllookup($ip);
}
?>        
                        
                        
                     
                    </div>
              </div>   
               
                
            </div>

        </div>
        
        <?php include 'include/footer.php' ?>