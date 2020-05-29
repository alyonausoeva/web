<?php
// необходимые HTTP-заголовки
header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8");

// подключение файлов
include_once '../config/core.php';
include_once '../shared/utilities.php';
include_once '../config/database.php';
include_once '../objects/bd.php';

// utilities
$utilities = new Utilities();

// создание подключения
$database = new Database();
$db = $database->getConnection();

// инициализация объекта
$bd = new Bd($db);

// запрос товаров
$stmt = $bd->readPaging($from_record_num, $records_per_page);
$num = $stmt->rowCount();

// если больше 0 записей
if ($num>0) {

    // массив товаров
    $bd_arr=array();
    $bd_arr["records"]=array();
    $bd_arr["paging"]=array();

    // получаем содержимое нашей таблицы
    while ($row = $stmt->fetch(PDO::FETCH_ASSOC)){
        // извлечение строки
        extract($row);

       $bd_item=array(
         "bd_id" => $bd_id,
		"bd_name" => $bd_name,
		"bd_application" => $bd_application,
         "bd_volume" => $bd_volume 
		 
        );

        array_push($bd_arr["records"], $bd_item);
    }

    // подключим пагинацию
    $total_rows=$bd->count();
    $page_url="{$home_url}bd/read_paging.php?";
    $paging=$utilities->getPaging($page, $total_rows, $records_per_page, $page_url);
    $bd_arr["paging"]=$paging;

    // установим код ответа - 200 OK
    http_response_code(200);

    // вывод в json-формате
    echo json_encode($bd_arr);
} else {

    // код ответа - 404 Ничего не найдено
    http_response_code(404);

    // сообщим пользователю, что товаров не существует
    echo json_encode(array("message" => "Товары не найдены."), JSON_UNESCAPED_UNICODE);
}
?>