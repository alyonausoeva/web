<?php
// необходимые HTTP-заголовки
header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8");
header("Access-Control-Allow-Methods: POST");
header("Access-Control-Max-Age: 3600");
header("Access-Control-Allow-Headers: Content-Type, Access-Control-Allow-Headers, Authorization, X-Requested-With");

include_once '../config/database.php';
include_once '../objects/officer.php';

$database = new Database();
$db = $database->getConnection();

$officer = new Officer($db);

$data = json_decode(file_get_contents("php://input"));

$officer->officer_id = $data->officer_id;
$officer->officer_name = $data->officer_name;
$officer->department_id = $data->department_id;
$officer->officer_pas = $data->officer_pas;
$officer->officer_date = $data->officer_date;
$officer->officer_level = $data->officer_level;


if ($officer->update()) {
    http_response_code(200);
    echo json_encode(array("message" => "Запись обновлена."), JSON_UNESCAPED_UNICODE);
} else {
    http_response_code(503);
    echo json_encode(array("message" => "Невозможно обновить запись"), JSON_UNESCAPED_UNICODE);
}
?>