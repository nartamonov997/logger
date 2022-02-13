<?php
namespace Logger;

use Psr\Log\AbstractLogger;
use Psr\Log\LoggerInterface;
use Logger\Handlers\Handler;
use Logger\Exceptions\Exception;

class LogLevel
{
    const LEVEL_EMERGENCY = 'emergency';
    const LEVEL_ALERT     = 'alert';
    const LEVEL_CRITICAL  = 'critical';
    const LEVEL_ERROR     = 'error';
    const LEVEL_WARNING   = 'warning';
    const LEVEL_NOTICE    = 'notice';
    const LEVEL_INFO      = 'info';
    const LEVEL_DEBUG     = 'debug';
    
    public static function getLevelCode($level) {
        switch ($level) {
            case 'error':
                return '001';
            case 'info':
                return '002';
            case 'debug':
                return '003';
            case 'notice':
                return '004';
            case 'critical':
                return '005';
            case 'emergency':
                return '006';
            case 'alert':
                return '007';
            case 'warning':
                return '008';
            default:
                throw new Exception('incorrect level info');
        }
    }
    
    /**
     * Получить все уровни логирования
     * @return array  уровни логирования
     */
    public static function getAllLevelValues() {
        $result = [];
        
        $reflect = new \ReflectionClass('\\' . __CLASS__);
        $consts  = $reflect->getReflectionConstants();
        foreach ($consts as $const) {
            $constName = $const->name;
            $constantValue = constant('\\' . __CLASS__ . '::'. $constName);
            $result[] = $constantValue;
        }
        
        return $result;
    }
    
    
    
}