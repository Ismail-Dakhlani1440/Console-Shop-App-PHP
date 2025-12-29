<?php 

class Virement extends Paiement{
    public $rib;
    
    public function __construct($montant,$status,$commande,$type,$rib,$datePaiment=null,$id=null)
    {
        return parent::__construct($montant,$status,$commande,$type,$datePaiment,$id);
        $this->rib = $rib;
    }

    public function get_rib()
    {
        return $this->rib;
    }

    public function set_rib($rib)
    {
        $this->rib = $rib;
    }

    public function pay()
    {
        return "payed with rib : ".$this->rib;
    }
}