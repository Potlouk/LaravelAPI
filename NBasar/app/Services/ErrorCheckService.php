<?php

namespace App\Services;

use App\Actions\GetErrorAction;
use App\Exceptions\AppException;
use App\Exceptions\ExceptionTypes;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Hash;

class ErrorCheckService {
    private $errorOriginName = 'unknown';
    private static $caller;

    public function __construct(ExceptionTypes $exceptionType) {
        $this->errorOriginName = $exceptionType->name. ":";
        self::$caller = new AppException();
    }

    public function checkIfExisting(Model $class,$value, $costumeKey = false) {
        if($costumeKey != false)
            if (!$class::where([$costumeKey => $value])->exists())
                throw new self::$caller(GetErrorAction::doesNotExist($this->errorOriginName,$costumeKey,$value));

        if (!$class::where([$class->getKeyName() => $value])->exists())
            throw new self::$caller(GetErrorAction::doesNotExist($this->errorOriginName,class_basename($class)));
   
    }
    
    public function checkIfEmpty($data, $eVarName) {
        if (is_object($data)){
            if (empty(get_object_vars($data)))
            throw new self::$caller(GetErrorAction::isEmpty($this->errorOriginName,$eVarName));
        }else
        if (empty($data) || $data == null)
            throw new self::$caller(GetErrorAction::isEmpty($this->errorOriginName,$eVarName));
    }

    public function checkIfMatching($dataA,$dataB, $eVarName) {
        if ($dataA != $dataB)
            throw new self::$caller(GetErrorAction::notMatching($this->errorOriginName,$eVarName));
    }

    public function checkIfMashMatching($dataA,$dataB, $eVarName) {
        if (!Hash::check($dataA, $dataB))
            throw new self::$caller(GetErrorAction::notMatching($this->errorOriginName,$eVarName));
    }

    public function checkIfAlreadyReported($array,$data, $eVarName) {
        if (in_array($data, $array))
            throw new self::$caller(GetErrorAction::AlreadyReported($this->errorOriginName,$eVarName));
    }

    public function checkIfAlreadyExisting(Model $class,$value, $costumeKey) {
        if ($class::where([$costumeKey => $value])->exists())
            throw new self::$caller(GetErrorAction::doesExist($this->errorOriginName,$costumeKey,$value));
    }
}
?>