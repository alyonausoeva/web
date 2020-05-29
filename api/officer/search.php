<?php
// необходимые HTTP-заголовки
header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8");

// подключение необходимых файлов
include_once '../config/core.php';
include_once '../config/database.php';
include_once '../objects/officer.php';
$database = new Database();
$db = $database->getConnection();
$officer = new Officer($db);

// получаем ключевые слова
$keywords=isset($_GET["s"]) ? $_GET["s"] : "";

// запрос товаров
$stmt = $officer->search($keywords);
$num = $stmt->rowCount();

// проверяем, найдено ли больше 0 записей
if ($num>0) {

    // массив товаров
    $officer_arr=array();
    $officer_arr["records"]=array();

    // получаем содержимое нашей таблицы
    // fetch() быстрее чем fetchAll()
    while ($row = $stmt->fetch(PDO::FETCH_ASSOC)){
        // извлечём строку
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

    // код ответа - 200 OK
    http_response_code(200);

    // покажем товары
    echo json_encode($officer_arr);
}

else {
    // код ответа - 404 Ничего не найдено
    http_response_code(404);

    // скажем пользователю, что товары не найдены
    echo json_encode(array("message" => "Товары не найдены."), JSON_UNESCAPED_UNICODE);
}
?>