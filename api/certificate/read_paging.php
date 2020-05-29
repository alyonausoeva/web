<?php
// необходимые HTTP-заголовки
header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8");

// подключение файлов
include_once '../config/core.php';
include_once '../shared/utilities.php';
include_once '../config/database.php';
include_once '../objects/certificate.php';

// utilities
$utilities = new Utilities();

// создание подключения
$database = new Database();
$db = $database->getConnection();

// инициализация объекта
$certificate = new Certificate($db);

// запрос товаров
$stmt = $certificate->readPaging($from_record_num, $records_per_page);
$num = $stmt->rowCount();

// если больше 0 записей
if ($num>0) {

    // массив товаров
    $certificate_arr=array();
    $certificate_arr["records"]=array();
    $certificate_arr["paging"]=array();

    // получаем содержимое нашей таблицы
    while ($row = $stmt->fetch(PDO::FETCH_ASSOC)){
        // извлечение строки
        extract($row);

       $certificate_item=array(
         "certificate_id" => $certificate_id,
		"certificate_date" => $certificate_date,
		"contract_id" => $contract_id,
         "pay_id" => $pay_id 
		 
        );

        array_push($certificate_arr["records"], $certificate_item);
    }

    // подключим пагинацию
    $total_rows=$certificate->count();
    $page_url="{$home_url}certificate/read_paging.php?";
    $paging=$utilities->getPaging($page, $total_rows, $records_per_page, $page_url);
    $certificate_arr["paging"]=$paging;

    // установим код ответа - 200 OK
    http_response_code(200);

    // вывод в json-формате
    echo json_encode($certificate_arr);
} else {

    // код ответа - 404 Ничего не найдено
    http_response_code(404);

    // сообщим пользователю, что товаров не существует
    echo json_encode(array("message" => "Товары не найдены."), JSON_UNESCAPED_UNICODE);
}
?>