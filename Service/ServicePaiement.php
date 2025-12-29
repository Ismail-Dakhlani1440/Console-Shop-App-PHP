<?php

class ServicePaiement
{
    private $paimentRepo;
    private $commandeRepo;

    public function __construct($paimentRepo, $commandeRepo)
    {
        $this->paimentRepo = $paimentRepo;
        $this->commandeRepo = $commandeRepo;
    }

    public function PaimentCredentialsInput()
    {
        echo "\n pour quel commande voulez vous créer un paiment : ";
        $command_id = readline();
        echo "quel type de payment voulez vous choisir : ";
        echo "\n entrer 1 pour CarteBancaire";
        echo "\n entrer 2 pour Paypal";
        echo "\n entrer 3 pour Virement";
        echo "\n votre choix : ";
        $input = (int) readline();
        switch ($input) {
            case 1:
                echo "entrer votre numero de carte bancaire : ";
                $numcard = readline();
                return [
                    'status' => 'unpaid',
                    'command_id' => $command_id,
                    'type' => 'CarteBancaire',
                    'numcard' => $numcard
                ];
                break;
            case 2:
                echo "entrer votre email : ";
                $email = readline();
                echo "entrer votre mot de passe : ";
                $password = readline();
                return [
                    'status' => 'unpaid',
                    'command_id' => $command_id,
                    'type' => 'Paypal',
                    'email' => $email,
                    'password' => $password
                ];
                break;
            case 3:
                echo "entrer votre Rib : ";
                $rib = readline();
                return [
                    'status' => 'unpaid',
                    'command_id' => $command_id,
                    'type' => 'Virement',
                    'rib' => $rib
                ];
                break;
            default:
                echo "Veuiller choisir une des option precedante ";
                break;
        }
    }

    public function createPayment()
    {
        $PaymentCredentials = $this->PaimentCredentialsInput();
        $commandes = $this->commandeRepo->fetchNonDelivred();

        foreach ($commandes as $commande) {
            if ($commande->get_id() == $PaymentCredentials['command_id']) {
                $selectedcommande = $commande;
            };
        }

        switch ($PaymentCredentials['type']) {
            case 'CarteBancaire':
                if (!empty($selectedcommande) && !empty($PaymentCredentials['numcard'])) {
                    $payment = new CreditCard($selectedcommande->get_montantTotal(), $PaymentCredentials['status'], $selectedcommande, $PaymentCredentials['type'], $PaymentCredentials['numcard']);
                }
                break;
            case 'Paypal':
                if (!empty($selectedcommande) && !empty($PaymentCredentials['email']) && !empty($PaymentCredentials['password'])) {
                    $payment = new PayPal($selectedcommande->get_montantTotal(), $PaymentCredentials['status'], $selectedcommande, $PaymentCredentials['type'], $PaymentCredentials['email'], $PaymentCredentials['password']);
                }
                break;
            case 'Virement':
                if (!empty($selectedcommande) && !empty($PaymentCredentials['rib'])) {
                    $payment = new Virement($selectedcommande->get_montantTotal(), $PaymentCredentials['status'], $selectedcommande, $PaymentCredentials['type'], $PaymentCredentials['rib']);
                }
                break;
        };

        $this->paimentRepo->insertObject($payment);
    }

    public function showPayment($Payments=null)
    {
        if (!isset($Payments)) {
            $Payments = $this->paimentRepo->fetchall();
        }

        foreach ($Payments as $Payment) {
            echo "Payment : " . $Payment->get_id() . "  Montant : " . $Payment->get_montant() . "  Status : " . $Payment->get_status() . " Commande_id : " . $Payment->get_commande()->get_id() ." Type : ". $Payment->get_type() ."\n";
        }
    }

    public function traitmentInput(){
        echo "pour quel paiement voulez vous faire un traitement : ";
        $payment_id = readline();
        return $payment_id;
    }

    public function traiterPayment(){
        $payments = $this->paimentRepo->fetchNonPaid();
        $payment_id = $this->traitmentInput();

        foreach ($payments as $payment) {
            if ($payment->get_id() == $payment_id) {
                $selectedpayment = $payment;
            };
    } 
        if(!empty($selectedpayment)){
        $commande= $selectedpayment->get_commande();
        $this->paimentRepo->updatestatus($selectedpayment);
        $this->commandeRepo->updatestatus($commande);
        }else{
            echo "enter a valid id";
        }
    }

}