<?php

class PaiementRepository extends Repo
{
    public function __construct($conn)
    {
        return parent::__construct($conn);
    }

    public function fetchAll(){
        $query = "Select * From Paiements";
        $stmt = $this->conn->prepare($query);
        $stmt->execute();
        $paiements = [];

        while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
            $queryforcommande = "Select * From Commandes WHERE id='{$row['commande_id']}'";
            $stmtforcommande = $this->conn->prepare($queryforcommande);
            $stmtforcommande->execute();
            $commandeinfo=$stmtforcommande->fetch(PDO::FETCH_ASSOC);


            $clientid = $commandeinfo['client_id'];
            echo "$clientid \n";
            $queryforclient = "Select * From Clients WHERE id={$commandeinfo['client_id']}";
            $stmtforclient = $this->conn->prepare($queryforclient);
            $stmtforclient->execute();
            $clientinfo=$stmtforclient->fetch(PDO::FETCH_ASSOC);

            $client = new Client($clientinfo['name'],$clientinfo['email'],$clientinfo['id']);

            $commande = new Commande($commandeinfo['montantTotal'],$commandeinfo['status'],$client,$commandeinfo['id']);
            switch($row['type']){
                case 'CarteBancaire':
                    $queryforCarteBancaire = "Select * From CarteBancaires WHERE paiement_id={$row['id']}";
                    $stmtforCarteBancaire = $this->conn->prepare($queryforCarteBancaire);
                    $stmtforCarteBancaire->execute();
                    $carteinfo =$stmtforCarteBancaire->fetch(PDO::FETCH_ASSOC);
                    $paiements[] = new CreditCard($row['montant'], $row['status'],$commande, $row['type'],$carteinfo['creditCardNumber'],$row['datePaiment'],$row['id']);
                    break;

                case 'Paypal':
                    $queryforpaypal = "Select * From paypals WHERE paiement_id={$row['id']}";
                    $queryforpaypal = $this->conn->prepare($queryforpaypal);
                    $queryforpaypal->execute();
                    $paypalinfo =$queryforpaypal->fetch(PDO::FETCH_ASSOC);
                    $paiements[] = new PayPal($row['montant'], $row['status'],$commande, $row['type'],$paypalinfo['paymentEmail'],$paypalinfo['paymentPassword'],$row['datePaiment'],$row['id']);
                    break;

                case 'Virement':
                    $queryforvirement = "Select * From virements WHERE paiement_id={$row['id']}";
                    $stmtforvirement = $this->conn->prepare($queryforvirement);
                    $stmtforvirement->execute();
                    $virementinfo =$stmtforvirement->fetch(PDO::FETCH_ASSOC);
                    $paiements[] = new Virement($row['montant'], $row['status'],$commande, $row['type'],$virementinfo['rib'],$row['datePaiment'],$row['id']);
                    break;
            };
        }
        return $paiements;
    }

    public function fetchNonPaid(){
        $query = "Select * From Paiements where status = 'Unpaid'";
        $stmt = $this->conn->prepare($query);
        $stmt->execute();
        $paiements = [];

        while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
            $queryforcommande = "Select * From Commandes WHERE id='{$row['commande_id']}'";
            $stmtforcommande = $this->conn->prepare($queryforcommande);
            $stmtforcommande->execute();
            $commandeinfo=$stmtforcommande->fetch(PDO::FETCH_ASSOC);

            $queryforclient = "Select * From Clients WHERE id={$commandeinfo['client_id']}";
            $stmtforclient = $this->conn->prepare($queryforclient);
            $stmtforclient->execute();
            $clientinfo=$stmtforclient->fetch(PDO::FETCH_ASSOC);

            $client = new Client($clientinfo['name'],$clientinfo['email'],$clientinfo['id']);

            $commande = new Commande($commandeinfo['montantTotal'],$commandeinfo['status'],$client,$commandeinfo['id']);
            switch($row['type']){
                case 'CarteBancaire':
                    $queryforCarteBancaire = "Select * From CarteBancaires WHERE paiement_id={$row['id']}";
                    $stmtforCarteBancaire = $this->conn->prepare($queryforCarteBancaire);
                    $stmtforCarteBancaire->execute();
                    $carteinfo =$stmtforCarteBancaire->fetch(PDO::FETCH_ASSOC);
                    $paiements[] = new CreditCard($row['montant'], $row['status'],$commande, $row['type'],$carteinfo['creditCardNumber'],$row['datePaiment'],$row['id']);
                    break;

                case 'Paypal':
                    $queryforpaypal = "Select * From paypals WHERE paiement_id={$row['id']}";
                    $queryforpaypal = $this->conn->prepare($queryforpaypal);
                    $queryforpaypal->execute();
                    $paypalinfo =$queryforpaypal->fetch(PDO::FETCH_ASSOC);
                    $paiements[] = new PayPal($row['montant'], $row['status'],$commande, $row['type'],$paypalinfo['paymentEmail'],$paypalinfo['paymentPassword'],$row['datePaiment'],$row['id']);
                    break;

                case 'Virement':
                    $queryforvirement = "Select * From virements WHERE paiement_id={$row['id']}";
                    $stmtforvirement = $this->conn->prepare($queryforvirement);
                    $stmtforvirement->execute();
                    $virementinfo =$stmtforvirement->fetch(PDO::FETCH_ASSOC);
                    $paiements[] = new Virement($row['montant'], $row['status'],$commande, $row['type'],$virementinfo['rib'],$row['datePaiment'],$row['id']);
                    break;
            };
        }
        return $paiements;
    }

    public function insertObject($paiement)
    {
        $query = "Insert INTO Paiements (montant,status,commande_id,type) VALUES (:montant, :status, :commande_id, :type)";
        $stmt = $this->conn->prepare($query);
        
        $montant = $paiement->get_montant();
        $status = $paiement->get_status();
        $commande_id = $paiement->get_commande()->get_id();
        $type = $paiement->get_type();

        $stmt->bindParam(':montant', $montant);
        $stmt->bindParam(':status', $status);
        $stmt->bindParam(':commande_id', $commande_id);
        $stmt->bindParam(':type', $type);
        $stmt->execute();

        $paiment_id = $this->conn->lastInsertId();

        switch($type){
            case 'CarteBancaire':
                $query ="Insert INTO CarteBancaires (paiement_id,creditCardNumber) VALUES (:paiment_id,:creditCardNumber)";
                $stmt = $this->conn->prepare($query);
                $creditCardNumber=$paiement->get_numCard();
                $stmt->bindParam(':paiment_id', $paiment_id);
                $stmt->bindParam(':creditCardNumber', $creditCardNumber);
                break;
            case 'Paypal':
                $query ="Insert INTO Paypals (paiement_id,paymentEmail,paymentPassword) VALUES (:paiment_id,:paymentEmail,:paymentPassword)";
                $stmt = $this->conn->prepare($query);
                $stmt->bindParam(':paiment_id', $paiment_id);
                $paymentEmail=$paiement->get_paymentEmail();
                $paymentPassword = $paiement->get_paymentPassword();
                $stmt->bindParam(':paymentEmail', $paymentEmail);
                $stmt->bindParam(':paymentPassword', $paymentPassword);
                break;
            case 'Virement':
                $query ="Insert INTO Virements (paiement_id,rib) VALUES (:paiment_id,:rib)";
                $stmt = $this->conn->prepare($query);
                $rib = $paiement->get_rib();
                $stmt->bindParam(':paiment_id', $paiment_id);
                $stmt->bindParam(':rib', $rib);
                break;
        }
        $stmt->execute();
    }


    public function updatestatus($paiement){
        $query = "UPDATE paiements SET status = 'Paid' WHERE id={$paiement->get_id()}";
        $stmt = $this->conn->prepare($query);
        $stmt->execute();
    }
}