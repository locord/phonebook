<?php

namespace Engine\Http\Middleware;

use Engine\Http\BCryptPasswordHasher;
use Engine\Http\Repositories\UserRepositoryInterface;
use Psr\Http\Message\ServerRequestInterface;

/**
 * Class AuthMiddleware
 * @package Engine\Http\Middleware
 */
class AuthMiddleware
{
    /**
     * @var UserRepositoryInterface
     */
    private $users;
    /**
     * @var BCryptPasswordHasher
     */
    private $hasher;

    /**
     * AuthMiddleware constructor.
     *
     * @param UserRepositoryInterface $users
     * @param BCryptPasswordHasher    $hasher
     */
    public function __construct(UserRepositoryInterface $users, BCryptPasswordHasher $hasher)
    {
        $this->users  = $users;
        $this->hasher = $hasher;
    }

    /**
     * @param ServerRequestInterface $request
     * @param callable               $next
     */
    public function __invoke(ServerRequestInterface $request, callable $next)
    {
    }
}