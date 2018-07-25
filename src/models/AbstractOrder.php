<?php

namespace raphaelbsr\billing\models;

/**
 * Description of AbstractPaymentRequest
 *
 * @author rapha
 */
abstract class AbstractOrder extends AbstractModel {

    public $MerchantOrderId;
    public $Payment;
    public $Customer;

}
