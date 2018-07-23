<?php

namespace raphaelbsr\billing\exceptions;

use Exception;
use raphaelbsr\billing\models\CieloError;

class OrderRequestException extends Exception {

    private $cieloError;

    /**
     * @param string $message
     * @param int    $code
     * @param null   $previous
     */
    public function __construct($message, $code, $previous = null) {
        parent::__construct($message, $code, $previous);
    }

    /**
     * @return mixed
     */
    public function getCieloError() {
        return $this->cieloError;
    }

    /**
     * @param CieloError $cieloError
     *
     * @return $this
     */
    public function setCieloError(CieloError $cieloError) {
        $this->cieloError = $cieloError;
        return $this;
    }

    public function getCieloErrorMessages() {

        $toReturn = '[' . $this->getCode() . ' - ' . $this->getMessage() . ']' . ' <br/>';
        $e = $this;
        if ($e->getCieloError() != null) {
            do {
                $toReturn .= $e->getCieloError()->getCode() . ' - ' . $e->getCieloError()->getMessage() . ' <br/>';
            } while ($e = $e->getPrevious());
        }
        return $toReturn;
    }

}
