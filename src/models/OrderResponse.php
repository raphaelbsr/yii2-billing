<?php

namespace raphaelbsr\billing\models;

/**
 * Description of Response
 *
 * @author rapha
 */
class OrderResponse extends AbstractOrder {

    public function init() {
        parent::init();
        $this->Payment = (new Payment($this->Payment))->getAttributes();
        $this->Customer = (new Customer($this->Customer))->getAttributes();
    }
}