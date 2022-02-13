<?php
namespace Logger\Handlers;

use Psr\Log\AbstractLogger;
use Psr\Log\LoggerInterface;
use Logger\LogLevel;
use Logger\Helpers\Helper;
use Logger\Formatters\LineFormatter;

/**
 * Class Handler
 */
abstract class Handler extends AbstractLogger implements LoggerInterface
{
    /**
     * @var bool Включен ли Handler
     */
    protected $is_enabled = true;
    // какие уровни логирования обрабатывать
    protected $levels = [];
    protected $formatter;

    /**
     * Конструктор
     *
     * @param array $attributes
     */
    public function __construct(array $attributes = [])
    {
        // переданные в массиве параметры установим через set{имя_параметра}
        foreach ($attributes as $attribute => $value)
        {
            $attribute = Helper::undercoreToCamelCase($attribute);
            $method = "set{$attribute}";
            if (method_exists($this, $method)) {
                $this->$method($value);
            }
        }
        
        // если в конструктор не передан параметр levels(уровни логирования), 
        // то значит нужно обрабатывать все уровни логирования
        if (!array_key_exists('levels', $attributes)) {
            $this->levels = LogLevel::getAllLevelValues();
        }
        if (!array_key_exists('is_enabled', $attributes)) {
            $this->is_enabled = 1;
        }
        if (!array_key_exists('formatter', $attributes)) {
            $this->formatter = new LineFormatter();
        }
    }
    
    public function setIsEnabled($value) {
        $this->is_enabled = $value;
    }
    public function setFilename($value) {
        $this->filename = $value;
    }
    public function setLevels($value) {
        $this->levels = $value;
    }
    public function setFormatter($value) {
        $this->formatter = $value;
    }
    
    /**
     * Нужно ли обработчику логировать данный уровень
     * @return boolean
     */
    public function isNeedLogging($level) {
        if (!$this->isListeningLevel($level)) {
            return false;
        }
        if (!$this->is_enabled) {
            return false;
        }
        
        return true;
    }
    public function isListeningLevel($level) {
        return (in_array($level, $this->levels));
    }
    

    protected function prepareContext(array $context = [])
    {
        if (empty($context)) {
            return;
        }
        
        return json_encode($context);
    }
}