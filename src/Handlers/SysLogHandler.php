<?php
namespace Logger\Handlers;

use Psr\Log\AbstractLogger;
use Psr\Log\LoggerInterface;
use Logger\LogLevel;
use Logger\Formatters\LineFormatter;
use Logger\Exceptions\Exception;

/**
 * Class SysLogHandler
 */
class SysLogHandler extends Handler
{
    /**
     * @var string шаблон сообщения
     */
    protected $template = "%message% %context%";

    public function __construct(array $attributes = [])
    {
        parent::__construct($attributes);
        if (!array_key_exists('formatter', $attributes)) {
            $this->formatter = new LineFormatter($this->template);
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
        $level = $this->resolveLevel($level);
        $message = $this->formatter->format([
            'message'      => $message,
            'context'      => $this->prepareContext($context),
        ]);
        syslog($level, $message);
    }
    
    private function resolveLevel($level)
    {
    $map = [
            LogLevel::LEVEL_EMERGENCY => LOG_EMERG,
            LogLevel::LEVEL_ALERT     => LOG_ALERT,
            LogLevel::LEVEL_CRITICAL  => LOG_CRIT,
            LogLevel::LEVEL_ERROR     => LOG_ERR,
            LogLevel::LEVEL_WARNING   => LOG_WARNING,
            LogLevel::LEVEL_NOTICE    => LOG_NOTICE,
            LogLevel::LEVEL_INFO      => LOG_INFO,
            LogLevel::LEVEL_DEBUG     => LOG_DEBUG,
            ];
        
        if (!array_key_exists($level, $map)) {
            throw new Exception('Incorrect level');
        }
        return $map[$level];
    }
}