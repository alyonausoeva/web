<?php
// необходимые HTTP-заголовки
header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Headers: access");
header("Access-Control-Allow-Methods: GET");
header("Access-Control-Allow-Credentials: true");
header("Content-Type: application/json");

include_once '../config/database.php';
include_once '../objects/contract.php';

$database = new Database();
$db = $database->getConnection();
$contract = new Contract($db);

// установим свойство ID записи для чтения
$contract->contract_id = isset($_GET['contract_id']) ? $_GET['contract_id'] : die();

// прочитаем детали товара для редактирования
$contract->readOne();

if ($contract->klient_id!=null) {

    // создание массива
    $contract_arr = array(
       "contract_id"=>  $contract->contract_id,
        "klient_id" => $contract->klient_id,
        "bd_id" => $contract->bd_id,
        "contract_date" => $contract->contract_date,
        "contract_status" => $contract->contract_status,
        "officer_id" => $contract->officer_id
		
		 
    );

  
    http_response_code(200);

   
    echo json_encode($contract_arr);
}

else {
  
    http_response_code(404);

   
    echo json_encode(array("message" => "Товар не существует."), JSON_UNESCAPED_UNICODE);
}
?>