<?php

namespace Classes;

use mysqli;
use mysqli_result;

class DB{
    private mysqli $db;

    private array $select = [];

    private string $from = "";

    private array $where = [];

    private array $join = [];

    private string $orderBy = "";

    private string $order = "ASC";

    private int $limit = 0;



    public function __construct(){
        $this->db = mysqli_connect(
            $_ENV['DB_HOST'] ?? '',
            $_ENV['DB_USER'] ?? '',
            $_ENV['DB_PASS'] ?? '',
            $_ENV['DB_NAME'] ?? ''
        );
    }

    public function reset(){
        $this->from = "";
        $this->where = [];
        $this->join = [];
        $this->orderBy = "";
        $this->order = "ASC";
        $this->limit = 0;

        return $this;
    }

    public function select(array|string $selectAttributes){
        
        if(is_string($selectAttributes)){
            $this->select[] = $selectAttributes;
        }

        $this->select = [...$this->select, ...$selectAttributes];

        return $this;
    }

    public function from(string $tableName){
        $this->from = $tableName;

        return $this;
    }

    public function where(array $whereClauses){
        $this->where = [...$this->where, ...$whereClauses];

        return $this;
    }

    public function join(string $joinedTable, string $attributeFromJoined, string $operator, string $attributeFromSelected){
        $this->join = [...$this->join, ["joinedTable"=> $joinedTable, "attributeFromJoined"=> $attributeFromJoined, "operator" =>$operator, "attributeFromSelected" => $attributeFromSelected]];

        return $this;
    }

    public function rawSQL(string $query){
        $queryResult = $this->db->query($query);

        return $this->fetchQueryResult($queryResult);
    }

    public function orderBy(string $orderBy){
        $this->orderBy = $orderBy;

        return $this;
    }

    public function order(string $order){
        $this->order = $order;

        return $this;
    }

    public function limit(int $limit){
        $this->limit = $limit;

        return $this;
    }

    public function build(){
        $query = $this->buildQuery();

        // debuguear($query);

        $queryResult = $this->db->query($query);

        return $this->fetchQueryResult($queryResult);
    }

    private function fetchQueryResult(mysqli_result $queryResult){
        $fetchedRegisters = [];

        while ($fetchedRegister = $queryResult->fetch_assoc()) {
            $fetchedRegisters[] = $fetchedRegister;
        }

        $queryResult->free();

        return $fetchedRegisters;
    }

    private function buildQuery(): string{
        $query = "SELECT ". implode(",", $this->select) . " ";

        $query .= "FROM $this->from ";
        
        if(!empty($this->join)){
            foreach ($this->join as $joinValues) {
                $query .= "JOIN ". $joinValues["joinedTable"] . " ON " . $joinValues["attributeFromJoined"] . $joinValues["operator"] . $joinValues["attributeFromSelected"]." ";
            }
        }

        if(!empty($this->where)){
            $query .= "WHERE ";
            foreach ($this->where as $attribute => $value) {
                $query .= "$attribute='$value'";
                !array_key_last($this->where) === $attribute ? $query .= " AND " : " ";
            }
        }

        if(!empty($this->orderBy)){ $query.= "ORDER BY $this->orderBy $this->order "; }

        if($this->limit !== 0){$query .= "LIMIT $this->limit";}

        $query.=";";

        return $query;
    }

}
