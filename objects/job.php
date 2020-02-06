<?php
class Job{
 
    //Conexão e tabela a ser consultada
    private $conn;
    private $tabela = "jobs";
 
    // Propriedades do objeto
    public $id;
    public $empresa;
    public $cargo;
    public $desc;
    public $entrada;
    public $saida;
    public $portfolio;

    // constructor com  $db sendo a conexão com o banco
    public function __construct($db){
        $this->conn = $db;
    }

    // read jobs
    function read(){
        $query = "SELECT * FROM  " . $this->tabela . " ORDER BY id DESC";
        $stmt = $this->conn->prepare($query);
        $stmt->execute();
        return $stmt;
    }
}
?>