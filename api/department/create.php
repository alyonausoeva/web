<?php
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
if (
    !empty($data->department_id) &&
	!empty($data->department_name) &&
	!empty($data->department_officers) 
   
) {    
    $department->department_id = $data->department_id;
	$department->department_name = $data->department_name;
	$department->department_officers = $data->department_officers;	
	
   

  
    if($department->create()){        
        http_response_code(201);        
        echo json_encode(array("message" => "Запись была создана."), JSON_UNESCAPED_UNICODE);
    }   else {
        http_response_code(503);        
        echo json_encode(array("message" => "Невозможно создать запись."), JSON_UNESCAPED_UNICODE);
}}else {   
    http_response_code(400);    
    echo json_encode(array("message" => "Невозможно создать запись. Данные неполные."), JSON_UNESCAPED_UNICODE);
	}
	?>
 