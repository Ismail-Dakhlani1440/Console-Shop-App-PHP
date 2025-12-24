<?php 

abstract class Paiement{
    protected $id;
    protected $montant;
    protected $status;
    protected $datePaiment;

    public function get_id(){
        return $this->id;
    }
    public function get_montant(){
        return $this->montant;
    }
    public function get_status(){
        return $this->status;
    }
    public function get_datePaiment(){
        return $this->datePaiment;
    }

    public function set_id($id){
        $this->id = $id;
    }
    public function set_montant($montant){
        $this->montant = $montant;
    }
    public function set_status($status){
        $this->status = $status;
    }
    public function set_datePaiment($datePaiment){
        $this->datePaiment = $datePaiment;
    }

    abstract public function Pay();

};