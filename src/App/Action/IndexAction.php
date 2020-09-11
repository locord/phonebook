<?php

namespace App\Action;

use Engine\Http\HtmlResponse;
use Engine\Http\View\PhpViewRenderer;
use Engine\Http\View\ViewInterface;
use Psr\Http\Message\ServerRequestInterface;

/**
 * Class IndexAction
 * @package App\Action
 */
class IndexAction
{
    /**
     * @var ViewInterface
     */
    private $view;

    public function __construct(ViewInterface $view)
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

        return new HtmlResponse($this->view->render('app/index', [
            'name' => $name,
        ]));
    }

}