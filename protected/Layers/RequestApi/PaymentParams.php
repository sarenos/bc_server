<?php
class PaymentParams
{
    public $reqMRef;
    public $reqMId;
    public $reqCUser;
    public $reqBank;
    public $moduleId;
    public $moduleRef;
    public $pmTypeCode;
    public $pmSum;
    public $pmName;
    public $pmCurrency;
    public $pmBranch;
    public $pan_a;
    public $exDate_a;
    public $can_a;
    public $acc_a;
    public $mfo_a;
    public $okpo_a;
    public $name_a;
    public $pan_b;
    public $exDate_b;
    public $can_b;
    public $acc_b;
    public $mfo_b;
    public $okpo_b;
    public $name_b;  
    
    public function __construct()
    {
        $this->_paymentParams->exDate_a = '';
        $this->_paymentParams->can_a = '';
        $this->_paymentParams->acc_a = '';
        $this->_paymentParams->mfo_a = '';
        $this->_paymentParams->okpo_a = '';
        $this->_paymentParams->name_a = '';
        $this->_paymentParams->exDate_b = '';
        $this->_paymentParams->can_b = '';
        $this->_paymentParams->acc_b = '';
        $this->_paymentParams->mfo_b = '';
        $this->_paymentParams->okpo_b = '';
        $this->_paymentParams->name_b = '';
        $this->_paymentParams->reqMRef = '';
        $this->_paymentParams->reqMId = '';
        $this->_paymentParams->reqCUser = '';
        $this->_paymentParams->reqBank = '';
        $this->_paymentParams->moduleId = '';
        $this->_paymentParams->moduleRef = '';
        $this->_paymentParams->pmTypeCode = '';
        $this->_paymentParams->pmSum = '';
        $this->_paymentParams->pmName = '';
        $this->_paymentParams->pmCurrency = '';
        $this->_paymentParams->pmBranch = '';
        $this->_paymentParams->pan_a = '';
        $this->_paymentParams->pan_b = '';
    }
}
?>
