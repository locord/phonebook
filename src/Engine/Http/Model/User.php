<?php

namespace Engine\Http\Model;

use DateTime;
use DomainException;

/**
 * Class User
 * @package Engine\Http\Model
 */
class User
{
    const STATUS_ACTIVE = 'active';
    const STATUS_WAIT = 'wait';
    /**
     * @var integer
     */
    public $id;
    /**
     * @var DateTime
     */
    public $date;
    /**
     * @var string
     */
    public $email;
    /**
     * @var string
     */
    public $content;
    /**
     * @var string
     */
    public $status;
    /**
     * @var string
     */
    private $passwordHash;
    /**
     * @var string
     */
    public $photo_path;

    /**
     * @param DateTime $date
     * @param string   $email
     * @param string   $hash
     *
     * @return User
     */
    public static function create(
        DateTime $date,
        $email,
        $hash
    ) {
        $user               = new User();
        $user->date         = $date->format('Y-m-d H:i:s');
        $user->email        = $email;
        $user->passwordHash = $hash;
        $user->status       = self::STATUS_WAIT;
        return $user;
    }

    /**
     * @param string $avatar
     *
     * @return User
     */
    public function updateAvatar($avatar)
    {
        $this->photo_path = $avatar;
        return $this;
    }

    /**
     * @return string
     */
    public function getPasswordHash()
    {
        return $this->passwordHash;
    }

    /**
     * @param string $hash
     */
    public function setPasswordHas($hash)
    {
        $this->passwordHash = $hash;
    }

    public function isWait()
    {
        return $this->status === self::STATUS_WAIT;
    }

    public function isActive()
    {
        return $this->status === self::STATUS_ACTIVE;
    }
}