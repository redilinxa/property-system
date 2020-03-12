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
//handle image full section
$fileName='';
$upload = 1;
if (strpos($_POST['image_thumbnail'], 'data:image') === 0) {
    //get the file information
    $fileName = basename($_FILES["image_full"]["name"]);
    $fileTmp = $_FILES["image_full"]["tmp_name"];
    $ext = substr($fileName, strrpos($fileName, ".") + 1);
    $file = '/public/files/full/'.date("YmdHis")."_".$fileName;
    if($ext != "jpg" && $ext != "png" && $ext != "jpeg"
        && $ext != "gif" ) {
        // set response code - 422 unprocessable entity
        http_response_code(422);
        // tell the user
        echo json_encode(array("message" => "Sorry, only JPG, JPEG & PNG are allowed."));
        $upload = 0;
    }
    // Check if $uploadOk is set to 0 by an error
    if ($upload == 0) {
        http_response_code(503);
        // tell the user
        echo json_encode(array("message" => "The file was not uploaded."));
        die();
    // if everything is ok, try to upload file
    } else {
        if (move_uploaded_file($fileTmp, "../..".$file)) {
            $data['image_full'] = $file;
        } else {
            // set response code - 503 service unavailable
            http_response_code(503);
            // tell the user
            echo json_encode(array("message" => "The image could not be saved."));
            die();
        }
    }
}

//handle thumbnail data - this operation is done automatically in JS therefore not much validation on this part.
if (strpos($data['image_thumbnail'], 'data:image') === 0) {

    $img = $data['image_thumbnail'];

    if (strpos($img, 'data:image/jpeg;base64,') === 0) {
        $img = str_replace('data:image/jpeg;base64,', '', $img);
        $ext = '.jpg';
    }
    if (strpos($img, 'data:image/png;base64,') === 0) {
        $img = str_replace('data:image/png;base64,', '', $img);
        $ext = '.png';
    }

    $img = str_replace(' ', '+', $img);
    $fileData = base64_decode($img);
    $file = '/public/files/thumbs/'.date("YmdHis")."_".$fileName;

    if (file_put_contents("../..".$file, $fileData)) {
        $data['image_thumbnail'] = $file;
    } else {
        // set response code - 503 service unavailable
        http_response_code(503);
        // tell the user
        echo json_encode(array("message" => "The image could not be saved."));
        die();
    }

}

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
        echo json_encode(array("message" => "Property was saved."));
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