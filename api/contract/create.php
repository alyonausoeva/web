<?php
header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8");
header("Access-Control-Allow-Methods: POST");
header("Access-Control-Max-Age: 3600");
header("Access-Control-Allow-Headers: Content-Type, Access-Control-Allow-Headers, Authorization, X-Requested-With");

include_once '../config/database.php';
include_once '../objects/contract.php';

$database = new Database();
$db = $database->getConnection();

$contract = new Contract($db);
$data = json_decode(file_get_contents("php://input"));
if (
    !empty($data->contract_id) &&
	!empty($data->klient_id) &&
	!empty($data->bd_id) && 
   !empty($data->contract_date)&& 
   !empty($data->contract_status)&& 
   !empty($data->officer_id)
   
) {    
    $contract->contract_id = $data->contract_id;
	$contract->klient_id = $data->klient_id;
	$contract->bd_id = $data->bd_id;	
	$contract->contract_date = $data->contract_date;	
	$contract->contract_status = $data->contract_status;	
	$contract->officer_id = $data->officer_id;	   

  
    if($contract->create()){        
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
 