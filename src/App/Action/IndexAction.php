<?php

namespace App\Action;

use Engine\Http\HtmlResponse;

/**
 * Class IndexAction
 * @package App\Action
 */
class IndexAction
{
    public function __invoke()
    {
        return new HtmlResponse('hello');
    }

}