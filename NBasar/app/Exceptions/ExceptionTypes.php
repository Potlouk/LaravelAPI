<?php
namespace App\Exceptions;

enum ExceptionTypes{
    case EmailException;
    case ImageException;
    case LabelException;
    case UserException;
    case EstateException;
}

?>