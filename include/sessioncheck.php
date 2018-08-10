<?php $authid = $sess->get('authid');
$username = $sess->get('username');
$password = $sess->get('password');
if (empty($authid) || empty($username) || empty($password)){
$global->redirect('logout.php');
}