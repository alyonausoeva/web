<?php
class Pay {

    private $conn;
	private $table_name = "pay";
		
	public $pay_id;
    public $pay_sum;
	public $pay_date;
    
   
	
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
                pay_id=:pay_id,
				pay_sum=:pay_sum, 
				pay_date=:pay_date
				
				";  
				
    $stmt = $this->conn->prepare($query);    
	
    $this->pay_id=htmlspecialchars(strip_tags($this->pay_id));
    $this->pay_sum=htmlspecialchars(strip_tags($this->pay_sum));
	$this->pay_date=htmlspecialchars(strip_tags($this->pay_date));	
	
   
	
    
    $stmt->bindParam(":pay_id", $this->pay_id);
    $stmt->bindParam(":pay_sum", $this->pay_sum);
    $stmt->bindParam(":pay_date", $this->pay_date);	
	
	
    
	 
    if ($stmt->execute()) {return true; } return false;
}

    // используется при заполнении формы обновления товара
    function readOne() {

        // запрос для чтения одной записи (товара)
        $query = "SELECT  * FROM
                " . $this->table_name . " 
            WHERE
                pay_id = ?";

       
        $stmt = $this->conn->prepare( $query );

        // привязываем id товара, который будет обновлен
        $stmt->bindParam(1, $this->pay_id);

        // выполняем запрос
        $stmt->execute();

        // получаем извлеченную строку
        $row = $stmt->fetch(PDO::FETCH_ASSOC);

        // установим значения свойств объекта
        $this->pay_id = $row['pay_id'];
		$this->pay_sum = $row['pay_sum'];
		$this->pay_date= $row['pay_date'];
		
		
		
        
    }

   function update(){
    $query = "UPDATE
                " . $this->table_name . "
            SET  
pay_id=:pay_id,			
            
				pay_sum=:pay_sum, 
				pay_date=:pay_date
				
				
							
            WHERE
                 pay_id=:pay_id";

    $stmt = $this->conn->prepare($query);
	
    $this->pay_id=htmlspecialchars(strip_tags($this->pay_id));
    $this->pay_sum=htmlspecialchars(strip_tags($this->pay_sum));
	$this->pay_date=htmlspecialchars(strip_tags($this->pay_date));	
	
	
	
	
    
   $stmt->bindParam(":pay_id", $this->pay_id);
    $stmt->bindParam(":pay_sum", $this->pay_sum);
    $stmt->bindParam(":pay_date", $this->pay_date);	
	
	
   
    

    if ($stmt->execute()) {
        return true;
		}    return false;
	}
	
    function delete(){   
    $query = "DELETE FROM " . $this->table_name . " WHERE pay_id = ?";   
    $stmt = $this->conn->prepare($query);    
    $this->pay_id=htmlspecialchars(strip_tags($this->pay_id));    
    $stmt->bindParam(1, $this->pay_id);   
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
                pay_id LIKE ? OR pay_sum LIKE ? OR pay_date LIKE ?";

        // подготовка запроса
        $stmt = $this->conn->prepare($query);

        // очистка
        $keywords=htmlspecialchars(strip_tags($keywords));
        $keywords = "%{$keywords}%";

        // привязка
        $stmt->bindParam(1, $keywords);
        $stmt->bindParam(2, $keywords);
        $stmt->bindParam(3, $keywords);
		
	

        // выполняем запрос
        $stmt->execute();

        return $stmt;
    }
    function filtr($keywords){
               $query = "SELECT
                *
            FROM
                `{$this->table_name}` 
            WHERE
                `pay_sum` < '{$keywords}' ";
        // подготовка запроса
        $stmt = $this->conn->prepare($query);
        // очистка
        $keywords=htmlspecialchars(strip_tags($keywords));
        $keywords = "%{$keywords}%";
        // привязка
        $stmt->bindParam(1, $keywords);
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