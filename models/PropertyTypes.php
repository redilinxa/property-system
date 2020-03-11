<?php

class PropertyTypes
{
    // database connection and table name
    private $conn;
    private $table_name = "propertyTypes";

    public $id;
    public $title;
    public $description;
    public $created_at;
    public $updated_at;

    // constructor with $db as database connection
    public function __construct($db){
        $this->conn = $db;
    }

    public function readAll(){
        // select all query
        $query = "SELECT
                *
            FROM
                {$this->table_name} t
            ";

        // prepare query statement
        $stmt = $this->conn->prepare($query);
        // execute query
        $stmt->execute();
        return $stmt->fetchAll();
    }

    private function generateStatementParameters(array $row){
        $queryColumns='';
        foreach (array_keys($row) as $key) {
            if ($row[$key] !== null) {
                $queryColumns .= "{$key}=:{$key},";
            }
        }
        return substr($queryColumns, 0,-1) ;
    }

    // create PropertyTypes
    public function create(array $data){
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
            if ($this->{$index} !== null){
                $stmt->bindParam(":{$index}", $this->{$index});
            }
        }
        // execute query
        return $stmt->execute();
    }

    private function update(array $data){
        // query to insert record
        $query = "UPDATE " . $this->table_name . "
            SET ". $this->generateStatementParameters($data) . "
            WHERE id = :id"
        ;

        // prepare query
        $stmt = $this->conn->prepare($query);
        $this->refreshObject($data);
        $this->sanitizeAttributes();
        // bind values
        foreach (array_keys($data) as $index) {
            $stmt->bindParam(":{$index}", $this->{$index});
        }
        $stmt->bindParam(":id", $this->id);
        var_dump($stmt->debugDumpParams());


        // execute query
        return $stmt->execute();
    }

    public function save(array $data){
        if (array_key_exists('id', $data)
            && $this->readPropertyType($data['id'])
        ){
            return $this->update($data);
        }else{
            return $this->create($data);
        }
    }

    public function refreshObject(array $row){
        foreach (array_keys($row) as $var) {
            $this->{$var} = $row[$var];
        }
    }

    private function sanitizeAttributes(){
        foreach ($this->get_object_public_vars($this) as $key => $value) {
            $this->{$key} = htmlentities(strip_tags($value));
        }
    }

    public function readPropertyType($id){
        // select all query
        $query = "SELECT
                *
            FROM
                {$this->table_name} t
            WHERE p.id = ?
            ORDER BY
                p.created_at DESC
            LIMIT 1";
        // prepare query statement
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(1, $id, PDO::PARAM_INT);
        // execute query
        $stmt->execute();
        return $stmt->fetch();
    }

    private function get_object_public_vars($object) {
        return (new ReflectionObject($object))->getProperties(ReflectionProperty::IS_PUBLIC);//get all public properties of a class
    }
}