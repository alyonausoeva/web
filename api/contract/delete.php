<?php
// необходимые HTTP-заголовки
header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8");
header("Access-Control-Allow-Methods: POST");
header("Access-Control-Max-Age: 3600");
header("Access-Control-Allow-Headers: Content-Type, Access-Control-Allow-Headers, Authorization, X-Requested-With");

include_once '../config/database.php';
include_once '../objects/contract.php';
$database = new Database();
$db = $database->getConnection();
$contract = new contract($db);
$data = json_decode(file_get_contents("php://input"));

$contract->contract_id = $data->contract_id;

if ($contract->delete()) {
    http_response_code(200);    
    echo json_encode(array("message" => "Запись была удалёна."), JSON_UNESCAPED_UNICODE);
    $result = [
        'data' => 'Запись была удалёна',
        'date'=>date('Y-m-d H:i:s'),
        'type'=>$_SERVER["REQUEST_METHOD"],
        'status'=>http_response_code(201),
        'body'=> json_encode($data),
        'source'=>$_SERVER['REMOTE_ADDR']
    ];
}else {
    http_response_code(503);
    echo json_encode(array("message" => "Не удалось удалить товар."));
    $result = [
        'data' => 'Не удалось удалить запись.',
        'date'=>date('Y-m-d H:i:s'),
        'type'=>$_SERVER["REQUEST_METHOD"],
        'status'=>http_response_code(503),
        'body'=> json_encode($data),
        'source'=>$_SERVER['REMOTE_ADDR']
    ];
}
$servername = "std-mysql";
$username = "std_237";
$password = "Qaa123321@";
$dbname = "std_237";

$conn = new mysqli($servername, $username, $password, $dbname);

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

$sql = "INSERT INTO log (data, date, type, status, body, sourсe)
VALUES ('". $result['data'] ."', '". $result['date'] ."', '". $result['type'] ."','". $result['status'] ."', '". $result['body'] ."', '". $result['source'] ."')";


if ($conn->query($sql) === TRUE) {
    echo "Логирование произведено"  ;
} else {
    echo "Error: " . $sql . "<br>" . $conn->error;
}
$conn->close();
?>