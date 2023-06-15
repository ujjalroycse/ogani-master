<?php 

session_start();
require_once('../../config.php');

deleteTableData('products',$_REQUEST['id']);
$url = return_admin_url().'/products?success=delete successful' ;
header("location:$url");


?>