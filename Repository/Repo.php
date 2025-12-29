<?php

include_once 'Interface\Repository.php';

abstract class Repo implements Repository{

    protected $conn;

     public function __construct($conn)
    {
        $this->conn = $conn ;
    }

}