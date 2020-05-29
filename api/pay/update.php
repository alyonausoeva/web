<?php
// необходимые HTTP-заголовки
header("Access-Control-Allow-Origin: *");
header("Content-Type: officers/json; charset=UTF-8");
header("Access-Control-Allow-Methods: POST");
header("Access-Control-Max-Age: 3600");
header("Access-Control-Allow-Headers: Content-Type, Access-Control-Allow-Headers, Authorization, X-Requested-With");

include_once '../config/database.php';
include_once '../objects/pay.php';

$database = new Database();
$db = $database->getConnection();

$pay = new Pay($db);

$data = json_decode(file_get_contents("php://input"));

$pay->pay_id = $data->pay_id;
$pay->pay_sum = $data->pay_sum;
$pay->pay_date = $data->pay_date;




if ($pay->update()) {
    http_response_code(200);
    echo json_encode(array("message" => "Запись обновлена."), JSON_UNESCAPED_UNICODE);
} else {
    http_response_code(503);
    echo json_encode(array("message" => "Невозможно обновить запись"), JSON_UNESCAPED_UNICODE);
}
?>