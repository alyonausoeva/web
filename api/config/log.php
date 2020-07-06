<?php
session_start();
header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8");
include_once 'database.php';
include_once '../objects/officer.php';
 
$database = new Database();
$db = $database->getConnection();
$officer = new Officer($db);
 
$officer_id = isset($_POST['officer_id']) ? $_POST['officer_id'] : '';
$officer_pas = isset($_POST['officer_pas']) ? $_POST['officer_pas'] : '';
$param = array($officer_id, $officer_pas);
 
$stmt = $officer->logg($officer_id, $officer_pas);
$num = $stmt->rowCount();
 
 
if ($num > 0) {  
 
    $row = $stmt->fetch(PDO::FETCH_ASSOC);
        extract($row);
        if ($officer_level == 1){
            header( "Location: http://web.std-237.ist.mospolytech.ru/main.php" );
        } else if ($officer_level == 2) {
			 header( "Location: http://web.std-237.ist.mospolytech.ru/main2.html" );
		} else if ($officer_level == 3){
            header( "Location: http://web.std-237.ist.mospolytech.ru/main3.php" );

        }
      
    }
    else {
   $_SESSION['message']='ошибка входа';
    header( "Location: http://web.std-237.ist.mospolytech.ru/index.php" );
}
$servername = "std-mysql";
$username = "std_237";
$password = "Qaa123321@";
$dbname = "std_237";
 
$conn = new mysqli($servername, $username, $password, $dbname);
 
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}
$conn->close();
?>