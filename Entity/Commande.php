<?php 

class Commande{
    private $id;
    private $montantTotal;
    private $status;

    public function __construct($id,$montantTotal,$status){
        $this->id = $id;
        $this->montantTotal = $montantTotal;
        $this->status = $status;
    }

    public function get_id(){
        return $this->id;
    }
    public function get_montantTotal(){
        return $this->montantTotal;
    }
    public function get_status(){
        return $this->status;
    }
    
    public function set_id($id){
        $this->id = $id;
    }
    public function set_montantTotal($montantTotal){
        $this->montantTotal = $montantTotal;
    }
    public function set_status($status){
        $this->status = $status;
    }
}