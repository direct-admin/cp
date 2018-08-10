<?php include ('library/autoload.php');
include('include/sessioncheck.php');
include('include/header.php'); ?>

<div id="page-wrapper">
            <div class="row">
                <div class="col-lg-12">
                    <h1 class="page-header"><?php echo MANAGE_FTP_USERS  ?></h1>
                </div>
                <!-- /.col-lg-12 -->
            </div>
            <!-- /.row -->
            <div class="row">
             <div class="col-lg-12">
 
 
                    <div class="panel panel-default">
  <div class="panel-heading">
  
    <?php echo MANAGE_FTP_USERS  ?>
    
    <div class="pull-right">
                                <div class="btn-group">
                                    <button type="button" class="btn btn-default btn-xs dropdown-toggle" data-toggle="dropdown">
                                        Actions
                                        <span class="caret"></span>
                                    </button>
                                    <ul class="dropdown-menu pull-right" role="menu">
                                        <li><a href="addftpuser.php"><?php echo ADD_NEW_FTP_USER  ?></a>
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
$numrows = $db->fetchOne('Select count(*) as nums from ftpuser where ftpuser like "% :search %"', array(":search"=>$global->clean_input($_POST['search'])));
$result = $db->fetchAll("Select * from ftpuser where ftpuser like '% :search %' order by ftpid desc LIMIT ".$global->clean_pager($offset).", ".$global->clean_pager($rowsPerPage), array(":search"=>$global->clean_input($_POST['search']))); 
}
else
{
$numrows = $db->fetchOne('Select count(*) as nums from ftpuser');
$result = $db->fetchAll("Select * from ftpuser order by ftpid desc LIMIT ".$global->clean_pager($offset).", ".$global->clean_pager($rowsPerPage)); 
}

$maxPage = ceil($numrows['nums']/$rowsPerPage);
                 
$crud = new TableCrud($result);

$crud->AddHeaders(array(FTP_HOST,FTP_USER,HOME_DIRECTORY,CREATEDON,ACTIONS));

$crud->Table_Columns(array("domain","ftpuser","homedir","createdon","action"));

$crud->AddActionLinks(array(array("linkdesc" =>"Change Password", "linkfile" => "addftpuser.php", "linkparam" => "ftpid", "linkalias" => "id", "linkcss" => "btn btn-primary", "linkicon" => "<i class='fa fa-unlock'></i>", "target"=>"_self", "moreparams"=>"" ),
array("linkdesc" =>"Delete", "linkfile" => "delete.php", "linkparam" =>"ftpid", "linkalias" => "id", "linkcss" => "btn btn-danger", "linkicon" => "<i class='fa fa-trash-o'></i>", "target"=>"_self", "moreparams"=>"&type=1" )));



$crud->FormatDate($config['dateformat'],"createdon","true");

echo $crud->GenrateTable();

echo $crud->Pagination($maxPage,$self);                 
              
                 
                 
               

?>           
                        
                        
                        
                     
                    </div>
                  
                
              </div>   
               
                
            </div>

        </div>
        
        <?php include 'include/footer.php' ?>