<?php

include_once 'Entity\Client.php';
include_once 'Entity\Commande.php';
include_once 'Entity\Paiement.php';
include_once 'Entity\CarteBancaire.php';
include_once 'Entity\Paypal.php';
include_once 'Entity\Virement.php';
include_once 'Database\DatabaseConnection.php';
include_once 'Repository\Repo.php';
include_once 'Repository\ClientRepository.php';
include_once 'Repository\CommandeRepository.php';
include_once 'Repository\PaiementRepository.php';
include_once 'Service\ServiceClient.php';
include_once 'Service\ServiceCommande.php';
include_once 'Service\ServicePaiement.php';

class App
{   
    private ClientRepository $clientrepo;
    private CommandeRepository $commanderepo;
    private PaiementRepository $paiementrepo;
    private ServiceClient $serviceClient;
    private ServiceCommande $serviceCommande;
    private ServicePaiement $servicePaiement;
    private $connection;

    public function __construct()
    {
        $db = new DatabaseConnection();
        $this->connection = $db->get_conn();
        $this->clientrepo = new ClientRepository($this->connection);
        $this->commanderepo = new CommandeRepository($this->connection);
        $this->paiementrepo = new PaiementRepository($this->connection);
        $this->serviceClient = new ServiceClient($this->clientrepo);
        $this->serviceCommande = new ServiceCommande($this->commanderepo,$this->clientrepo);
        $this->servicePaiement = new ServicePaiement($this->paiementrepo,$this->commanderepo);
        $this->showMenu();
    }

    public function manageRequest()
    {
        $request = readline();
        switch ($request) {
            case 1:
                echo "Créer un client : ";
                $this->serviceClient->createClient();
                $this->showMenu();
                break;
            case 2:
                echo "Afficher les clients : ";
                $this->serviceClient->showClients();
                $this->showMenu();
                break;
            case 3:
                echo "Créer une commande : ";
                $this->serviceClient->showClients();
                $this->serviceCommande->createCommande();
                $this->showMenu();
                break;
            case 4:
                echo "Payer une commande : ";
                $this->showPaymementMenu();
                break;
            case 5:
                echo "Afficher les commandes : ";
                $this->serviceCommande->showCommandes();
                $this->showMenu();
                break;
            case 0:
                echo "GoodBye :(";
                exit();
            default:
                echo "Veuiller choisir une des option precedante ";
                $this->showMenu();
                break;
        }
    }

    public function showMenu()
    {
        echo "\n\n\n
    ==============================
    SYSTEME DE PAIEMENT - MENU
    ==============================
    1. Créer un client
    2. Afficher les clients
    3. Créer une commande
    4. Payer une commande
    5. Afficher les commandes
    0. Quitter
    ------------------------------
    Votre choix : ";
        $this->manageRequest();
    }

    public function managePaymementRequest()
    {
        $secondrequest = readline();
        switch($secondrequest){
            case 1:
                echo "Créer un paiement \n";
                $this->serviceCommande->showCommandes($this->commanderepo->fetchNonDelivred());
                $this->servicePaiement->createPayment();
                $this->showPaymementMenu();
                break;
            case 2:
                $this->servicePaiement->showPayment();
                $this->showPaymementMenu();
                break;
            case 3:
                $this->servicePaiement->showPayment($this->paiementrepo->fetchNonPaid());
                $this->servicePaiement->traiterPayment();
                break;
            case 0:
                $this->showMenu();
                break;
            default:
                echo "Veuiller choisir une des option precedante ";
                $this->showPaymementMenu();
        }
    }

    public function showPaymementMenu()
    {
        echo "\n\n\n
    ==============================
         PAIEMENT - MENU
    ==============================
    1. Créer un paiement
    2. Consulter les paiement
    3. Traiter un paiment
    0. retour
    ------------------------------
    Votre choix : ";

    $this->managePaymementRequest();
    }


    public function init()
    {
        $this->showMenu();
    }

}
