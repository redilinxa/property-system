<?php
// required headers
header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8");
header("Access-Control-Allow-Methods: POST");
header("Access-Control-Max-Age: 3600");
header("Access-Control-Allow-Headers: Content-Type, Access-Control-Allow-Headers, Authorization, X-Requested-With");

include ('../../config/database.php');

// instantiate property object
include ('../../models/Property.php');

$database = new Database();
$db = $database->getConnection();

$property = new Property($db);

// get posted data
$data = $_POST;
$operation = $data['operation'];
unset($data['operation']);
// make sure data is not empty
if(
    !empty($data['county']) &&
    !empty($data['country']) &&
    !empty($data['postcode']) &&
    !empty($data['town']) &&
    !empty($data['price']) &&
    !empty($data['description']) &&
    !empty($data['num_bedrooms']) &&
    !empty($data['num_bathrooms']) &&
    !empty($data['type']) &&
    !empty($data['property_type_id'])
    ){
    $result = null;
    if ($operation ==='Add'){
        $result = $property->create($data);
    }else if ($operation ==='Edit'){
        $result = $property->update($data);
    }
    // create the property
    if($result){
        // set response code - 201 created
        http_response_code(201);

        // tell the user
        echo json_encode(array("message" => "Property was created."));
    }

    // if unable to create the property, tell the user
    else{
        // set response code - 503 service unavailable
        http_response_code(503);

        // tell the user
        echo json_encode(array("message" => "Unable to create property."));
    }
}

// tell the user data is incomplete
else{

    // set response code - 400 bad request
    http_response_code(400);

    // tell the user
    echo json_encode(array("message" => "Unable to create property. Data is incomplete."));
}
?>