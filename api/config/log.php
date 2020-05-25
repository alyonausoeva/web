<?php
header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8");
include_once 'database.php';
include_once '../objects/officer.php';

$database = new Database();
$db = $database->getConnection();
$officer = new officer($db);

$officer_id = isset($_POST['officer_id']) ? $_POST['officer_id'] : '';
$officer_pas = isset($_POST['officer_pas']) ? $_POST['officer_pas'] : '';
$param = array($officer_id, $officer_pas);

$stmt = $officer->logg($officer_id, $officer_pas);
$num = $stmt->rowCount();


if ($num > 0) {
    http_response_code(200);
    echo json_encode(array("message" => "Доступ разрешен"), JSON_UNESCAPED_UNICODE);
    session_start();
    $_SESSION['auth'] = true;
    $_SESSION['officer_id'] = $officer['officer_id'];
    $_SESSION['officer_level'] = $officer['officer_level'];
    include('main.php');

} else {
    http_response_code(404);
    echo json_encode(array("message" => "У вас не достаточно прав для доступа"), JSON_UNESCAPED_UNICODE);

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