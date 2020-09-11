<?php

namespace App\Action;

use Engine\Http\HtmlResponse;
use Engine\Http\View\ViewRenderer;
use Psr\Http\Message\ServerRequestInterface;

/**
 * Class IndexAction
 * @package App\Action
 */
class IndexAction
{
    /**
     * @var ViewRenderer
     */
    private $view;

    public function __construct(ViewRenderer $view)
    {
        $this->view = $view;
    }

    /**
     * @param ServerRequestInterface $request
     *
     * @return HtmlResponse
     */
    public function __invoke(ServerRequestInterface $request)
    {
        $name = $request->getQueryParams()['name'] ?: 'Guest';

        return new HtmlResponse($this->view->render('base', [
            'name' => $name,
        ]));
    }

}