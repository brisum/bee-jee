<?php

namespace App\Utils;

class View
{
    /**
     * @var string
     */
    protected $dirTemplate;

    /**
     * View constructor.
     * @param string $dirTemplate
     */
    public function __construct($dirTemplate = '')
    {
        $this->dirTemplate = rtrim($dirTemplate, DIRECTORY_SEPARATOR) . DIRECTORY_SEPARATOR;
    }

    /**
     * @param string $template
     * @param array $vars
     * @return void
     */
    public function render($template, array $vars = [])
    {
        /* Use unique name of template path for avoiding overwrite $template variable by extract $vars */
        $appViewTemplatePath = $this->dirTemplate . $template;
        extract($vars);
        require $appViewTemplatePath;
    }

    /**
     * @param string $template
     * @param array $vars
     * @return string
     */

    public function content($template, array $vars = [])
    {
        ob_start();
        $this->render($template, $vars);
        return ob_get_clean();
    }
}
