<?php

namespace raphaelbsr\billing\models;

/**
 * Description of CardBin
 *
 * @author rapha
 */
class CardBin extends \yii\base\Model{
    
    const STATUS_AUTHORIZED = 00;
    const STATUS_NOT_SUPORTED_PROVIDER = 01;
    const STATUS_NOT_SUPORTED_CARD = 02;
    const STATUS_BLOCKED = 73;
    
    const CARDTYPE_CREDIT = 'Credito';
    const CARDTYPE_DEBIT = 'Debit';
    const CARDTYPE_BOTH = 'Multiplo';
    
    public $Status;
    public $Provider;
    public $CardType;
    public $ForeignCard;
    
    
}
