<?php 

include 'Entity\Paiement.php';

class CreditCard extends Paiement{
    public $numCard;
    
    public function __construct($montant,$status,$datePaiment,$numCard){
        $this->montant = $montant;
        $this->status = $status;
        $this->datePaiment = $datePaiment;
        $this->numCard = $numCard;
    }

    public function get_numCard(){
        return $this->numCard;
    }

    public function set_numCard($numCard){
        $this->numCard = $numCard;
    }

    public function pay(){
        return "payed with creditcard : ".$this->numCard;
    }
}