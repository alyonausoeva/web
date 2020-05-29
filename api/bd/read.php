<?php
header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8");

include_once '../config/database.php';
include_once '../objects/bd.php';
$database = new Database();
$db = $database->getConnection();
$bd = new Bd($db);
$stmt = $bd->read();
$num = $stmt->rowCount();

if ($num>0) {
    $bd_arr=array();
    $bd_arr["records"]=array();
    while ($row = $stmt->fetch(PDO::FETCH_ASSOC)){

        extract($row);
        $bd_item=array(
         "bd_id" => $bd_id,
		"bd_name" => $bd_name,
		"bd_application" => $bd_application,
         "bd_volume" => $bd_volume 
		 
        );

        array_push($bd_arr["records"], $bd_item);
    }
    http_response_code(200);   
	
echo json_encode($bd_arr);
}

else {
    http_response_code(404); 	
echo json_encode(array("message" => "Записи не найдены."), JSON_UNESCAPED_UNICODE);
}
