<?php

class Cart extends BaseModel
{
    public function __construct()
    {
        parent::__construct('carts');
    }

    public function getById($identifier, $id)
    {
        $query = "SELECT * FROM $this->table WHERE $identifier = :id";
        $statement = $this->connection->prepare($query);
        $statement->bindParam(':id', $id);
        $statement->execute();
        return $statement->fetchAll();
    }
}