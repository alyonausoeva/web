<?php
// необходимые HTTP-заголовки
header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8");

// подключение файлов
include_once '../config/core.php';
include_once '../shared/utilities.php';
include_once '../config/database.php';
include_once '../objects/contract.php';

// utilities
$utilities = new Utilities();

// создание подключения
$database = new Database();
$db = $database->getConnection();

// инициализация объекта
$contract = new Contract($db);

// запрос товаров
$stmt = $contract->readPaging($from_record_num, $records_per_page);
$num = $stmt->rowCount();

// если больше 0 записей
if ($num>0) {

    // массив товаров
    $contract_arr=array();
    $contract_arr["records"]=array();
    $contract_arr["paging"]=array();

    // получаем содержимое нашей таблицы
    while ($row = $stmt->fetch(PDO::FETCH_ASSOC)){
        // извлечение строки
        extract($row);

       $contract_item=array(
         "contract_id" => $contract_id,
		"klient_id" => $klient_id,
		"bd_id" => $bd_id,
         "contract_date" => $contract_date ,
		 "contract_status" => $contract_status ,
		 "officer_id" => $officer_id 
		 
        );

        array_push($contract_arr["records"], $contract_item);
    }

    // подключим пагинацию
    $total_rows=$contract->count();
    $page_url="{$home_url}contract/read_paging.php?";
    $paging=$utilities->getPaging($page, $total_rows, $records_per_page, $page_url);
    $contract_arr["paging"]=$paging;

    // установим код ответа - 200 OK
    http_response_code(200);

    // вывод в json-формате
    echo json_encode($contract_arr);
} else {

    // код ответа - 404 Ничего не найдено
    http_response_code(404);

    // сообщим пользователю, что товаров не существует
    echo json_encode(array("message" => "Товары не найдены."), JSON_UNESCAPED_UNICODE);
}
?>