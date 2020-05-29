<?php
// необходимые HTTP-заголовки
header("Access-Control-Allow-Origin: *");
header("Content-Type: officers/json; charset=UTF-8");
header("Access-Control-Allow-Methods: POST");
header("Access-Control-Max-Age: 3600");
header("Access-Control-Allow-Headers: Content-Type, Access-Control-Allow-Headers, Authorization, X-Requested-With");

include_once '../config/database.php';
include_once '../objects/department.php';

$database = new Database();
$db = $database->getConnection();

$department = new Department($db);

$data = json_decode(file_get_contents("php://input"));

$department->department_id = $data->department_id;
$department->department_name = $data->department_name;
$department->department_officers = $data->department_officers;




if ($department->update()) {
    http_response_code(200);
    echo json_encode(array("message" => "Запись обновлена."), JSON_UNESCAPED_UNICODE);
} else {
    http_response_code(503);
    echo json_encode(array("message" => "Невозможно обновить запись"), JSON_UNESCAPED_UNICODE);
}
?>