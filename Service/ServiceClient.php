<?php

class ServiceClient
{
    private $clientRepo;

    public function __construct($clientRepo)
    {
        $this->clientRepo = $clientRepo;
    }

    public function clientCredentialsInput()
    {
        echo "enter the name of the client :\t";
        $name = readline();
        echo "enter the email of the client :\t";
        $email = readline();

        return [
            "name" => $name,
            "email" => $email
        ];
    }

    public function createClient()
    {
        $credentials = $this->clientCredentialsInput();
        if (!preg_match("/^[a-zA-Z-' ]*$/", $credentials['name']) && !preg_match("/^[a-zA-Z0-9._%+-]+@[a-zA-Z0-9.-]+\.[a-zA-Z]{2,}$/", $credentials['email'])) {
            echo "the credentials are not valid";
        } else {
            $client = new Client($credentials['name'], $credentials['email']);
            $this->clientRepo->insertobject($client);
            echo "addition success";
        }
    }

    public function showClients()
    {
        $clients = $this->clientRepo->fetchall();

        echo "\nClients : \n";

        foreach ($clients as $client) {
            echo "client : " . $client->get_id() . "  name : " . $client->get_name() . "  email : " . $client->get_email() . "\n";
        }
    }
}
