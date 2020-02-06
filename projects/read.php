<?php
//Quem pode acessar este arquivo e o que irá ser retornado ( Required)
header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8");
 
include_once '../config/database.php';
include_once '../objects/project.php';
 
$database = new Database();
$db = $database->getConn();
 
// initialize object
$project = new project($db);
 
//query projects
$stmt = $project->read();
$results = $stmt->rowCount();
 
//Se houverem resultados
if($results > 0) {
 
    // products array
    $projects_ar = array();
    $projects_ar["resultados"] = array();
 
    // retrieve our table contents
    // fetch() is faster than fetchAll()
    while ($row = $stmt->fetch(PDO::FETCH_ASSOC)){
        extract($row);// $row['name'] => $name //NICEEE TRICK
        $project_item = array(
            "id" => $id,
            "nome" => $nome,
            "desc" => html_entity_decode($desc),
            "data" => $data,
            "skills" =>  html_entity_decode($skills),
        );
        array_push($projects_ar["resultados"], $project_item );
    }
 
    //Código da response - 200 OK
    http_response_code(200);
 
    //Exibe os dados das projects em Formato de Json
    echo json_encode($projects_ar);
}else{
 
    // set response code - 404 Not found
    http_response_code(404);
 
    echo json_encode(
        array("message" => "Nenhum project encontrado.")
    );
}
 