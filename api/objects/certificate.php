<?php
class Certificate {

    private $conn;
	private $table_name = "certificate";
		
	public $certificate_id;
    public $certificate_date;
	public $contract_id;
    public $pay_id;	
   
	
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
                certificate_id=:certificate_id,
				certificate_date=:certificate_date, 
				contract_id=:contract_id, 
				pay_id=:pay_id
				";  
				
    $stmt = $this->conn->prepare($query);    
	
    $this->certificate_id=htmlspecialchars(strip_tags($this->certificate_id));
    $this->certificate_date=htmlspecialchars(strip_tags($this->certificate_date));
	$this->contract_id=htmlspecialchars(strip_tags($this->contract_id));	
	
    $this->pay_id=htmlspecialchars(strip_tags($this->pay_id));
	
    
    $stmt->bindParam(":certificate_id", $this->certificate_id);
    $stmt->bindParam(":certificate_date", $this->certificate_date);
    $stmt->bindParam(":contract_id", $this->contract_id);	
	
	$stmt->bindParam(":pay_id", $this->pay_id);
    
	 
    if ($stmt->execute()) {return true; } return false;
}

    // используется при заполнении формы обновления товара
    function readOne() {

        // запрос для чтения одной записи (товара)
        $query = "SELECT  * FROM
                " . $this->table_name . " 
            WHERE
                certificate_id = ?";

       
        $stmt = $this->conn->prepare( $query );

        // привязываем id товара, который будет обновлен
        $stmt->bindParam(1, $this->certificate_id);

        // выполняем запрос
        $stmt->execute();

        // получаем извлеченную строку
        $row = $stmt->fetch(PDO::FETCH_ASSOC);

        // установим значения свойств объекта
        $this->certificate_id = $row['certificate_id'];
		$this->certificate_date = $row['certificate_date'];
		$this->contract_id= $row['contract_id'];
		$this->pay_id= $row['pay_id'];
		
		
        
    }

   function update(){
    $query = "UPDATE
                " . $this->table_name . "
            SET  
certificate_id=:certificate_id,			
            
				certificate_date=:certificate_date, 
				contract_id=:contract_id, 
				pay_id=:pay_id
				
							
            WHERE
                 certificate_id=:certificate_id";

    $stmt = $this->conn->prepare($query);
	
    $this->certificate_id=htmlspecialchars(strip_tags($this->certificate_id));
    $this->certificate_date=htmlspecialchars(strip_tags($this->certificate_date));
	$this->contract_id=htmlspecialchars(strip_tags($this->contract_id));	
	
	$this->pay_id=htmlspecialchars(strip_tags($this->pay_id));	
	
	
    
   $stmt->bindParam(":certificate_id", $this->certificate_id);
    $stmt->bindParam(":certificate_date", $this->certificate_date);
    $stmt->bindParam(":contract_id", $this->contract_id);	
	
	$stmt->bindParam(":pay_id", $this->pay_id);
   
    

    if ($stmt->execute()) {
        return true;
		}    return false;
	}
	
    function delete(){   
    $query = "DELETE FROM " . $this->table_name . " WHERE certificate_id = ?";   
    $stmt = $this->conn->prepare($query);    
    $this->certificate_id=htmlspecialchars(strip_tags($this->certificate_id));    
    $stmt->bindParam(1, $this->certificate_id);   
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
                certificate_id LIKE ? OR certificate_date LIKE ? OR contract_id LIKE ? OR pay_id LIKE ?";

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