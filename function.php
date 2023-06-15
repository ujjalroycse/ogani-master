
<?php 

function InputCount($table,$col,$value){
    global $connection;
    $stm = $connection->prepare("SELECT $col FROM $table WHERE $col=?");
    $stm->execute(array($value));
    $count=$stm->rowCount();

    return  $count;
}

//Get User Id
function getUserId($id){
    global $connection;
    $stm=$connection->prepare("SELECT * FROM users WHERE id=?");
    $stm->execute(array($id));
    $result=$stm->fetch(PDO::FETCH_ASSOC);
    return $result;
}

//Get Table Data
function getTableData($table){
    global $connection;
    $stm=$connection->prepare("SELECT * FROM $table WHERE user_id=?");
    $stm->execute(array($_SESSION['user']['id']));
    $result=$stm->fetchAll(PDO::FETCH_ASSOC);
    return $result;
}

//Get Table Data
function getAllTableData($table){
    global $connection;
    $stm=$connection->prepare("SELECT * FROM $table");
    $stm->execute(array());
    $result=$stm->fetchAll(PDO::FETCH_ASSOC);
    return $result;
}

//Get Delete Table Data
function deleteTableData($table,$id){
    global $connection;
    $stm=$connection->prepare("DELETE FROM $table WHERE user_id=? AND id=?");
    $delete = $stm->execute(array($_SESSION['user']['id'],$id));
    return $delete;
}

//get Single data
function getSingleData($table,$id){
    global $connection;
    $stm=$connection->prepare("SELECT * FROM $table WHERE user_id=? AND id=?");
    $stm->execute(array($_SESSION['user']['id'],$id));
    $return = $stm->fetch(PDO::FETCH_ASSOC);
    return $return;
}

//get Column Details data
function getColumnDetails($table,$col,$id){
    global $connection;
    $stm=$connection->prepare("SELECT $col FROM $table WHERE id=?");
    $stm->execute(array($id));
    $result = $stm->fetch(PDO::FETCH_ASSOC);
    return $result[$col];
}

//get Column Details data
// function getSingleValue($table,$col){
//     global $connection;
//     $stm=$connection->prepare("SELECT $col FROM $table WHERE id=?");
//     $stm->execute(array($id));
//     $result = $stm->fetch(PDO::FETCH_ASSOC);
//     return $result[$col];
// }


?>
