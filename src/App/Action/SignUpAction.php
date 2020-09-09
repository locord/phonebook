<?php

namespace App\Action;

use Engine\Http\JsonResponse;
use Psr\Http\Message\ServerRequestInterface;

/**
 * Class SignUpAction
 * @package App\Action
 */
class SignUpAction
{
    public function __invoke(ServerRequestInterface $request)
    {
        return new JsonResponse([
            'email' => 'email',
            'id'    => '1',
        ], 201);
    }
}