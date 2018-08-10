<?php include ('library/autoload.php');
include('include/sessioncheck.php');
include('include/header.php'); ?>

<div id="page-wrapper">
            <div class="row">
                <div class="col-lg-12">
                    <h1 class="page-header"><?php echo DNS  ?></h1>
                </div>
                <!-- /.col-lg-12 -->
            </div>
            <!-- /.row -->
            <div class="row">
             <div class="col-lg-12">
 
 
                    <div class="panel panel-default">
  <div class="panel-heading">
  
    <?php echo DNS  ?>
    
    <div class="pull-right">
                                <div class="btn-group">
                                    <button type="button" class="btn btn-default btn-xs dropdown-toggle" data-toggle="dropdown">
                                        Actions
                                        <span class="caret"></span>
                                    </button>
                                    <ul class="dropdown-menu pull-right" role="menu">
                                        <li><a href="adddns.php"><?php echo ADD_NEW_DNS  ?></a>
                                        </li>
                                        
                                      
                                        
                                    </ul>
                                </div>
                            </div>
  
  </div>
                    
                    <div class="panel-body">
                    
                    <div class="col-sm-3 pull-right" style="padding-right:0;padding-bottom:10px;">
                 <form method="post">
                    <div class="input-group">
                      <input type="text" class="input-sm form-control" name="search" placeholder="<?php echo SEARCH ?>">
                      <span class="input-group-btn">
                        <button class="btn btn-sm btn-primary" type="submit"><?php echo GO ?>!</button>
                      </span>
                    </div>
                    </form>
                  </div>
                                
                                
                    <?php
// how many rows to show per page
$rowsPerPage = $config['rowsperpage'];

// by default we show first page
$pageNum = 1;

// if $_GET['page'] defined, use it as page number
if(isset($_GET['page']))
{
$pageNum = filter_var($_GET['page'], FILTER_SANITIZE_ENCODED);
}

// counting the offset
$offset = ($pageNum - 1) * $rowsPerPage;

$self = $_SERVER['PHP_SELF'];

if($_SERVER['REQUEST_METHOD'] =='POST')
{
$numrows = $db->fetchOne('Select count(*) as nums from dnsmanager where domain_name like "% :search %"', array(":search"=>$global->clean_input($_POST['search'])));

$result = $db->fetchAll("Select * from dnsmanager where domain_name like '% :search %' order by dnsid desc LIMIT ".$global->clean_pager($offset).", ".$global->clean_pager($rowsPerPage),array(":search"=>$global->clean_input($_POST['search'])));  
}
else
{
$numrows = $db->fetchOne('Select count(*) as nums from dnsmanager');
$result = $db->fetchAll("Select * from dnsmanager order by dnsid desc LIMIT ".$global->clean_pager($offset).", ".$global->clean_pager($rowsPerPage)); 
}

$maxPage = ceil($numrows['nums']/$rowsPerPage);
                 
$crud = new TableCrud($result);

$crud->AddHeaders(array(DNS_DOMAIN_NAME,CREATEDON,ACTIONS));

$crud->Table_Columns(array("domain_name","createdon","action"));

$crud->AddActionLinks(array(

array("linkdesc" =>"Edit A Records", "linkfile" => "editarecords.php", "linkparam" =>"dnsid", "linkalias" => "id", "linkcss" => "btn btn-primary", "linkicon" => "A", "target"=>"_self", "moreparams"=>"" ),

array("linkdesc" =>"Edit AAAA Records", "linkfile" => "editaaarecords.php", "linkparam" =>"dnsid", "linkalias" => "id", "linkcss" => "btn btn-primary", "linkicon" => "AAAA", "target"=>"_self", "moreparams"=>"" ),

array("linkdesc" =>"Edit CNAME Records", "linkfile" => "editcnamerecords.php", "linkparam" =>"dnsid", "linkalias" => "id", "linkcss" => "btn btn-primary", "linkicon" => "CNAME", "target"=>"_self", "moreparams"=>"" ),

array("linkdesc" =>"Edit MX Records", "linkfile" => "editmxrecords.php", "linkparam" =>"dnsid", "linkalias" => "id", "linkcss" => "btn btn-primary", "linkicon" => "MX", "target"=>"_self", "moreparams"=>"" ),

array("linkdesc" =>"Edit TXT Records", "linkfile" => "edittxtrecords.php", "linkparam" =>"dnsid", "linkalias" => "id", "linkcss" => "btn btn-primary", "linkicon" => "TXT", "target"=>"_self", "moreparams"=>"" ),

array("linkdesc" =>"Edit SRV Records", "linkfile" => "editsrvrecords.php", "linkparam" =>"dnsid", "linkalias" => "id", "linkcss" => "btn btn-primary", "linkicon" => "SRV", "target"=>"_self", "moreparams"=>"" ),

array("linkdesc" =>"Edit SPF Records", "linkfile" => "editspfrecords.php", "linkparam" =>"dnsid", "linkalias" => "id", "linkcss" => "btn btn-primary", "linkicon" => "SPF", "target"=>"_self", "moreparams"=>"" ),

array("linkdesc" =>"Edit NS Records", "linkfile" => "editnsrecords.php", "linkparam" =>"dnsid", "linkalias" => "id", "linkcss" => "btn btn-primary", "linkicon" => "NS", "target"=>"_self", "moreparams"=>"" ),

array("linkdesc" =>"Delete", "linkfile" => "delete.php", "linkparam" =>"dnsid", "linkalias" => "id", "linkcss" => "btn btn-danger", "linkicon" => "<i class='fa fa-trash-o'></i>", "target"=>"_self", "moreparams"=>"&type=15" )



));


$crud->FormatDate($config['dateformat'],"createdon","true");

echo $crud->GenrateTable();

echo $crud->Pagination($maxPage,$self);                 
              
                 
                 
               

?>           
                        
                        
                        
                     
                    </div>
                  
                
              </div>   
               
                
            </div>

        </div>
        
        <?php include 'include/footer.php' ?>