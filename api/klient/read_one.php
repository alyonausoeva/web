<?php
// необходимые HTTP-заголовки
header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Headers: access");
header("Access-Control-Allow-Methods: GET");
header("Access-Control-Allow-Credentials: true");
header("Content-Type: application/json");

include_once '../config/database.php';
include_once '../objects/klient.php';

$database = new Database();
$db = $database->getConnection();
$klient = new Klient($db);

// установим свойство ID записи для чтения
$klient->klient_id = isset($_GET['klient_id']) ? $_GET['klient_id'] : die();

// прочитаем детали товара для редактирования
$klient->readOne();

if ($klient->klient_fio!=null) {

    // создание массива
    $klient_arr = array(
       "klient_id"=>  $klient->klient_id,
        "klient_fio" => $klient->klient_fio,
        "klient_pas" => $klient->klient_pas,
        "klient_tel" => $klient->klient_tel,
        "klient_email" => $klient->klient_email
       
		
		 
    );

  
    http_response_code(200);

   
    echo json_encode($klient_arr);
}

else {
  
    http_response_code(404);

   
    echo json_encode(array("message" => "Товар не существует."), JSON_UNESCAPED_UNICODE);
}
?>