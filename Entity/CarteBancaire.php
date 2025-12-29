<?php 

class CreditCard extends Paiement{
    public $numCard;
    
    public function __construct($montant,$status,$commande,$type,$numCard,$datePaiment=null,$id=null)
    {
        return parent::__construct($montant,$status,$commande,$type,$datePaiment,$id);
        $this->numCard = $numCard;
    }

    public function get_numCard()
    {
        return $this->numCard;
    }

    public function set_numCard($numCard)
    {
        $this->numCard = $numCard;
    }

    public function pay()
    {
        return "payed with creditcard : ".$this->numCard;
    }
}