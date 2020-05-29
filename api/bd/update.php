<?php
// необходимые HTTP-заголовки
header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8");
header("Access-Control-Allow-Methods: POST");
header("Access-Control-Max-Age: 3600");
header("Access-Control-Allow-Headers: Content-Type, Access-Control-Allow-Headers, Authorization, X-Requested-With");

include_once '../config/database.php';
include_once '../objects/bd.php';

$database = new Database();
$db = $database->getConnection();

$bd = new Bd($db);

$data = json_decode(file_get_contents("php://input"));

$bd->bd_id = $data->bd_id;
$bd->bd_name = $data->bd_name;
$bd->bd_application = $data->bd_application;
$bd->bd_volume = $data->bd_volume;



if ($bd->update()) {
    http_response_code(200);
    echo json_encode(array("message" => "Запись обновлена."), JSON_UNESCAPED_UNICODE);
} else {
    http_response_code(503);
    echo json_encode(array("message" => "Невозможно обновить запись"), JSON_UNESCAPED_UNICODE);
}
?>