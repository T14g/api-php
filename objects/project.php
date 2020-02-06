<?php
class Project{
 
    //Conexão e tabela a ser consultada
    private $conn;
    private $tabela = "projects";
 
    // Propriedades do objeto
    public $id;
    public $nome;
    public $percent;

    // constructor com  $db sendo a conexão com o banco
    public function __construct($db){
        $this->conn = $db;
    }

    // read projects
    function read(){
        $query = "SELECT * FROM  " . $this->tabela . " ORDER BY id DESC";
        $stmt = $this->conn->prepare($query);
        $stmt->execute();
        return $stmt;
    }
}
?>