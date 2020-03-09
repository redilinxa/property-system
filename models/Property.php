<?php

class Property
{
    // database connection and table name
    private $conn;
    private $table_name = "properties";

    // object properties
    public $id;
    public $description;
    public $county;
    public $country;
    public $postcode;
    public $address;
    public $image_full;
    public $image_thumbnail;
    public $latitude;
    public $longitude;
    public $num_bedrooms;
    public $num_bathrooms;
    public $price;
    public $property_type_id;
    public $type;
    public $created_at;
    public $updated_at;

    // constructor with $db as database connection
    public function __construct($db, $id = 0){
        $this->conn = $db;
        $this->id = $id;
    }

    // read products
    public function read(){
        // select all query
        $query = "SELECT
                *
            FROM
                {$this->table_name} p
                LEFT JOIN
                    propertyTypes t
                        ON p.property_type_id = t.id
            ORDER BY
                p.created_at DESC";
        // prepare query statement
        $stmt = $this->conn->prepare($query);
        // execute query
        $stmt->execute();
        return $stmt;
    }

    public function readProperty(){
        // select all query
        $query = "SELECT
                *
            FROM
                {$this->table_name} p
                LEFT JOIN
                    propertyTypes t
                        ON p.property_type_id = t.id
            WHERE p.id = ?
            ORDER BY
                p.created_at DESC
            LIMIT 1";
        // prepare query statement
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(1, $this->id, PDO::PARAM_INT);
        // execute query
        $stmt->execute();
        return $stmt->fetch();
    }

    private function generateStatementParameters(array $row){
        $queryColumns='';
        foreach (array_keys($row) as $key) {
            $queryColumns = "{$key}=:{$key},";
        }
        return substr($queryColumns, 0,-1) ;
    }

    // create product
    public function create(array $data){

        // query to insert record
        $query = "INSERT INTO
                " . $this->table_name . "
            SET". $this->generateStatementParameters($data);

        // prepare query
        $stmt = $this->conn->prepare($query);
        $this->refreshObject($data);
        $this->sanitizeAttributes();
        // bind values
        foreach (array_keys($data) as $index) {
            $stmt->bindParam(":{$index}}", $this->{$index});
        }

        // execute query
        return $stmt->execute();
    }

    private function update(array $data){
        // query to insert record
        $query = "UPDATE " . $this->table_name . "
            SET". $this->generateStatementParameters($data) . "
            WHERE id = :id"
        ;

        // prepare query
        $stmt = $this->conn->prepare($query);
        $this->refreshObject($data);
        $this->sanitizeAttributes();
        // bind values
        foreach (array_keys($data) as $index) {
            $stmt->bindParam(":{$index}}", $this->{$index});
        }
        $stmt->bindParam(":id}", $this->id);

        // execute query
        return $stmt->execute();
    }

    public function refreshObject(array $row){
        foreach (array_keys(get_class_vars(get_class($this))) as $var) {
            $this->{$var} = $row[$var];
        }
    }

    private function sanitizeAttributes(){
        foreach (get_class_vars(get_class($this)) as $key => $value) {
            $this->{$key} = htmlentities(strip_tags($value));
        }
    }
}