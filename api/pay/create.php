<?php
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
if (
    !empty($data->pay_id) &&
	!empty($data->pay_sum) &&
	!empty($data->pay_date) 
   
) {    
    $pay->pay_id = $data->pay_id;
	$pay->pay_sum = $data->pay_sum;
	$pay->pay_date = $data->pay_date;	
	
   

  
    if($pay->create()){        
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
 