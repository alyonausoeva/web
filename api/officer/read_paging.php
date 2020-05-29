<?php
// необходимые HTTP-заголовки
header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8");

// подключение файлов
include_once '../config/core.php';
include_once '../shared/utilities.php';
include_once '../config/database.php';
include_once '../objects/officer.php';

// utilities
$utilities = new Utilities();

// создание подключения
$database = new Database();
$db = $database->getConnection();

// инициализация объекта
$officer = new Officer($db);

// запрос товаров
$stmt = $officer->readPaging($from_record_num, $records_per_page);
$num = $stmt->rowCount();

// если больше 0 записей
if ($num>0) {

    // массив товаров
    $officer_arr=array();
    $officer_arr["records"]=array();
    $officer_arr["paging"]=array();

    // получаем содержимое нашей таблицы
    while ($row = $stmt->fetch(PDO::FETCH_ASSOC)){
        // извлечение строки
        extract($row);

       $officer_item=array(
         "officer_id" => $officer_id,
		"officer_name" => $officer_name,
		"department_id" => $department_id,
         "officer_pas" => $officer_pas ,
		 "officer_date" => $officer_date ,
		 "officer_level" => $officer_level 
		 
        );

        array_push($officer_arr["records"], $officer_item);
    }

    // подключим пагинацию
    $total_rows=$officer->count();
    $page_url="{$home_url}officer/read_paging.php?";
    $paging=$utilities->getPaging($page, $total_rows, $records_per_page, $page_url);
    $officer_arr["paging"]=$paging;

    // установим код ответа - 200 OK
    http_response_code(200);

    // вывод в json-формате
    echo json_encode($officer_arr);
} else {

    // код ответа - 404 Ничего не найдено
    http_response_code(404);

    // сообщим пользователю, что товаров не существует
    echo json_encode(array("message" => "Товары не найдены."), JSON_UNESCAPED_UNICODE);
}
?>