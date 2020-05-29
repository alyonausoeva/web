<?php
// необходимые HTTP-заголовки
header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8");

// подключение необходимых файлов
include_once '../config/core.php';
include_once '../config/database.php';
include_once '../objects/contract.php';
$database = new Database();
$db = $database->getConnection();
$contract = new Contract($db);

// получаем ключевые слова
$keywords=isset($_GET["s"]) ? $_GET["s"] : "";

// запрос товаров
$stmt = $contract->search($keywords);
$num = $stmt->rowCount();

// проверяем, найдено ли больше 0 записей
if ($num>0) {

    // массив товаров
    $contract_arr=array();
    $contract_arr["records"]=array();

    // получаем содержимое нашей таблицы
    // fetch() быстрее чем fetchAll()
    while ($row = $stmt->fetch(PDO::FETCH_ASSOC)){
        // извлечём строку
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

    // код ответа - 200 OK
    http_response_code(200);

    // покажем товары
    echo json_encode($contract_arr);
}

else {
    // код ответа - 404 Ничего не найдено
    http_response_code(404);

    // скажем пользователю, что товары не найдены
    echo json_encode(array("message" => "Товары не найдены."), JSON_UNESCAPED_UNICODE);
}
?>