<?php
header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8");

include_once '../config/database.php';
include_once '../objects/certificate.php';
$database = new Database();
$db = $database->getConnection();
$certificate = new Certificate($db);
$stmt = $certificate->read();
$num = $stmt->rowCount();

if ($num>0) {
    $certificate_arr=array();
    $certificate_arr["records"]=array();
    while ($row = $stmt->fetch(PDO::FETCH_ASSOC)){

        extract($row);
        $certificate_item=array(
         "certificate_id" => $certificate_id,
		"certificate_date" => $certificate_date,
		"contract_id" => $contract_id,
         "pay_id" => $pay_id 
		 
        );

        array_push($certificate_arr["records"], $certificate_item);
    }
    http_response_code(200);   
	
echo json_encode($certificate_arr);
    $result = [
        'data' => 'Просмотр записей',
        'date'=>date('Y-m-d H:i:s'),
        'type'=>$_SERVER["REQUEST_METHOD"],
        'status'=>http_response_code(201),
        'body'=> json_encode($data),
        'source'=>$_SERVER['REMOTE_ADDR']
    ];
}

else {
    http_response_code(404); 	
echo json_encode(array("message" => "Записи не найдены."), JSON_UNESCAPED_UNICODE);
    $result = [
        'data' => 'Записи не найдены.',
        'date'=>date('Y-m-d H:i:s'),
        'type'=>$_SERVER["REQUEST_METHOD"],
        'status'=>http_response_code(503),
        'body'=> json_encode($data),
        'source'=>$_SERVER['REMOTE_ADDR']
    ];
}
$servername = "std-mysql";
$username = "std_237";
$password = "Qaa123321@";
$dbname = "std_237";

$conn = new mysqli($servername, $username, $password, $dbname);

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

$sql = "INSERT INTO log (data, date, type, status, body, sourсe)
VALUES ('". $result['data'] ."', '". $result['date'] ."', '". $result['type'] ."','". $result['status'] ."', '". $result['body'] ."', '". $result['source'] ."')";


if ($conn->query($sql) === TRUE) {
    echo "Логирование произведено"  ;
} else {
    echo "Error: " . $sql . "<br>" . $conn->error;
}
$conn->close();
