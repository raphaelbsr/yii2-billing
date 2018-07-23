<?php



namespace raphaelbsr\billing\models;

/**
 * Description of AbstractPaymentRequest
 *
 * @author rapha
 */
abstract  class AbstractOrder extends \yii\base\Model{
    
    public $MerchantOrderId;
    public $Payment;
    public $Customer;
    
}
