<?php
// required headers
header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Headers: access");
header("Access-Control-Allow-Methods: GET");
header("Access-Control-Allow-Credentials: true");
header('Content-Type: application/json');

// get database connection
require_once ('../../config/database.php');

// instantiate property object
require_once ('../../models/Property.php');

// get database connection
$database = new Database();
$db = $database->getConnection();

// prepare property object
$property = new Property($db);

// set ID property of record to read
if(!isset($_GET['uuid']) || empty($_GET['uuid'])){
    http_response_code(503);
    echo json_encode(array("message" => "No uuid supplied!"));
}

// read the details of property to be edited
$propertyArray = $property->readProperty($_GET['uuid']);
if(!empty($propertyArray) && count($propertyArray) > 0){


    // set response code - 200 OK
    http_response_code(200);

    // make it json format
    echo json_encode($propertyArray);
}

else{
    // set response code - 404 Not found
    http_response_code(404);

    // tell the user property does not exist
    echo json_encode(array("message" => "Property does not exist."));
}
?>