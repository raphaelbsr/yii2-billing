<?php

namespace raphaelbsr\billing\models;

use yii\base\Model;

/**
 * Description of Customer
 *
 * @author rapha
 */
class Customer extends Model {
    
    public $Name;
    public $Address;
    
    public function init() {
        parent::init();
        $this->Address = new Address($this->Address);
    }
    
}
