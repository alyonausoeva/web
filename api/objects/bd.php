<?php
class Bd {

    private $conn;
	private $table_name = "bd";
		
	public $bd_id;
    public $bd_name;
	public $bd_application;
    public $bd_volume;	
   
	
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
                bd_id=:bd_id,
				bd_name=:bd_name, 
				bd_application=:bd_application, 
				bd_volume=:bd_volume
				";  
				
    $stmt = $this->conn->prepare($query);    
	
    $this->bd_id=htmlspecialchars(strip_tags($this->bd_id));
    $this->bd_name=htmlspecialchars(strip_tags($this->bd_name));
	$this->bd_application=htmlspecialchars(strip_tags($this->bd_application));	
	
    $this->bd_volume=htmlspecialchars(strip_tags($this->bd_volume));
	
    
    $stmt->bindParam(":bd_id", $this->bd_id);
    $stmt->bindParam(":bd_name", $this->bd_name);
    $stmt->bindParam(":bd_application", $this->bd_application);	
	
	$stmt->bindParam(":bd_volume", $this->bd_volume);
    
	 
    if ($stmt->execute()) {return true; } return false;
}

    // используется при заполнении формы обновления товара
    function readOne() {

        // запрос для чтения одной записи (товара)
        $query = "SELECT  * FROM
                " . $this->table_name . " 
            WHERE
                bd_id = ?";

       
        $stmt = $this->conn->prepare( $query );

        // привязываем id товара, который будет обновлен
        $stmt->bindParam(1, $this->bd_id);

        // выполняем запрос
        $stmt->execute();

        // получаем извлеченную строку
        $row = $stmt->fetch(PDO::FETCH_ASSOC);

        // установим значения свойств объекта
        $this->bd_id = $row['bd_id'];
		$this->bd_name = $row['bd_name'];
		$this->bd_application= $row['bd_application'];
		$this->bd_volume= $row['bd_volume'];
		
		
        
    }

   function update(){
    $query = "UPDATE
                " . $this->table_name . "
            SET  
bd_id=:bd_id,			
            
				bd_name=:bd_name, 
				bd_application=:bd_application, 
				bd_volume=:bd_volume
				
							
            WHERE
                 bd_id=:bd_id";

    $stmt = $this->conn->prepare($query);
	
    $this->bd_id=htmlspecialchars(strip_tags($this->bd_id));
    $this->bd_name=htmlspecialchars(strip_tags($this->bd_name));
	$this->bd_application=htmlspecialchars(strip_tags($this->bd_application));	
	
	$this->bd_volume=htmlspecialchars(strip_tags($this->bd_volume));	
	
	
    
   $stmt->bindParam(":bd_id", $this->bd_id);
    $stmt->bindParam(":bd_name", $this->bd_name);
    $stmt->bindParam(":bd_application", $this->bd_application);	
	
	$stmt->bindParam(":bd_volume", $this->bd_volume);
   
    

    if ($stmt->execute()) {
        return true;
		}    return false;
	}
	
    function delete(){   
    $query = "DELETE FROM " . $this->table_name . " WHERE bd_id = ?";   
    $stmt = $this->conn->prepare($query);    
    $this->bd_id=htmlspecialchars(strip_tags($this->bd_id));    
    $stmt->bindParam(1, $this->bd_id);   
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
                bd_id LIKE ? OR bd_name LIKE ? OR bd_application LIKE ? OR bd_volume LIKE ?";

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