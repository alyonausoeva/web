<?php
class Contract {

    private $conn;
	private $table_name = "contract";
		
	public $contract_id;
    public $klient_id;
	public $bd_id;
    public $contract_date;	
    public $contract_status;
	public $officer_id;
	
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
                contract_id=:contract_id,
				klient_id=:klient_id, 
				bd_id=:bd_id, 
				contract_date=:contract_date,
				contract_status=:contract_status,
				officer_id=:officer_id";  
				
    $stmt = $this->conn->prepare($query);    
	
    $this->contract_id=htmlspecialchars(strip_tags($this->contract_id));
    $this->klient_id=htmlspecialchars(strip_tags($this->klient_id));
	$this->bd_id=htmlspecialchars(strip_tags($this->bd_id));	
	
    $this->contract_date=htmlspecialchars(strip_tags($this->contract_date));
	$this->contract_status=htmlspecialchars(strip_tags($this->contract_status));
	$this->officer_id=htmlspecialchars(strip_tags($this->officer_id));
    
    $stmt->bindParam(":contract_id", $this->contract_id);
    $stmt->bindParam(":klient_id", $this->klient_id);
    $stmt->bindParam(":bd_id", $this->bd_id);	
	
	$stmt->bindParam(":contract_date", $this->contract_date);
    $stmt->bindParam(":contract_status", $this->contract_status);
	$stmt->bindParam(":officer_id", $this->officer_id);
	 
    if ($stmt->execute()) {return true; } return false;
}

    // используется при заполнении формы обновления товара
    function readOne() {

        // запрос для чтения одной записи (товара)
        $query = "SELECT  * FROM
                " . $this->table_name . " 
            WHERE
                contract_id = ?";

       
        $stmt = $this->conn->prepare( $query );

        // привязываем id товара, который будет обновлен
        $stmt->bindParam(1, $this->contract_id);

        // выполняем запрос
        $stmt->execute();

        // получаем извлеченную строку
        $row = $stmt->fetch(PDO::FETCH_ASSOC);

        // установим значения свойств объекта
        $this->contract_id = $row['contract_id'];
		$this->klient_id = $row['klient_id'];
		$this->bd_id= $row['bd_id'];
		$this->contract_date= $row['contract_date'];
		$this->contract_status= $row['contract_status'];
		$this->officer_id= $row['officer_id'];	
		
        
    }

   function update(){
    $query = "UPDATE
                " . $this->table_name . "
            SET  
contract_id=:contract_id,			
            
				klient_id=:klient_id, 
				bd_id=:bd_id, 
				contract_date=:contract_date,
				contract_status=:contract_status,
				officer_id=:officer_id			
							
            WHERE
                 contract_id=:contract_id";

    $stmt = $this->conn->prepare($query);
	
    $this->contract_id=htmlspecialchars(strip_tags($this->contract_id));
    $this->klient_id=htmlspecialchars(strip_tags($this->klient_id));
	$this->bd_id=htmlspecialchars(strip_tags($this->bd_id));	
	
	$this->contract_date=htmlspecialchars(strip_tags($this->contract_date));	
	$this->contract_status=htmlspecialchars(strip_tags($this->contract_status));	
	$this->officer_id=htmlspecialchars(strip_tags($this->officer_id));    
	
    
   $stmt->bindParam(":contract_id", $this->contract_id);
    $stmt->bindParam(":klient_id", $this->klient_id);
    $stmt->bindParam(":bd_id", $this->bd_id);	
	
	$stmt->bindParam(":contract_date", $this->contract_date);
    $stmt->bindParam(":contract_status", $this->contract_status);
	$stmt->bindParam(":officer_id", $this->officer_id);
    

    if ($stmt->execute()) {
        return true;
		}    return false;
	}
	
    function delete(){   
    $query = "DELETE FROM " . $this->table_name . " WHERE contract_id = ?";   
    $stmt = $this->conn->prepare($query);    
    $this->contract_id=htmlspecialchars(strip_tags($this->contract_id));    
    $stmt->bindParam(1, $this->contract_id);   
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
                contract_id LIKE ? OR klient_id LIKE ? OR bd_id LIKE ? OR contract_date LIKE ? OR contract_status LIKE ? OR officer_id LIKE ?";

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
		$stmt->bindParam(6, $keywords);

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