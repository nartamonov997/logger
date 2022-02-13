<?php
namespace Logger\Formatters;

/**
 * Class LineFormatter
 */
class LineFormatter extends Formatter
{
    /**
     * Шаблон сообщения по умолчанию
     */
    const DEFAULT_TEMPLATE = "%date%  [%level_code%]  [%level%]  %message%";
    
    /**
     * @var string шаблон сообщения
     */
    protected $template;

    public function __construct($template = null, $dateFormat = null)
    {
        $this->template = is_null($template) ? static::DEFAULT_TEMPLATE : $template;
        parent::__construct($dateFormat);
    }
    
    /**
     * Получить сообщение на основе шаблона и переданных переменных
     *
     * @param  Array $vars
     * @return string
     */
    public function format($vars) {
        $output = $this->template;
        foreach ($vars as $var => $val) {
            if (strpos($output, '%' . $var . '%') === false) {
                continue;
            }
            if ($var == 'date') {
                $val = $vars[$var]->format('Y-m-d H:i:s');
            }
            $output = str_replace('%' . $var . '%', $val, $output);
            
        }
        
        return $output;
    }
}