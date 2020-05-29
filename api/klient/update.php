<?php
// необходимые HTTP-заголовки
header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8");
header("Access-Control-Allow-Methods: POST");
header("Access-Control-Max-Age: 3600");
header("Access-Control-Allow-Headers: Content-Type, Access-Control-Allow-Headers, Authorization, X-Requested-With");

include_once '../config/database.php';
include_once '../objects/klient.php';

$database = new Database();
$db = $database->getConnection();

$klient = new Klient($db);

$data = json_decode(file_get_contents("php://input"));

$klient->klient_id = $data->klient_id;
$klient->klient_fio = $data->klient_fio;
$klient->klient_pas = $data->klient_pas;
$klient->klient_tel = $data->klient_tel;
$klient->klient_email = $data->klient_email;



if ($klient->update()) {
    http_response_code(200);
    echo json_encode(array("message" => "Запись обновлена."), JSON_UNESCAPED_UNICODE);
} else {
    http_response_code(503);
    echo json_encode(array("message" => "Невозможно обновить запись"), JSON_UNESCAPED_UNICODE);
}
?>