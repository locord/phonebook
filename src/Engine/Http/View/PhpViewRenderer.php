<?php

namespace Engine\Http\View;

/**
 * Class TemplateRenderer
 * @package Engine\Http\Template
 */
class PhpViewRenderer implements ViewInterface
{
    private $path;
    /**
     * @var |null
     */
    private $extend;
    /**
     * @var array
     */
    private $params = [];

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
        $this->extend = null;
        require $templateFile;
        $content = ob_get_clean();

        if (!$this->extend) {
            return $content;
        }

        return $this->render($this->extend, [
            'content' => $content,
        ]);
    }
}