<?php
namespace Logger\Handlers;

/**
 * Обработчик, который ничего не делает
 */
class FakeHandler extends Handler
{
    public $filename;

    public function __construct(array $attributes = [])
    {
    }
    
    /**
     * @inheritdoc
     */
    public function log($level, string|\Stringable $message, array $context = []) : void
    {
        return;
    }
}