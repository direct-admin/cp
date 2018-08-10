<?php include ('library/autoload.php');
include('include/sessioncheck.php');
include('include/header.php'); ?>

<div id="page-wrapper">
            <div class="row">
                <div class="col-lg-12">
                    <h1 class="page-header"><?php echo MANAGE_CRON_JOBS  ?></h1>
                </div>
                <!-- /.col-lg-12 -->
            </div>
            <!-- /.row -->
            <div class="row">
             <div class="col-lg-12">
 
 
                    <div class="panel panel-default">
  <div class="panel-heading">
  
    <?php echo MANAGE_CRON_JOBS  ?>
    
    <div class="pull-right">
                                <div class="btn-group">
                                    <button type="button" class="btn btn-default btn-xs dropdown-toggle" data-toggle="dropdown">
                                        Actions
                                        <span class="caret"></span>
                                    </button>
                                    <ul class="dropdown-menu pull-right" role="menu">
                                        <li><a href="addjob.php"><?php echo ADD_NEW_CRON_JOB  ?></a>
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
$numrows = $db->fetchOne('Select count(*) as nums from cronjobs where name like "% :search %"', array(":search"=>$global->clean_input($_POST['search'])));

$result = $db->fetchAll("Select * from cronjobs where name like '% :search %' order by jobid desc LIMIT ".$global->clean_pager($offset).", ".$global->clean_pager($rowsPerPage) ,array(":search"=>$global->clean_input($_POST['search']))); 
}
else
{
$numrows = $db->fetchOne('Select count(*) as nums from cronjobs');
$result = $db->fetchAll("Select * from cronjobs order by jobid desc LIMIT ".$global->clean_pager($offset).", ".$global->clean_pager($rowsPerPage)); 
}

$maxPage = ceil($numrows['nums']/$rowsPerPage);
                 
$crud = new TableCrud($result);

$crud->AddHeaders(array(CRON_NAME,CREATEDON,ACTIONS));

$crud->Table_Columns(array("name","createdon","action"));

$crud->AddActionLinks(array(

array("linkdesc" =>"Edit", "linkfile" => "addjob.php", "linkparam" =>"jobid", "linkalias" => "id", "linkcss" => "btn btn-primary", "linkicon" => "<i class='fa fa-pencil'></i>", "target"=>"_self", "moreparams"=>"" ),


array("linkdesc" =>"Delete", "linkfile" => "delete.php", "linkparam" =>"jobid", "linkalias" => "id", "linkcss" => "btn btn-danger", "linkicon" => "<i class='fa fa-trash-o'></i>", "target"=>"_self", "moreparams"=>"&type=7" )



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