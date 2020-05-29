<?php
class Department {

    private $conn;
	private $table_name = "department";
		
	public $department_id;
    public $department_name;
	public $department_officers;
    
   
	
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
                department_id=:department_id,
				department_name=:department_name, 
				department_officers=:department_officers
				
				";  
				
    $stmt = $this->conn->prepare($query);    
	
    $this->department_id=htmlspecialchars(strip_tags($this->department_id));
    $this->department_name=htmlspecialchars(strip_tags($this->department_name));
	$this->department_officers=htmlspecialchars(strip_tags($this->department_officers));	
	
   
	
    
    $stmt->bindParam(":department_id", $this->department_id);
    $stmt->bindParam(":department_name", $this->department_name);
    $stmt->bindParam(":department_officers", $this->department_officers);	
	
	
    
	 
    if ($stmt->execute()) {return true; } return false;
}

    // используется при заполнении формы обновления товара
    function readOne() {

        // запрос для чтения одной записи (товара)
        $query = "SELECT  * FROM
                " . $this->table_name . " 
            WHERE
                department_id = ?";

       
        $stmt = $this->conn->prepare( $query );

        // привязываем id товара, который будет обновлен
        $stmt->bindParam(1, $this->department_id);

        // выполняем запрос
        $stmt->execute();

        // получаем извлеченную строку
        $row = $stmt->fetch(PDO::FETCH_ASSOC);

        // установим значения свойств объекта
        $this->department_id = $row['department_id'];
		$this->department_name = $row['department_name'];
		$this->department_officers= $row['department_officers'];
		
		
		
        
    }

   function update(){
    $query = "UPDATE
                " . $this->table_name . "
            SET  
department_id=:department_id,			
            
				department_name=:department_name, 
				department_officers=:department_officers
				
				
							
            WHERE
                 department_id=:department_id";

    $stmt = $this->conn->prepare($query);
	
    $this->department_id=htmlspecialchars(strip_tags($this->department_id));
    $this->department_name=htmlspecialchars(strip_tags($this->department_name));
	$this->department_officers=htmlspecialchars(strip_tags($this->department_officers));	
	
	
	
	
    
   $stmt->bindParam(":department_id", $this->department_id);
    $stmt->bindParam(":department_name", $this->department_name);
    $stmt->bindParam(":department_officers", $this->department_officers);	
	
	
   
    

    if ($stmt->execute()) {
        return true;
		}    return false;
	}
	
    function delete(){   
    $query = "DELETE FROM " . $this->table_name . " WHERE department_id = ?";   
    $stmt = $this->conn->prepare($query);    
    $this->department_id=htmlspecialchars(strip_tags($this->department_id));    
    $stmt->bindParam(1, $this->department_id);   
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
                department_id LIKE ? OR department_name LIKE ? OR department_officers LIKE ?";

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