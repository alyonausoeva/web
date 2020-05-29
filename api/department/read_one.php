<?php
// необходимые HTTP-заголовки
header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Headers: access");
header("Access-Control-Allow-Methods: GET");
header("Access-Control-Allow-Credentials: true");
header("Content-Type: officers/json");

include_once '../config/database.php';
include_once '../objects/department.php';

$database = new Database();
$db = $database->getConnection();
$department = new Department($db);

// установим свойство ID записи для чтения
$department->department_id = isset($_GET['department_id']) ? $_GET['department_id'] : die();

// прочитаем детали товара для редактирования
$department->readOne();

if ($department->department_name!=null) {

    // создание массива
    $department_arr = array(
       "department_id"=>  $department->department_id,
        "department_name" => $department->department_name,
        "department_officers" => $department->department_officers
        
		
		 
    );

  
    http_response_code(200);

   
    echo json_encode($department_arr);
}

else {
  
    http_response_code(404);

   
    echo json_encode(array("message" => "Товар не существует."), JSON_UNESCAPED_UNICODE);
}
?>