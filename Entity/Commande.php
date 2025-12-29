<?php 

class Commande{
    private $id;
    private $montantTotal;
    private $status;
    private Client $client;

    public function __construct($montantTotal,$status,$client,$id=null)
    {
        $this->montantTotal = $montantTotal;
        $this->status = $status;
        $this->client = $client;
        $this->id = $id;
    }

    public function get_id()
    {
        return $this->id;
    }
    public function get_montantTotal()
    {
        return $this->montantTotal;
    }
    public function get_status()
    {
        return $this->status;
    }
    public function get_client()
    {
        return $this->client;
    }
    
    public function set_id($id)
    {
        $this->id = $id;
    }
    public function set_montantTotal($montantTotal)
    {
        $this->montantTotal = $montantTotal;
    }
    public function set_status($status)
    {
        $this->status = $status;
    }
     public function set_client($client)
     {
        $this->client = $client ;
    }
}