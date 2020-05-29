<?php
// необходимые HTTP-заголовки
header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Headers: access");
header("Access-Control-Allow-Methods: GET");
header("Access-Control-Allow-Credentials: true");
header("Content-Type: application/json");

include_once '../config/database.php';
include_once '../objects/certificate.php';

$database = new Database();
$db = $database->getConnection();
$certificate = new Certificate($db);

// установим свойство ID записи для чтения
$certificate->certificate_id = isset($_GET['certificate_id']) ? $_GET['certificate_id'] : die();

// прочитаем детали товара для редактирования
$certificate->readOne();

if ($certificate->certificate_date!=null) {

    // создание массива
    $certificate_arr = array(
       "certificate_id"=>  $certificate->certificate_id,
        "certificate_date" => $certificate->certificate_date,
        "contract_id" => $certificate->contract_id,
        "pay_id" => $certificate->pay_id
		
		 
    );

  
    http_response_code(200);

   
    echo json_encode($certificate_arr);
}

else {
  
    http_response_code(404);

   
    echo json_encode(array("message" => "Товар не существует."), JSON_UNESCAPED_UNICODE);
}
?>