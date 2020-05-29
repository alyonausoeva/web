<?php
header("Access-Control-Allow-Origin: *");
header("Content-Type: officers/json; charset=UTF-8");

include_once '../config/database.php';
include_once '../objects/pay.php';
$database = new Database();
$db = $database->getConnection();
$pay = new Pay($db);
$stmt = $pay->read();
$num = $stmt->rowCount();

if ($num>0) {
    $pay_arr=array();
    $pay_arr["records"]=array();
    while ($row = $stmt->fetch(PDO::FETCH_ASSOC)){

        extract($row);
        $pay_item=array(
         "pay_id" => $pay_id,
		"pay_sum" => $pay_sum,
		"pay_date" => $pay_date
        
		 
        );

        array_push($pay_arr["records"], $pay_item);
    }
    http_response_code(200);   
	
echo json_encode($pay_arr);
}

else {
    http_response_code(404); 	
echo json_encode(array("message" => "Записи не найдены."), JSON_UNESCAPED_UNICODE);
}
