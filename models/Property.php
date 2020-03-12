<?php
require_once ('PropertyTypes.php');
class Property
{
    // database connection and table name
    private $conn;
    private $table_name = "properties";

    // object properties
    public $id;
    public $uuid;
    public $description;
    public $county;
    public $country;
    public $town;
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
    public function __construct($db, $uuid = 0){
        $this->conn = $db;
        $this->uuid = $uuid;
    }

    // read products
    public function read($search, $order, $length, $start){
        // select all query
        $query = "SELECT
                p.*,t.title
            FROM
                {$this->table_name} p
                LEFT JOIN
                    propertyTypes t
                        ON p.property_type_id = t.id
            ";
        if(!empty($search))
        {
            $query .= "WHERE p.country  LIKE '%{$search}%'";
            $query .= "OR p.county LIKE '%{$search}%'";
            $query .= "OR p.description LIKE '%{$search}%'";
            $query .= "OR p.address LIKE '%{$search}%'";
            $query .= "OR p.price LIKE '%{$search}%'";
        }
        if(!empty($order))
        {
            $query .= 'ORDER BY p.'.$_POST['order']['0']['column'].' '.$_POST['order']['0']['dir'].' ';
        }
        else
        {
            $query .= 'ORDER BY p.id DESC ';
        }
        if($length != -1)
        {
            $query .= 'LIMIT ' . $start . ', ' . $length;
        }
        //prepare query statement
        $stmt = $this->conn->prepare($query);
        // execute query
        $stmt->execute();
        return $stmt;
    }

    public function readAllCount(){
        // select all query
        $query = "SELECT
                *
            FROM
                {$this->table_name} p
            ";

        // prepare query statement
        $stmt = $this->conn->prepare($query);
        // execute query
        $stmt->execute();
        return $stmt->rowCount();
    }

    public function readProperty($uuid){
        // select all query
        $query = "SELECT
                p.*,t.title
            FROM
                {$this->table_name} p
                LEFT JOIN
                    propertyTypes t
                        ON p.property_type_id = t.id
            WHERE p.uuid = ?
            ORDER BY
                p.created_at DESC
            LIMIT 1";
        // prepare query statement
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(1, $uuid, PDO::PARAM_INT);
        // execute query
        $stmt->execute();
        return $stmt->fetch(\PDO::FETCH_ASSOC);
    }

    private function generateStatementParameters(array $row){
        $queryColumns='';
        foreach (array_keys($row) as $key) {
            if ($key !== 'property_type') {
                $queryColumns .= "{$key}=:{$key},";
            }
        }
        return substr($queryColumns, 0,-1) ;
    }

    // create product
    public function create(array $data){
        //generate uuid for the items coming from admin
        if (!array_key_exists('uuid', $data)){
            $data['uuid'] = $this->generateUuid();
        }
        unset($data['id']);
        // query to insert record
        $query = "INSERT INTO
                " . $this->table_name . "
            SET ". $this->generateStatementParameters($data);

        // prepare query
        $stmt = $this->conn->prepare($query);
        $this->refreshObject($data);
        $this->sanitizeAttributes();
        // bind values
        foreach (array_keys($data) as $index) {
            if ($index !== 'property_type') {
                $stmt->bindParam(":{$index}", $this->{$index});
            }else{
                $types = new PropertyTypes($this->conn);
                $types->save($data['property_type']);
            }
        }
        // execute query
         return $stmt->execute();
    }

    public function update(array $data){
        // query to insert record
        $query = "UPDATE " . $this->table_name . "
            SET ". $this->generateStatementParameters($data) . "
            WHERE uuid = :uuid"
        ;

        // prepare query
        $stmt = $this->conn->prepare($query);
        $this->refreshObject($data);
        $this->sanitizeAttributes();
        // bind values
        foreach (array_keys($data) as $index) {
            if ($index !== 'property_type') {
                $stmt->bindParam(":{$index}", $this->{$index});
            }else{
                $types = new PropertyTypes($this->conn);
                $types->save($data['property_type']);
            }
        }
        $stmt->bindParam(":uuid", $this->uuid);

        // execute query
        return $stmt->execute();
    }

    public function save(array $data){
        if (array_key_exists('uuid', $data)
            && $this->readProperty($data['uuid'])
        ){
            return $this->update($data);
        }else{
            return $this->create($data);
        }
    }

    public function refreshObject(array $row){
        foreach (array_keys($row) as $key) {
            $this->{$key} = $row[$key];
        }
    }

    private function sanitizeAttributes(){
        foreach ($this->get_object_public_vars($this) as $key => $value) {
            $this->{$key} = htmlentities(strip_tags($value));
        }
    }

    private function generateUuid(){
        // select UUID query
        $query = "select uuid() as uuid;";
        // prepare query statement
        $stmt = $this->conn->prepare($query);
        // execute query
        $stmt->execute();
        return $stmt->fetch()['uuid'];
    }

    private function get_object_public_vars($object) {
        return (new ReflectionObject($object))->getProperties(ReflectionProperty::IS_PUBLIC);//get all public properties of a class
    }
}