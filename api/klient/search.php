<?php
// необходимые HTTP-заголовки
header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8");

// подключение необходимых файлов
include_once '../config/core.php';
include_once '../config/database.php';
include_once '../objects/klient.php';
$database = new Database();
$db = $database->getConnection();
$klient = new Klient($db);

// получаем ключевые слова
$keywords=isset($_GET["s"]) ? $_GET["s"] : "";

// запрос товаров
$stmt = $klient->search($keywords);
$num = $stmt->rowCount();

// проверяем, найдено ли больше 0 записей
if ($num>0) {

    // массив товаров
    $klient_arr=array();
    $klient_arr["records"]=array();

    // получаем содержимое нашей таблицы
    // fetch() быстрее чем fetchAll()
    while ($row = $stmt->fetch(PDO::FETCH_ASSOC)){
        // извлечём строку
        extract($row);

                $klient_item=array(
         "klient_id" => $klient_id,
		"klient_fio" => $klient_fio,
		"klient_pas" => $klient_pas,
         "klient_tel" => $klient_tel ,
		 "klient_email" => $klient_email 
		
		 
        );

        array_push($klient_arr["records"], $klient_item);
    }

    // код ответа - 200 OK
    http_response_code(200);

    // покажем товары
    echo json_encode($klient_arr);
}

else {
    // код ответа - 404 Ничего не найдено
    http_response_code(404);

    // скажем пользователю, что товары не найдены
    echo json_encode(array("message" => "Товары не найдены."), JSON_UNESCAPED_UNICODE);
}
?>