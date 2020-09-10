<?php

namespace Engine\Http;

/**
 * Class BCryptPasswordHasher
 * @package Engine\Http
 */
class BCryptPasswordHasher
{
    private $cost;

    public function __construct($cost = 12)
    {
        $this->cost = $cost;
    }

    public function hash($password)
    {
        $hash = password_hash($password, PASSWORD_BCRYPT, ['cost' => $this->cost]);
        if ($hash === false) {
            throw new \RuntimeException('Unable to generate hash.');
        }
        return $hash;
    }

    public function validate($password, $hash)
    {
        return password_verify($password, $hash);
    }
}
