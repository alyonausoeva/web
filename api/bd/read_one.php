<?php
// необходимые HTTP-заголовки
header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Headers: access");
header("Access-Control-Allow-Methods: GET");
header("Access-Control-Allow-Credentials: true");
header("Content-Type: application/json");

include_once '../config/database.php';
include_once '../objects/bd.php';

$database = new Database();
$db = $database->getConnection();
$bd = new Bd($db);

// установим свойство ID записи для чтения
$bd->bd_id = isset($_GET['bd_id']) ? $_GET['bd_id'] : die();

// прочитаем детали товара для редактирования
$bd->readOne();

if ($bd->bd_name!=null) {

    // создание массива
    $bd_arr = array(
       "bd_id"=>  $bd->bd_id,
        "bd_name" => $bd->bd_name,
        "bd_application" => $bd->bd_application,
        "bd_volume" => $bd->bd_volume
		
		 
    );

  
    http_response_code(200);

   
    echo json_encode($bd_arr);
}

else {
  
    http_response_code(404);

   
    echo json_encode(array("message" => "Товар не существует."), JSON_UNESCAPED_UNICODE);
}
?>