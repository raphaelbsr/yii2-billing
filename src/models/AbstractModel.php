<?php

namespace raphaelbsr\billing\models;

use yii\base\Model;

/**
 * Description of AbstractModel
 *
 * @author rapha
 */
class AbstractModel extends Model {

    public function getAttributes($names = null, $except = array()) {

        $values = [];
        if ($names === null) {
            $names = $this->attributes();
        }
        foreach ($names as $name) {
            if ($this->$name != null) {
                $values[$name] = $this->$name;
            }
        }
        foreach ($except as $name) {
            unset($values[$name]);
        }
        return !empty($values) ? $values : null ;
    }

}
