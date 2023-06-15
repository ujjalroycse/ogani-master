<?php 

session_start();
require_once('../../config.php');

deleteTableData('categories',$_REQUEST['id']);
$url = return_admin_url().'/categories?success=delete successful' ;
header("location:$url");


?>