<?php
namespace App\Actions;

class GetErrorAction{

public static function AccessDenied                    (){ return self::getCodes('000A'); }
public static function isInvalid        ($erOrigin, $varName){ return self::getCodes('001A', $erOrigin, $varName);}
public static function isEmpty          ($erOrigin, $varName){ return self::getCodes('001B', $erOrigin, $varName);}
public static function doesNotExist     ($erOrigin, $varName){ return self::getCodes('001C', $erOrigin, $varName);}
public static function notMatching      ($erOrigin, $varName){ return self::getCodes('001D', $erOrigin, $varName);}
public static function AlreadyReported  ($erOrigin, $varName){ return self::getCodes('001E', $erOrigin, $varName);}
public static function NotMatchingHash  ($erOrigin, $varName){ return self::getCodes('001F', $erOrigin, $varName);}


private static function getCodes ($code, $eOrginName = null, $eVarName = null){
    self::$erroCodes[$code]['message'] = self::setName(self::$erroCodes[$code]['message'],$eOrginName,$eVarName);
    return (object)self::$erroCodes[$code];
}
private static function setName($message,$originName, $varName = ''){
    if ($varName != '') $varName .= " ";
    return $originName . " " .$varName.$message;
}

private static $erroCodes = [
    "000A" => [
        "error" => "000A",
        "message" => "Přístup zamítnut.",
        "code" => 401
    ], 
    "001A" => [
        "error" => "001A",
        "message" => "is invalid.",
        "code" => 401
    ],
    "001B" => [
        "error" => "001B",
        "message" => "je/jsou prázdné.",
        "code" => 404
    ],
    "001C" => [
        "error" => "001D",
        "message" => "neexistuje.",
        "code" => 400
    ],
    "001D" => [
        "error" => "001D",
        "message" => "se neschoduje.",
        "code" => 400
    ],
    "001E" => [
        "error" => "001E",
        "message" => "je již nahlášen.",
        "code" => 400
    ],
    "001F" => [
        "error" => "001F",
        "message" => "se neschoduje.",
        "code" => 400]

];


}
?>