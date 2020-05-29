<?php
header("Access-Control-Allow-Origin: *");
header("Content-Type: officers/json; charset=UTF-8");

include_once '../config/database.php';
include_once '../objects/department.php';
$database = new Database();
$db = $database->getConnection();
$department = new Department($db);
$stmt = $department->read();
$num = $stmt->rowCount();

if ($num>0) {
    $department_arr=array();
    $department_arr["records"]=array();
    while ($row = $stmt->fetch(PDO::FETCH_ASSOC)){

        extract($row);
        $department_item=array(
         "department_id" => $department_id,
		"department_name" => $department_name,
		"department_officers" => $department_officers
        
		 
        );

        array_push($department_arr["records"], $department_item);
    }
    http_response_code(200);   
	
echo json_encode($department_arr);
}

else {
    http_response_code(404); 	
echo json_encode(array("message" => "Записи не найдены."), JSON_UNESCAPED_UNICODE);
}
