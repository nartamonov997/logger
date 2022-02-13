<?php
namespace Logger;

use Stringable;
use Psr\Log\AbstractLogger;
use Psr\Log\LoggerInterface;
use Logger\Handlers\Handler;
/**
 * Class Logger
 */
class Logger extends AbstractLogger implements LoggerInterface
{
    /**
     * @var Array|Handler[] Список обработчиков
     */
    private $handlers = [];


    /**
     * @inheritdoc
     */
    public function log($level, string|\Stringable $message, array $context = []) : void
    {
        foreach ($this->handlers as $handler)
        {
            $handler->log($level, $message, $context);
        }
    }
    
    public function addHandler($handler)
    {
        if (!$handler instanceof Handler)
        {
            return false;
        }
        
        $this->handlers[] = $handler;
    }
}