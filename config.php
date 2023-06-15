<?php  
$hostname = "localhost";
$database = "ogani_master";
$username = "root";
$password = "";

try{
    $connection = new PDO("mysql:host=$hostname;dbname=$database", $username, $password);
    // set the PDO error mode to exception
    $connection->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION); 
}
catch(PDOException $e){
    echo "Connection failed: " . $e->getMessage();
}

require_once('function.php');

function get_header(){
    require_once('../includes/header.php');
}
function get_footer(){
    require_once('../includes/footer.php');
}

function echo_admin_url(){
    echo "http://localhost/ogani-master/admin";
}
function return_admin_url(){
    return "http://localhost/ogani-master/admin";
}



?>


 