<?php
// необходимые HTTP-заголовки
header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Headers: access");
header("Access-Control-Allow-Methods: GET");
header("Access-Control-Allow-Credentials: true");
header("Content-Type: application/json");

include_once '../config/database.php';
include_once '../objects/officer.php';

$database = new Database();
$db = $database->getConnection();
$officer = new Officer($db);

// установим свойство ID записи для чтения
$officer->officer_id = isset($_GET['officer_id']) ? $_GET['officer_id'] : die();

// прочитаем детали товара для редактирования
$officer->readOne();

if ($officer->officer_name!=null) {

    // создание массива
    $officer_arr = array(
       "officer_id"=>  $officer->officer_id,
        "officer_name" => $officer->officer_name,
        "department_id" => $officer->department_id,
        "officer_pas" => $officer->officer_pas,
        "officer_date" => $officer->officer_date,
        "officer_level" => $officer->officer_level
		
		 
    );

  
    http_response_code(200);

   
    echo json_encode($officer_arr);
}

else {
  
    http_response_code(404);

   
    echo json_encode(array("message" => "Товар не существует."), JSON_UNESCAPED_UNICODE);
}
?>