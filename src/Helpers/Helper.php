<?php
namespace Logger\Helpers;

use Psr\Log\AbstractLogger;
use Psr\Log\LoggerInterface;
use Logger\Handlers\Handler;

class Helper
{
    /**
     * Перевод в верблюжью нотацию("is_enabled" в "isEnabled")
     */
    public static function undercoreToCamelCase($string, $capitalizeFirstCharacter = false) 
    {

        $str = str_replace(' ', '', ucwords(str_replace('_', ' ', $string)));
        if (!$capitalizeFirstCharacter) {
            $str[0] = strtolower($str[0]);
        }
        return $str;
    }
}