<?php
class Klient {

    private $conn;
	private $table_name = "klient";
		
	public $klient_id;
    public $klient_fio;
	public $klient_pas;
    public $klient_tel;	
    public $klient_email;
	
	
    public function __construct($db){
        $this->conn = $db;
		
    }

   function read(){
    $query = "SELECT * FROM
                " . $this->table_name;           
    $stmt = $this->conn->prepare($query);
    $stmt->execute();
    return $stmt;
}

  function create(){    
    $query = "INSERT INTO
                " . $this->table_name . "
            SET
                klient_id=:klient_id,
				klient_fio=:klient_fio, 
				klient_pas=:klient_pas, 
				klient_tel=:klient_tel,
				klient_email=:klient_email
				";  
				
    $stmt = $this->conn->prepare($query);    
	
    $this->klient_id=htmlspecialchars(strip_tags($this->klient_id));
    $this->klient_fio=htmlspecialchars(strip_tags($this->klient_fio));
	$this->klient_pas=htmlspecialchars(strip_tags($this->klient_pas));	
	
    $this->klient_tel=htmlspecialchars(strip_tags($this->klient_tel));
	$this->klient_email=htmlspecialchars(strip_tags($this->klient_email));
	
    
    $stmt->bindParam(":klient_id", $this->klient_id);
    $stmt->bindParam(":klient_fio", $this->klient_fio);
    $stmt->bindParam(":klient_pas", $this->klient_pas);	
	
	$stmt->bindParam(":klient_tel", $this->klient_tel);
    $stmt->bindParam(":klient_email", $this->klient_email);
	
	 
    if ($stmt->execute()) {return true; } return false;
}

    // используется при заполнении формы обновления товара
    function readOne() {

        // запрос для чтения одной записи (товара)
        $query = "SELECT  * FROM
                " . $this->table_name . " 
            WHERE
                klient_id = ?";

       
        $stmt = $this->conn->prepare( $query );

        // привязываем id товара, который будет обновлен
        $stmt->bindParam(1, $this->klient_id);

        // выполняем запрос
        $stmt->execute();

        // получаем извлеченную строку
        $row = $stmt->fetch(PDO::FETCH_ASSOC);

        // установим значения свойств объекта
        $this->klient_id = $row['klient_id'];
		$this->klient_fio = $row['klient_fio'];
		$this->klient_pas= $row['klient_pas'];
		$this->klient_tel= $row['klient_tel'];
		$this->klient_email= $row['klient_email'];	
		
        
    }

   function update(){
    $query = "UPDATE
                " . $this->table_name . "
            SET  
klient_id=:klient_id,			
            
				klient_fio=:klient_fio, 
				klient_pas=:klient_pas, 
				klient_tel=:klient_tel,
				klient_email=:klient_email
				
							
            WHERE
                 klient_id=:klient_id";

    $stmt = $this->conn->prepare($query);
	
    $this->klient_id=htmlspecialchars(strip_tags($this->klient_id));
    $this->klient_fio=htmlspecialchars(strip_tags($this->klient_fio));
	$this->klient_pas=htmlspecialchars(strip_tags($this->klient_pas));	
	
	$this->klient_tel=htmlspecialchars(strip_tags($this->klient_tel));	
	$this->klient_email=htmlspecialchars(strip_tags($this->klient_email));	

	
    
   $stmt->bindParam(":klient_id", $this->klient_id);
    $stmt->bindParam(":klient_fio", $this->klient_fio);
    $stmt->bindParam(":klient_pas", $this->klient_pas);	
	
	$stmt->bindParam(":klient_tel", $this->klient_tel);
    $stmt->bindParam(":klient_email", $this->klient_email);
	
    

    if ($stmt->execute()) {
        return true;
		}    return false;
	}
	
    function delete(){   
    $query = "DELETE FROM " . $this->table_name . " WHERE klient_id = ?";   
    $stmt = $this->conn->prepare($query);    
    $this->klient_id=htmlspecialchars(strip_tags($this->klient_id));    
    $stmt->bindParam(1, $this->klient_id);   
    if ($stmt->execute()) {
        return true;
    }
    return false;
}

    // метод search - поиск товаров
    function search($keywords){

        // выборка по всем записям
        $query = "SELECT
                *
            FROM
                " . $this->table_name . " 
            WHERE
                klient_id LIKE ? OR klient_fio LIKE ? OR klient_pas LIKE ? OR klient_tel LIKE ? OR klient_email LIKE ? ";

        // подготовка запроса
        $stmt = $this->conn->prepare($query);

        // очистка
        $keywords=htmlspecialchars(strip_tags($keywords));
        $keywords = "%{$keywords}%";

        // привязка
        $stmt->bindParam(1, $keywords);
        $stmt->bindParam(2, $keywords);
        $stmt->bindParam(3, $keywords);
		$stmt->bindParam(4, $keywords);
		$stmt->bindParam(5, $keywords);
		

        // выполняем запрос
        $stmt->execute();

        return $stmt;
    }

    // чтение товаров с пагинацией
    public function readPaging($from_record_num, $records_per_page){

        // выборка
        $query = "SELECT
                *
            FROM
                " . $this->table_name. " 
            LIMIT ?, ?";

        // подготовка запроса
        $stmt = $this->conn->prepare( $query );

        // свяжем значения переменных
        $stmt->bindParam(1, $from_record_num, PDO::PARAM_INT);
        $stmt->bindParam(2, $records_per_page, PDO::PARAM_INT);

        // выполняем запрос
        $stmt->execute();

        // вернём значения из базы данных
        return $stmt;
    }
    // используется для пагинации товаров
    public function count(){
        $query = "SELECT COUNT(*) as total_rows FROM " . $this->table_name . "";

        $stmt = $this->conn->prepare( $query );
        $stmt->execute();
        $row = $stmt->fetch(PDO::FETCH_ASSOC);

        return $row['total_rows'];
    }
}
?>