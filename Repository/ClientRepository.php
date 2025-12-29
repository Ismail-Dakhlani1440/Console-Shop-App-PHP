<?php

class ClientRepository extends Repo
{
    public function __construct($conn)
    {
        return parent::__construct($conn);
    }

    public function fetchall()
    {
        $query = "Select * From Clients";
        $stmt = $this->conn->prepare($query);
        $stmt->execute();
        $clients = [];

        while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
            $clients[] = new Client($row['name'], $row['email'], $row['id']);
        }
        return $clients;
    }

    public function insertObject($client)
    {
        $query = "Insert INTO Clients (name,email) VALUES (:name, :email)";
        $stmt = $this->conn->prepare($query);
        $name = $client->get_name();
        $email = $client->get_email();
        $stmt->bindParam(':name', $name);
        $stmt->bindParam(':email', $email);
        $stmt->execute();
    }
}
