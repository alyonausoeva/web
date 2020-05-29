<?php
// необходимые HTTP-заголовки
header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8");

// подключение необходимых файлов
include_once '../config/core.php';
include_once '../config/database.php';
include_once '../objects/bd.php';
$database = new Database();
$db = $database->getConnection();
$bd = new Bd($db);

// получаем ключевые слова
$keywords=isset($_GET["s"]) ? $_GET["s"] : "";

// запрос товаров
$stmt = $bd->search($keywords);
$num = $stmt->rowCount();

// проверяем, найдено ли больше 0 записей
if ($num>0) {

    // массив товаров
    $bd_arr=array();
    $bd_arr["records"]=array();

    // получаем содержимое нашей таблицы
    // fetch() быстрее чем fetchAll()
    while ($row = $stmt->fetch(PDO::FETCH_ASSOC)){
        // извлечём строку
        extract($row);

                $bd_item=array(
         "bd_id" => $bd_id,
		"bd_name" => $bd_name,
		"bd_application" => $bd_application,
         "bd_volume" => $bd_volume 
		
		 
        );

        array_push($bd_arr["records"], $bd_item);
    }

    // код ответа - 200 OK
    http_response_code(200);

    // покажем товары
    echo json_encode($bd_arr);
}

else {
    // код ответа - 404 Ничего не найдено
    http_response_code(404);

    // скажем пользователю, что товары не найдены
    echo json_encode(array("message" => "Товары не найдены."), JSON_UNESCAPED_UNICODE);
}
?>