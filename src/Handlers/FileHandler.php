<?php
namespace Logger\Handlers;

use Logger\LogLevel;
use Logger\Exceptions\Exception;

/**
 * Class FileHandler
 */
class FileHandler extends Handler
{
    /**
     * @var string путь к файлу, в который записывает обработчик
     */
    protected $filename;

    public function __construct(array $attributes = [])
    {
        if (!array_key_exists('filename', $attributes)) {
            throw new Exception('Parameter filename in attributes is required');
        }
        parent::__construct($attributes);
        
        if (!file_exists($this->filename))
        {
            touch($this->filename);
        }
    }
    
    /**
     * @inheritdoc
     */
    public function log($level, string|\Stringable $message, array $context = []) : void
    {
        if (!$this->isNeedLogging($level)) {
            return;
        }
        $message = $this->formatter->format([
            'date'         => new \DateTime(),
            'level'        => mb_strtoupper($level),
            'level_code'   => LogLevel::getLevelCode($level),
            'message'      => $message,
            'context'      => $this->prepareContext($context),
        ]);

        $message = $message . PHP_EOL;
        file_put_contents($this->filename, $message, FILE_APPEND);
    }
}