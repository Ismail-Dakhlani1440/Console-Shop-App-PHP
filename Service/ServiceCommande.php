<?php

include_once 'Repository\CommandeRepository.php';

class ServiceCommande
{
    private $commandeRepo;
    private $clientRepo;

    public function __construct($commandeRepo, $clientRepo)
    {
        $this->commandeRepo = $commandeRepo;
        $this->clientRepo = $clientRepo;
    }

    public function CommandeCredentialsInput()
    {
        echo 'Pour quel client voulais vous créer cette commande  : ';
        $client_id = readline();
        echo 'entrer le montantTotal : ';
        $montantTotal = (int) readline();

        return [
            'client_id' => $client_id,
            'montantTotal' => $montantTotal
        ];
    }


    public function createCommande()
    {
        $credentials = $this->CommandeCredentialsInput();
        $clients =  $this->clientRepo->fetchall();
        foreach ($clients as $client) {
            if ($client->get_id() == $credentials['client_id']) {
                $selectedclient = $client;
            };
        }
        if (!empty($selectedclient) && !empty($credentials['montantTotal'])) {
            $commande = new Commande($credentials['montantTotal'], 'Not Delivered', $selectedclient);
            $this->commandeRepo->insertObject($commande);
            echo "addition sucess";
        } else {
            echo "the credentials are not valid";
        }
    }

    public function showCommandes($Commandes = null)
    {
        if (!isset($Commandes)) {
            $Commandes = $this->commandeRepo->fetchall();
        }
        echo "\n Commandes : \n";

        foreach ($Commandes as $Commande) {
            echo "Commande : " . $Commande->get_id() . "  Montant Total : " . $Commande->get_montantTotal() . "  Status : " . $Commande->get_status() . " Client_id : " . $Commande->get_client()->get_id() . "\n";
        }
    }
}
