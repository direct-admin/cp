<?php include ('library/autoload.php');
include('include/sessioncheck.php');
include('include/header.php'); ?>

<div id="page-wrapper">
            <div class="row">
                <div class="col-lg-12">
                    <h1 class="page-header"><?php echo MANAGE_MAILBOXES  ?></h1>
                </div>
                <!-- /.col-lg-12 -->
            </div>
            <!-- /.row -->
            <div class="row">
             <div class="col-lg-12">
 
 
                    <div class="panel panel-default">
  <div class="panel-heading">
  
    <?php echo MANAGE_MAILBOXES  ?>
    
    <div class="pull-right">
                                <div class="btn-group">
                                    <button type="button" class="btn btn-default btn-xs dropdown-toggle" data-toggle="dropdown">
                                        Actions
                                        <span class="caret"></span>
                                    </button>
                                    <ul class="dropdown-menu pull-right" role="menu">
                                        <li><a href="addmailbox.php"><?php echo ADD_NEW_MAILBOX  ?></a>
                                        </li>
                                        
                                      
                                        
                                    </ul>
                                </div>
                            </div>
  
  </div>
                    
                    <div class="panel-body">
                    
                    
<div class="alert alert-info"><i class="fa fa-ok-sign"></i><strong><?php echo MAIL_BOX_SETTINGS  ?></strong>&nbsp;&nbsp;<br>

<strong><?php echo EMAIL_USERNAME  ?></strong> : youremailid@domain.tld <br>

<strong><?php echo MAILBOX_PASSWORD  ?></strong> : ************<br>

<strong><?php echo INCOMING_SERVER  ?></strong> : <?php echo $system['fqdn']  ?> (IMAP Port : 143, POP3 Port : 110)<br>

<strong><?php echo OUTGOING_SERVER  ?></strong> : <?php echo $system['fqdn']  ?> (SMTP Port : 25)<br>

<strong><?php echo AUTH_MESSAGE  ?></strong>



</div>
                    
                    
                    
                    
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
$numrows = $db->fetchOne('Select count(*) as nums from mailboxes where mailboxname like "% :search %"', array(":search"=>$global->clean_input($_POST['search'])));
$result = $db->fetchAll("Select * from mailboxes where mailboxname like '% :search %' order by mailboxid desc LIMIT ".$global->clean_pager($offset).", ".$global->clean_pager($rowsPerPage) , array(":search"=>$global->clean_input($_POST['search'])));
}
else
{
$numrows = $db->fetchOne('Select count(*) as nums from mailboxes');
$result = $db->fetchAll("Select * from mailboxes order by mailboxid desc LIMIT ".$global->clean_pager($offset).", ".$global->clean_pager($rowsPerPage)); 
}

$maxPage = ceil($numrows['nums']/$rowsPerPage);
                 
$crud = new TableCrud($result);

$crud->AddHeaders(array(MAILBOX_NAME,CREATEDON,ACTIONS));

$crud->Table_Columns(array("mailboxname","createdon","action"));

$crud->AddActionLinks(array(array("linkdesc" =>"Change Password", "linkfile" => "addmailbox.php", "linkparam" => "mailboxid", "linkalias" => "id", "linkcss" => "btn btn-primary", "linkicon" => "<i class='fa fa-unlock'></i>", "target"=>"_self", "moreparams"=>"" ),
array("linkdesc" =>"WebMail", "linkfile" => "APP/webmail/index.php", "linkparam" =>"", "linkalias" => "", "linkcss" => "btn btn-success", "linkicon" => "<i class='fa fa-envelope'></i>", "target"=>"_blank", "moreparams"=>"" ),
array("linkdesc" =>"Delete", "linkfile" => "delete.php", "linkparam" =>"mailboxid", "linkalias" => "id", "linkcss" => "btn btn-danger", "linkicon" => "<i class='fa fa-trash-o'></i>", "target"=>"_self", "moreparams"=>"&type=0" )));


$crud->CombineColumns(array("mailboxname","domain"),"@","mailboxname");

$crud->FormatDate($config['dateformat'],"createdon","true");

echo $crud->GenrateTable();

echo $crud->Pagination($maxPage,$self);                 
              
                 
                 
               

?>           
                        
                        
                        
                     
                    </div>
                  
                
              </div>   
               
                
            </div>

        </div>
        
        <?php include 'include/footer.php' ?>