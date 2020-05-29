<?php
header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8");

include_once '../config/database.php';
include_once '../objects/officer.php';
$database = new Database();
$db = $database->getConnection();
$officer = new Officer($db);
$stmt = $officer->read();
$num = $stmt->rowCount();

if ($num>0) {
    $officer_arr=array();
    $officer_arr["records"]=array();
    while ($row = $stmt->fetch(PDO::FETCH_ASSOC)){

        extract($row);
        $officer_item=array(
         "officer_id" => $officer_id,
		"officer_name" => $officer_name,
		"department_id" => $department_id,
         "officer_pas" => $officer_pas ,
		 "officer_date" => $officer_date ,
		 "officer_level" => $officer_level 
		 
        );

        array_push($officer_arr["records"], $officer_item);
    }
    http_response_code(200);   
	
echo json_encode($officer_arr);
}

else {
    http_response_code(404); 	
echo json_encode(array("message" => "Записи не найдены."), JSON_UNESCAPED_UNICODE);
}
