<?php

namespace raphaelbsr\billing;

use yii\base\Component;

/**
 * Description of Billing
 *
 * @author rapha
 */
class Billing extends Component{
    
    const ENV_SANDBOX = 'sandbox';
    const ENV_PROD = 'prod';   
    public $enviroment = self::ENV_SANDBOX;
            
}
