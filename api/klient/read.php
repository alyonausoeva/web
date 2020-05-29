<?php
header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8");

include_once '../config/database.php';
include_once '../objects/klient.php';
$database = new Database();
$db = $database->getConnection();
$klient = new Klient($db);
$stmt = $klient->read();
$num = $stmt->rowCount();

if ($num>0) {
    $klient_arr=array();
    $klient_arr["records"]=array();
    while ($row = $stmt->fetch(PDO::FETCH_ASSOC)){

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
    http_response_code(200);   
	
echo json_encode($klient_arr);
}

else {
    http_response_code(404); 	
echo json_encode(array("message" => "Записи не найдены."), JSON_UNESCAPED_UNICODE);
}
