<?php

namespace App\Utils;

use App\Utils\Security\SecurityService;

class View
{
    /**
     * @var string
     */
    protected $dirTemplate;

    protected $isAdmin;

    /**
     * View constructor.
     * @param string $dirTemplate
     */
    public function __construct(SecurityService $securityService, $dirTemplate = '')
    {
        $this->dirTemplate = rtrim($dirTemplate, DIRECTORY_SEPARATOR) . DIRECTORY_SEPARATOR;
        $this->isAdmin = $securityService->isSignedIn();
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
        $isAdmin = $this->isAdmin;
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
