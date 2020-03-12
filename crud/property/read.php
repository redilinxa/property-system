<?php
/*
 * This file is used to retrieve the ajax request from the event fired by the datatables request template.
 * */
// required headers
// get database connection
include ('../../config/database.php');

// instantiate property object
include ('../../models/Property.php');

$database = new Database();
$db = $database->getConnection();

$property = new Property($db);

// read properties will be here
// query properties
$stmt = $property->read(isset($_GET["search"]["value"])? $_GET["search"]["value"]: '',
    isset($_GET["order"])? $_GET["order"]: '',
    isset($_GET["length"])? $_GET["length"]: -1,
    isset($_GET["start"])? $_GET["start"]: 0
);
$num = $stmt->rowCount();

// check if more than 0 record found
$result_set=array();
if($num>0){
    // retrieve our table contents
    while ($row = $stmt->fetch(\PDO::FETCH_ASSOC)){
        // extract row
        // this will make $row['id'] to $id
        extract($row);

        $property_item=array(
            $county,
            $country,
            $town,
            $postcode,
             html_entity_decode($description),
            $address,
            "<a href='{$image_full}'>{$image_full}</a>",
            $num_bedrooms,
            $num_bathrooms,
            $price,
            $title,
            $type,
            '<a class="edit pointer-link" title="Edit" id="'.$row["uuid"].'" data-toggle="tooltip"><i class="material-icons">&#xE254;</i></a>',
            $updated_at
        );
        array_push($result_set, $property_item);
    }
    // set response code - 200 OK
    http_response_code(200);
    $output = array(
        "recordsTotal"  =>  $property->readAllCount(),
        "recordsFiltered" => $num,
        "data"    => $result_set
    );
    // show products data in json format
    echo json_encode($output);
}else{
    http_response_code(400);
    echo json_encode(array("message" => "No properties found."));
}