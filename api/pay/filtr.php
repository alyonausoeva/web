<?php
// необходимые HTTP-заголовки
header("Access-Control-Allow-Origin: *");
header("Content-Type: officers/json; charset=UTF-8");

// подключение необходимых файлов
include_once '../config/core.php';
include_once '../config/database.php';
include_once '../objects/pay.php';
$database = new Database();
$db = $database->getConnection();
$pay = new Pay($db);

// получаем ключевые слова
$keywords=isset($_GET["s"]) ? $_GET["s"] : '';

// запрос товаров
$stmt = $pay->filtr($keywords);
$num = $stmt->rowCount();

// проверяем, найдено ли больше 0 записей
if ($num>0) {

    // массив товаров
    $pay_arr=array();
    $pay_arr["records"]=array();

    // получаем содержимое нашей таблицы
    // fetch() быстрее чем fetchAll()
    while ($row = $stmt->fetch(PDO::FETCH_ASSOC)){
        // извлечём строку
        extract($row);

        $pay_item=array(
            "pay_id" => $pay_id,
            "pay_sum" => $pay_sum,
            "pay_date" => $pay_date


        );

        array_push($pay_arr["records"], $pay_item);
    }

    // код ответа - 200 OK
    http_response_code(200);

    // покажем товары
    echo json_encode($pay_arr);
}

else {
    // код ответа - 404 Ничего не найдено
    http_response_code(404);

    // скажем пользователю, что товары не найдены
    echo json_encode(array("message" => "Товары не найдены."), JSON_UNESCAPED_UNICODE);
}
?>