<?php
header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8");

include_once '../config/database.php';
include_once '../objects/certificate.php';
$database = new Database();
$db = $database->getConnection();
$certificate = new Certificate($db);
$stmt = $certificate->read();
$num = $stmt->rowCount();

if ($num>0) {
    $certificate_arr=array();
    $certificate_arr["records"]=array();
    while ($row = $stmt->fetch(PDO::FETCH_ASSOC)){

        extract($row);
        $certificate_item=array(
         "certificate_id" => $certificate_id,
		"certificate_date" => $certificate_date,
		"contract_id" => $contract_id,
         "pay_id" => $pay_id 
		 
        );

        array_push($certificate_arr["records"], $certificate_item);
    }
    http_response_code(200);   
	
echo json_encode($certificate_arr);
}

else {
    http_response_code(404); 	
echo json_encode(array("message" => "Записи не найдены."), JSON_UNESCAPED_UNICODE);
}
