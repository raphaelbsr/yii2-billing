<?php

namespace raphaelbsr\billing\models;

use yii\base\Model;

/**
 * Description of CartaoCredito
 *
 * @author rapha
 */
class CreditCard extends AbstractModel{
    
    public $CustomerName;
    public $CardNumber;
    public $Holder;
    public $ExpirationDate;
    public $SaveCard = false;
    public $Brand;
    public $SecurityCode;
    public $CardToken;    
    
}