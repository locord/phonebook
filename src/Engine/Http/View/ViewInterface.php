<?php

namespace Engine\Http\View;


/**
 * Class TemplateRenderer
 * @package Engine\Http\Template
 */
interface ViewInterface
{
    /**
     * @param       $view
     * @param array $params
     *
     * @return false|string
     */
    public function render($view, array $params = []);
}