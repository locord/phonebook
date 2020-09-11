<?php

namespace Engine\Http\View;

/**
 * Class TemplateRenderer
 * @package Engine\Http\Template
 */
class ViewRenderer
{
    private $path;

    public function __construct($path)
    {
        $this->path = $path;
    }

    /**
     * @param       $view
     * @param array $params
     *
     * @return false|string
     */
    public function render($view, array $params = [])
    {
        $templateFile = $this->path . '/' . $view . '.php';

        ob_start();
        extract($params, EXTR_OVERWRITE);
        require $templateFile;
        return ob_get_clean();
    }
}