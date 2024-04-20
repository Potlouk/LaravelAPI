<?php

namespace App\Exceptions;

use Exception;
class AppException extends Exception{
    public $error, $data;
    public function __construct($data = null,$returnValue = null) {
        if (!is_null($data)){
            $data = (object) $data;
            parent::__construct($data->message, $data->code);
            $this->error = $data->error;
            $this->data = $returnValue;
        }
    }
    public function getData() {
        return $this->data;
    }
    public function getErrorCode() {
        return $this->error;
    }
}
?>