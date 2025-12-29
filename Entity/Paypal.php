<?php 


class PayPal extends Paiement{
    private $paymentEmail;
    private $paymentPassword;
    
    public function __construct($montant,$status,$commande,$type,$paymentEmail,$paymentPassword,$datePaiment=null,$id=null)
    {
        return parent::__construct($montant,$status,$commande,$type,$datePaiment,$id);
        $this->paymentEmail = $paymentEmail;
        $this->paymentPassword = $paymentPassword;
    }

    public function get_paymentEmail()
    {
        return $this->paymentEmail;
    }
    public function get_paymentPassword()
    {
        return $this->paymentPassword;
    }

    public function set_paymentEmail($paymentEmail)
    {
        $this->paymentEmail = $paymentEmail;
    }
    public function set_paymentPassword($paymentPassword)
    {
        $this->paymentPassword = $paymentPassword;
    }

    public function pay()
    {
        return "payed with Account email : ".$this->paymentEmail;
    }
}