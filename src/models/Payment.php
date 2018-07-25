<?php

namespace raphaelbsr\billing\models;

use yii\base\Model;

/**
 * Description of Payment
 *
 * @author rapha
 */
class Payment extends AbstractModel {

    public function init() {
        parent::init();
        $this->CreditCard = (new CreditCard($this->CreditCard))->getAttributes();
    }

    const PAYMENTTYPE_CREDITCARD = 'CreditCard';
    const PAYMENTTYPE_DEBITCARD = 'DebitCard';
    const PAYMENTTYPE_ELECTRONIC_TRANSFER = 'ElectronicTransfer';
    const PAYMENTTYPE_BOLETO = 'Boleto';
    const PROVIDER_BRADESCO = 'Bradesco';
    const PROVIDER_BANCO_DO_BRASIL = 'BancoDoBrasil';
    const PROVIDER_SIMULADO = 'Simulado';

    public $Type;
    public $Amount;
    public $Installments = 1;
    public $SoftDescriptor;
    public $CreditCard;
    public $Capture = false;
    public $Recurrent = false;
    public $Tid;
    public $ProofOfSale;
    public $AuthorizationCode;
    public $Provider;
    public $ReceivedDate;
    public $Status;
    public $IsSplitted;
    public $ReturnMessage;
    public $ReturnCode;
    public $PaymentId;
    public $Currency;
    public $Country;
    public $Links;
    public $ServiceTaxAmount;
    public $Interest;
    public $Authenticate;
    public $VoidedAmount;
    public $VoidedDate;


}
