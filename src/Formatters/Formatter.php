<?php
namespace Logger\Formatters;

/**
 * Class Formatter
 */
abstract class Formatter
{
    /**
     * Формат даты по умолчанию
     */
    const DEFAULT_DATE_FORMAT = "Y-m-d H:i:s";
    
    protected $dateFormat;

    public function __construct($dateFormat = null)
    {
        $this->dateFormat = is_null($dateFormat) ? static::DEFAULT_DATE_FORMAT : $dateFormat;
    }
    
    abstract public function format($args);
}