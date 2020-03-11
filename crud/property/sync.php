<?php
/*
 * This file is used to retrieve the ajax request from the event fired by the refresh button.
 * */
// required headers
header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8");
// get database connection
include ('../../config/database.php');

// instantiate property object
include ('../../models/Property.php');

$database = new Database();
$db = $database->getConnection();

$property = new Property($db);

// Get cURL resource
$curl = curl_init();
// Set some options - we are passing in a useragent too here
curl_setopt_array($curl, [
    CURLOPT_RETURNTRANSFER => 1,
    CURLOPT_URL => 'https://cors-anywhere.herokuapp.com/http://trialapi.craig.mtcdevserver.com/api/properties?api_key=3NLTTNlXsi6rBWl7nYGluOdkl2htFHug',
    CURLOPT_USERAGENT => 'property',
    CURLOPT_HTTPHEADER => array(
        'Content-Type: application/json',
        "X-Requested-With: XMLHttpRequest"
    )
]);
// Send the request & save response to $resp
$data = json_decode(curl_exec($curl),true);
// Close request to clear up some resources
curl_close($curl);

// make sure data is not empty
if(
    count($data)>0 && array_key_exists('data', $data) && count($data['data'])
){
    /* For the sake of performance with would have been a bulk insert update. However for this project i wanted to provide reusable solution. */
    $successMessage = "";
    $errorMessage = "";
    foreach ($data['data'] as $item) {
        // create the property
        if($property->save($item)){

            // set response code - 201 created
            $successMessage .= "Product with uuid: {$item['uuid']} was saved.,";
            // tell the user
        }

        // if unable to create the property, tell the user
        else{
            // set response code - 503 service unavailable
            $errorMessage .= "Unable to create product with uuid: {$item['uuid']}.,";
            // tell the user
        }

    }
    if (!empty($successMessage) && !empty($errorMessage)){
        http_response_code(207);
        echo json_encode(array("message" => explode(',' ,$errorMessage)));
        echo json_encode(array("message" => explode(',' ,$successMessage)));
    }else if (empty($successMessage) && !empty($errorMessage)){
        http_response_code(503);
        echo json_encode(array("message" => explode(',' ,$errorMessage)));
    }else if (!empty($successMessage) && empty($errorMessage)){
        http_response_code(201);
        echo json_encode(array("message" => explode(',' ,$successMessage)));
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