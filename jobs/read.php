<?php
//Quem pode acessar este arquivo e o que irá ser retornado ( Required)
header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8");
 
include_once '../config/database.php';
include_once '../objects/job.php';
 
$database = new Database();
$db = $database->getConn();
 
// initialize object
$job = new Job($db);
 
//query jobs
$stmt = $job->read();
$results = $stmt->rowCount();
 
//Se houverem resultados
if($results > 0) {
 
    // products array
    $jobs_ar = array();
    $jobs_ar["resultados"] = array();
 
    // retrieve our table contents
    // fetch() is faster than fetchAll()
    while ($row = $stmt->fetch(PDO::FETCH_ASSOC)){
        extract($row);// $row['name'] => $name //NICEEE TRICK
        $job_item = array(
            "id" => $id,
            "empresa" => $empresa,
            "cargo" => $cargo,
            "desc" => html_entity_decode($desc),
            "entrada" => $entrada,
            "saida" => $saida,
            "portfolio" => $portfolio,
        );
        array_push($jobs_ar["resultados"], $job_item );
    }
 
    //Código da response - 200 OK
    http_response_code(200);
 
    //Exibe os dados das jobs em Formato de Json
    echo json_encode($jobs_ar);
}else{
 
    // set response code - 404 Not found
    http_response_code(404);
 
    echo json_encode(
        array("message" => "Nenhum job encontrado.")
    );
}
 