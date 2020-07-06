<?php
header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8");

include_once __DIR__ . '/../config/database.php';
include_once __DIR__ . '/../objects/log.php';
$database = new Database();
$db = $database->getConnection();
$log = new Log($db);
$stmt = $log->read();
$num = $stmt->rowCount();

if ($num>0) {
    $log_arr=array();
    $log_arr["records"]=array();
    while ($row = $stmt->fetch(PDO::FETCH_ASSOC)){

        extract($row);
        $log_item=array(
            "data" => $data,
            "date" => $date,
            "type" => $type,
            "status" => $status ,
            "body" => $body


        );

        array_push($log_arr["records"], $log_item);
    }
    http_response_code(200);

    return $log_arr;
    //echo json_encode($log_arr, JSON_UNESCAPED_UNICODE);
}

else {

    return "Записи не найдены.";
}
