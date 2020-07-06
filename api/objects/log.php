<?php
class Log
{

    private $conn;
    private $table_name = "log";

    public $data;
    public $date;
    public $type;
    public $status;
    public $body;


    public function __construct($db)
    {
        $this->conn = $db;

    }

    function read()
    {
        $query = "SELECT * FROM
                " . $this->table_name;
        $stmt = $this->conn->prepare($query);
        $stmt->execute();
        return $stmt;
    }

}
?>