<?php
//Quem pode acessar este arquivo e o que irá ser retornado ( Required)
header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8");
 
include_once '../config/database.php';
include_once '../objects/skill.php';
 
$database = new Database();
$db = $database->getConn();
 
// initialize object
$skill = new Skill($db);
 
//query skills
$stmt = $skill->read();
$results = $stmt->rowCount();
 
//Se houverem resultados
if($results > 0) {
 
    // products array
    $skills_ar = array();
    $skills_ar["resultados"] = array();
 
    // retrieve our table contents
    // fetch() is faster than fetchAll()
    while ($row = $stmt->fetch(PDO::FETCH_ASSOC)){
        extract($row);// $row['name'] => $name //NICEEE TRICK
        $skill_item = array(
            "id" => $id,
            "nome" => $nome,
            "percent" => $percent
        );
        array_push($skills_ar["resultados"], $skill_item );
    }
 
    //Código da response - 200 OK
    http_response_code(200);
 
    //Exibe os dados das skills em Formato de Json
    echo json_encode($skills_ar);
}else{
 
    // set response code - 404 Not found
    http_response_code(404);
 
    echo json_encode(
        array("message" => "Nenhuma skill encontrada.")
    );
}
 