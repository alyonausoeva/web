<?php
class Officer {

    private $conn;
	private $table_name = "officer";
		
	public $officer_id;
    public $officer_name;
	public $department_id;
    public $officer_pas;	
    public $officer_date;
	public $officer_level;
	
    public function __construct($db){
        $this->conn = $db;
		
    }
	function logg($officer_id, $officer_pas){

    $query = "SELECT 
	`officer_id`, `officer_name`, `department_id`, `officer_pas`, `officer_date`, `officer_level` FROM
	".$this->table_name."
WHERE
`officer_id` LIKE '{$officer_id}' AND `officer_pas` LIKE '{$officer_pas}' AND `officer_level` BETWEEN 1 AND 3";

    $stmt = $this->conn->prepare($query);    
    $officer_id=htmlspecialchars(strip_tags($officer_id));
    $officer_id = "%{$officer_id}%";
    $officer_pas=htmlspecialchars(strip_tags($officer_pas));
    $officer_pas = "%{$officer_pas}%";
    $_SESSION['officer_id']= $officer_id;
	$_SESSION['officer_level']= $officer_level;
    $stmt->execute();
	
    return $stmt;
	
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
                officer_id=:officer_id,
				officer_name=:officer_name, 
				department_id=:department_id, 
				officer_pas=:officer_pas,
				officer_date=:officer_date,
				officer_level=:officer_level";  
				
    $stmt = $this->conn->prepare($query);    
	
    $this->officer_id=htmlspecialchars(strip_tags($this->officer_id));
    $this->officer_name=htmlspecialchars(strip_tags($this->officer_name));
	$this->department_id=htmlspecialchars(strip_tags($this->department_id));	
	
    $this->officer_pas=htmlspecialchars(strip_tags($this->officer_pas));
	$this->officer_date=htmlspecialchars(strip_tags($this->officer_date));
	$this->officer_level=htmlspecialchars(strip_tags($this->officer_level));
    
    $stmt->bindParam(":officer_id", $this->officer_id);
    $stmt->bindParam(":officer_name", $this->officer_name);
    $stmt->bindParam(":department_id", $this->department_id);	
	
	$stmt->bindParam(":officer_pas", $this->officer_pas);
    $stmt->bindParam(":officer_date", $this->officer_date);
	$stmt->bindParam(":officer_level", $this->officer_level);
	 
    if ($stmt->execute()) {return true; } return false;
}

    // используется при заполнении формы обновления товара
    function readOne() {

        // запрос для чтения одной записи (товара)
        $query = "SELECT  * FROM
                " . $this->table_name . " 
            WHERE
                officer_id = ?";

       
        $stmt = $this->conn->prepare( $query );

        // привязываем id товара, который будет обновлен
        $stmt->bindParam(1, $this->officer_id);

        // выполняем запрос
        $stmt->execute();

        // получаем извлеченную строку
        $row = $stmt->fetch(PDO::FETCH_ASSOC);

        // установим значения свойств объекта
        $this->officer_id = $row['officer_id'];
		$this->officer_name = $row['officer_name'];
		$this->department_id= $row['department_id'];
		$this->officer_pas= $row['officer_pas'];
		$this->officer_date= $row['officer_date'];
		$this->officer_level= $row['officer_level'];		
        
    }

   function update(){
    $query = "UPDATE
                " . $this->table_name . "
            SET  
officer_id=:officer_id,			
            
				officer_name=:officer_name, 
				department_id=:department_id, 
				officer_pas=:officer_pas,
				officer_date=:officer_date,
				officer_level=:officer_level			
							
            WHERE
                 officer_id=:officer_id";

    $stmt = $this->conn->prepare($query);
	
    $this->officer_id=htmlspecialchars(strip_tags($this->officer_id));
    $this->officer_name=htmlspecialchars(strip_tags($this->officer_name));
	$this->department_id=htmlspecialchars(strip_tags($this->department_id));	
	
	$this->officer_pas=htmlspecialchars(strip_tags($this->officer_pas));	
	$this->officer_date=htmlspecialchars(strip_tags($this->officer_date));	
	$this->officer_level=htmlspecialchars(strip_tags($this->officer_level));    
	
    
   $stmt->bindParam(":officer_id", $this->officer_id);
    $stmt->bindParam(":officer_name", $this->officer_name);
    $stmt->bindParam(":department_id", $this->department_id);	
	
	$stmt->bindParam(":officer_pas", $this->officer_pas);
    $stmt->bindParam(":officer_date", $this->officer_date);
	$stmt->bindParam(":officer_level", $this->officer_level);
    

    if ($stmt->execute()) {
        return true;
		}    return false;
	}
	
    function delete(){   
    $query = "DELETE FROM " . $this->table_name . " WHERE officer_id = ?";   
    $stmt = $this->conn->prepare($query);    
    $this->officer_id=htmlspecialchars(strip_tags($this->officer_id));    
    $stmt->bindParam(1, $this->officer_id);   
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
                officer_id LIKE ? OR officer_name LIKE ? OR department_id LIKE ? OR officer_pas LIKE ? OR officer_date LIKE ? OR officer_level LIKE ?";

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