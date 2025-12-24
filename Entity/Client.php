<?php 

class Client{
    private $id = null;
    private $name;
    private $email;

    public function __construct($id=null,$name,$email){
        $this->id = $id;
        $this->name = $name;
        $this->email = $email;
    }

    public function get_id(){
        return $this->id;
    }
    public function get_name(){
        return $this->name;
    }
    public function get_email(){
        return $this->email;
    }

    public function set_id($id){
        $this->id = $id;
    }
    public function set_name($name){
        $this->name = $name;
    }
    public function set_email($email){
        $this->email = $email;
    }

}



