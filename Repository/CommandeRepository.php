<?php

class CommandeRepository extends Repo
{
    public function __construct($conn)
    {
        return parent::__construct($conn);
    }

    public function fetchAll()
    {
        $query = "Select * From Commandes";
        $stmt = $this->conn->prepare($query);
        $stmt->execute();
        $commandes = [];

        while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
            $queryforclient = "Select * From Clients WHERE id={$row['client_id']}";
            $stmtforclient = $this->conn->prepare($queryforclient);
            $stmtforclient->execute();
            $clientinfo = $stmtforclient->fetch(PDO::FETCH_ASSOC);
            $client = new Client($clientinfo['name'], $clientinfo['email'], $clientinfo['id']);
            $commandes[] = new Commande($row['montantTotal'], $row['status'], $client, $row['id']);
        }
        return $commandes;
    }

    public function fetchNonDelivred()
    {
        $query = "Select * From Commandes WHERE status ='Not Delivered'";
        $stmt = $this->conn->prepare($query);
        $stmt->execute();
        $commandes = [];

        while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
            $queryforclient = "Select * From Clients where id={$row['client_id']}";
            $stmtforclient = $this->conn->prepare($queryforclient);
            $stmtforclient->execute();
            $clientinfo = $stmtforclient->fetch(PDO::FETCH_ASSOC);
            $client = new Client($clientinfo['name'], $clientinfo['email'], $clientinfo['id']);
            $commandes[] = new Commande($row['montantTotal'], $row['status'], $client, $row['id']);
        }
        return $commandes;
    }

    public function insertObject($commande)
    {
        $query = "Insert INTO Commandes (montantTotal,status,client_id) VALUES (:montantTotal, :status , :client_id)";
        $stmt = $this->conn->prepare($query);
        $montantTotal = $commande->get_montantTotal();
        $status = $commande->get_status();
        $client_id = $commande->get_client()->get_id();
        $stmt->bindParam(':montantTotal', $montantTotal);
        $stmt->bindParam(':status', $status);
        $stmt->bindParam(':client_id', $client_id);
        $stmt->execute();
    }

    public function updatestatus($commande)
    {
        $query = "UPDATE commandes SET status = 'Delivered' WHERE id={$commande->get_id()}";
        $stmt = $this->conn->prepare($query);
        $stmt->execute();
    }

}
