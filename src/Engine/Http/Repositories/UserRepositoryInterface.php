<?php

namespace Engine\Http\Repositories;


use Engine\Http\Model\User;
use Exception;

/**
 * Class UserRepository
 * @package Engine\Http\Repositories
 */
interface UserRepositoryInterface
{
    /**
     * @return int
     */
    public function countAll();

    /**
     * @param int $offset
     * @param int $limit
     *
     * @return array
     */
    public function getAll($offset, $limit);

    /**
     * @param $id
     *
     * @return User|null
     */
    public function find($id);

    /**
     * @param $email
     *
     * @return bool
     */
    public function hasByEmail($email);

    /**
     * @param $email
     *
     * @return User|null
     */
    public function findByEmail($email);

    /**
     * @param User $user
     *
     * @return User|null
     * @throws Exception
     */
    public function store(User $user);
}