<?php
require_once ('config/database.php');
require_once ('models/Property.php');

// required headers
header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8");
// instantiate database and product object
$database = new Database();
$db = $database->getConnection();

// initialize object
$product = new Property($db);

// read products will be here
// query products
$stmt = $product->read();
$num = $stmt->rowCount();

// check if more than 0 record found
$result_set=array();
$result_set["properties"]=array();
$result_set["num_records"]=$num;
if($num>0){
    // products array

    // retrieve our table contents
    // fetch() is faster than fetchAll()
    // http://stackoverflow.com/questions/2770630/pdofetchall-vs-pdofetch-in-a-loop
    while ($row = $stmt->fetch(\PDO::FETCH_ASSOC)){
        // extract row
        // this will make $row['id'] to
        // just $name only
        extract($row);

        $product_item=array(
            "id" => $id,
            "description" => html_entity_decode($description),
            "county"=>$county,
            "country"=>$country,
            "address"=>$address,
            "postcode"=>$postcode,
            "image_full"=>$image_full,
            "image_thumbnail"=>$image_thumbnail,
            "latitude"=>$latitude,
            "longitude"=>$longitude,
            "num_bedrooms"=>$num_bedrooms,
            "num_bathrooms"=>$num_bathrooms,
            "price"=>$price,
            "property_type_id"=>$property_type_id,
            "type"=>$type,
            "created_at"=>$created_at,
            "updated_at"=>$updated_at
        );
        array_push($result_set["properties"], $product_item);
    }
}else{
    $errors = array("message" => "No products found.");
}