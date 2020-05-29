<?php
// необходимые HTTP-заголовки
header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Headers: access");
header("Access-Control-Allow-Methods: GET");
header("Access-Control-Allow-Credentials: true");
header("Content-Type: officers/json");

include_once '../config/database.php';
include_once '../objects/pay.php';

$database = new Database();
$db = $database->getConnection();
$pay = new Pay($db);

// установим свойство ID записи для чтения
$pay->pay_id = isset($_GET['pay_id']) ? $_GET['pay_id'] : die();

// прочитаем детали товара для редактирования
$pay->readOne();

if ($pay->pay_sum!=null) {

    // создание массива
    $pay_arr = array(
       "pay_id"=>  $pay->pay_id,
        "pay_sum" => $pay->pay_sum,
        "pay_date" => $pay->pay_date
        
		
		 
    );

  
    http_response_code(200);

   
    echo json_encode($pay_arr);
}

else {
  
    http_response_code(404);

   
    echo json_encode(array("message" => "Товар не существует."), JSON_UNESCAPED_UNICODE);
}
?>