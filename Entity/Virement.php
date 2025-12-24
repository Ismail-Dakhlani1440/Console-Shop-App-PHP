<?php 

include 'Entity\Paiement.php';

class Virement extends Paiement{
    public $rib;
    
    public function __construct($montant,$status,$datePaiment,$rib){
        $this->montant = $montant;
        $this->status = $status;
        $this->datePaiment = $datePaiment;
        $this->rib = $rib;
    }

    public function get_rib(){
        return $this->rib;
    }

    public function set_rib($rib){
        $this->rib = $rib;
    }

    public function pay(){
        return "payed with rib : ".$this->rib;
    }
}