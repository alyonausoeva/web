<?php
header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8");

include_once '../config/database.php';
include_once '../objects/contract.php';
$database = new Database();
$db = $database->getConnection();
$contract = new Contract($db);
$stmt = $contract->read();
$num = $stmt->rowCount();

if ($num>0) {
    $contract_arr=array();
    $contract_arr["records"]=array();
    while ($row = $stmt->fetch(PDO::FETCH_ASSOC)){

        extract($row);
        $contract_item=array(
         "contract_id" => $contract_id,
		"klient_id" => $klient_id,
		"bd_id" => $bd_id,
         "contract_date" => $contract_date ,
		 "contract_status" => $contract_status ,
		 "officer_id" => $officer_id 
		 
        );

        array_push($contract_arr["records"], $contract_item);
    }
    http_response_code(200);   
	
echo json_encode($contract_arr);
}

else {
    http_response_code(404); 	
echo json_encode(array("message" => "Записи не найдены."), JSON_UNESCAPED_UNICODE);
}
