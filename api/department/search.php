<?php
// необходимые HTTP-заголовки
header("Access-Control-Allow-Origin: *");
header("Content-Type: officers/json; charset=UTF-8");

// подключение необходимых файлов
include_once '../config/core.php';
include_once '../config/database.php';
include_once '../objects/department.php';
$database = new Database();
$db = $database->getConnection();
$department = new Department($db);

// получаем ключевые слова
$keywords=isset($_GET["s"]) ? $_GET["s"] : "";

// запрос товаров
$stmt = $department->search($keywords);
$num = $stmt->rowCount();

// проверяем, найдено ли больше 0 записей
if ($num>0) {

    // массив товаров
    $department_arr=array();
    $department_arr["records"]=array();

    // получаем содержимое нашей таблицы
    // fetch() быстрее чем fetchAll()
    while ($row = $stmt->fetch(PDO::FETCH_ASSOC)){
        // извлечём строку
        extract($row);

                $department_item=array(
         "department_id" => $department_id,
		"department_name" => $department_name,
		"department_officers" => $department_officers
		
		 
        );

        array_push($department_arr["records"], $department_item);
    }

    // код ответа - 200 OK
    http_response_code(200);

    // покажем товары
    echo json_encode($department_arr);
}

else {
    // код ответа - 404 Ничего не найдено
    http_response_code(404);

    // скажем пользователю, что товары не найдены
    echo json_encode(array("message" => "Товары не найдены."), JSON_UNESCAPED_UNICODE);
}
?>