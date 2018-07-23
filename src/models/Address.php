<?php

namespace raphaelbsr\billing\models;

/**
 * Description of Address
 *
 * @author rapha
 */
class Address extends \yii\base\Model {

    public $Street;
    public $Number;
    public $Complement;
    public $ZipCode;
    public $City;
    public $State;
    public $Country;

}