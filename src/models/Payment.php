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
    const TRANSACTION_STATUS = [
        0 => "Aguardando atualização de status",
        1 => "Pagamento apto a ser capturado ou definido como pago",
        2 => "Pagamento confirmado e finalizado",
        3 => "Pagamento negado por Autorizador",
        10 => "Pagamento cancelado",
        11 => "Pagamento cancelado após 23:59 do dia de autorização",
        12 => "Aguardando Status de instituição financeira",
        13 => "Pagamento cancelado por falha no processamento ou por ação do AF",
        20 => "Recorrência agendada",
    ];

    public $Type;
    public $Amount;
    public $Installments = 1;
    public $SoftDescriptor;
    public $CreditCard;
    public $Capture = true;
    public $Recurrent = false;
    public $CapturedAmount;
    public $CapturedDate;
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
