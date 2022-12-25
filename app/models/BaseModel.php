<?php

class BaseModel
{
    protected $connection;
    protected $table;

    function __construct($table)
    {
        $this->connection = Database::getConnection();
        $this->table = $table;
    }

    public function getAll()
    {
        $query = "SELECT * FROM $this->table";
        $statement = $this->connection->prepare($query);
        $statement->execute();
        return $statement->fetchAll();
    }

    public function getById($identifier, $id)
    {
        $query = "SELECT * FROM $this->table WHERE $identifier = :id";
        $statement = $this->connection->prepare($query);
        $statement->bindParam(':id', $id);
        $statement->execute();
        return $statement->fetch();
    }

    public function getAllById($identifier, $id)
    {
        $query = "SELECT * FROM $this->table WHERE $identifier = :id";
        $statement = $this->connection->prepare($query);
        $statement->bindParam(':id', $id);
        $statement->execute();
        return $statement->fetchAll();
    }

    public function insert($data) {
        $query = "INSERT INTO $this->table VALUES (";
        foreach ($data as $key => $value) {
            $query .= ":$key, ";
        }
        $query = substr($query, 0, -2);
        $query .= ")";
        $statement = $this->connection->prepare($query);
        foreach ($data as $key => $value) {
            $statement->bindValue(":$key", $value);
        }
        $statement->execute();
    }

    public function update($data, $identifier, $id) {
        $query = "UPDATE $this->table SET ";
        foreach ($data as $key => $value) {
            $query .= "$key = :$key, ";
        }
        $query = substr($query, 0, -2);
        $query .= " WHERE $identifier = :id";
        $statement = $this->connection->prepare($query);
        foreach ($data as $key => $value) {
            $statement->bindValue(":$key", $value);
        }
        $statement->bindParam(':id', $id);
        $statement->execute();
    }

    public function delete($identifier, $id) {
        $query = "DELETE FROM $this->table WHERE $identifier = :id";
        $statement = $this->connection->prepare($query);
        $statement->bindParam(':id', $id);
        $statement->execute();
    }

    public function find($identifiers, $keyword) {
        $query = "SELECT * FROM $this->table WHERE ";
        foreach ($identifiers as $identifier) {
            $query .= "$identifier LIKE '%$keyword%' OR ";
        }
        $query = substr($query, 0, -3);
        $statement = $this->connection->prepare($query);
//        $statement->bindParam(':keyword', $keyword);
        $statement->execute();
        return $statement->fetchAll();
    }

    public function getLastInsertedId() {
        return $this->connection->lastInsertId();
    }
}