<?php 

include_once 'Interface\PaiementInterface.php';

abstract class Paiement implements PaiementInterface{
    protected $id;
    protected $montant;
    protected $status;
    protected $datePaiment;
    protected $commande;
    protected $type;

    public function __construct($montant,$status,$commande,$type,$datePaiment=null,$id=null)
    {
        $this->montant = $montant;
        $this->status = $status;
        $this->commande = $commande;
        $this->type = $type;
        $this->datePaiment = $datePaiment;
        $this->id= $id;
    }

    public function get_id()
    {
        return $this->id;
    }
    public function get_montant()
    {
        return $this->montant;
    }
    public function get_status()
    {
        return $this->status;
    }
    public function get_datePaiment()
    {
        return $this->datePaiment;
    }
    public function get_commande()
    {
        return $this->commande;
    }
    public function get_type()
    {
        return $this->type;
    }

    public function set_id($id)
    {
        $this->id = $id;
    }
    public function set_montant($montant)
    {
        $this->montant = $montant;
    }
    public function set_status($status)
    {
        $this->status = $status;
    }
    public function set_datePaiment($datePaiment)
    {
        $this->datePaiment = $datePaiment;
    }
    public function set_commande($commande)
    {
        $this->commande = $commande;
    }
    public function set_type($type)
    {
        $this->type = $type;
    }


};