<?php

namespace Engine\Http\Repositories;

use Engine\Http\Model\User;
use Exception;
use PDO;

/**
 * Class UserRepository
 * @package Engine\Http\Repositories
 */
class UserRepository implements UserRepositoryInterface
{
    /**
     * @var PDO
     */
    private $pdo;

    public function __construct(PDO $pdo)
    {
        $this->pdo = $pdo;
    }

    /**
     * @return int
     */
    public function countAll()
    {
        $stmt = $this->pdo->query('SELECT COUNT(*) FROM users');
        return $stmt->fetchColumn();
    }

    /**
     * @param int $offset
     * @param int $limit
     *
     * @return array
     */
    public function getAll($offset, $limit)
    {
        $stmt = $this->pdo->prepare('SELECT * FROM users ORDER BY date DESC LIMIT ? OFFSET ?');
        $stmt->execute([$limit, $offset]);
        return array_map([$this, 'hydrateUser'], $stmt->fetchAll());
    }

    /**
     * @param $id
     *
     * @return User|null
     */
    public function find($id)
    {
        $stmt = $this->pdo->prepare('SELECT * FROM users WHERE id = ?');
        $stmt->execute([$id]);
        return ($row = $stmt->fetch()) ? $this->hydrateUser($row) : null;
    }

    /**
     * @param $email
     *
     * @return bool
     */
    public function hasByEmail($email)
    {
        $stmt = $this->pdo->prepare('SELECT * FROM users WHERE email = ?');
        $stmt->execute([$email]);
        return ($row = $stmt->fetch()) ? true : false;
    }

    /**
     * @param $email
     *
     * @return User|null
     */
    public function findByEmail($email)
    {
        $stmt = $this->pdo->prepare('SELECT * FROM users WHERE email = ?');
        $stmt->execute([$email]);
        return ($row = $stmt->fetch()) ? $this->hydrateUser($row) : null;
    }

    /**
     * @param User $user
     *
     * @return User|null
     * @throws Exception
     */
    public function store(User $user)
    {
        if (!$user->id) {
            $sql = "INSERT INTO users (email, status, passwordHash, date) VALUES (:email, :status, :passwordHash, :date)";
        } else {
            $sql = "UPDATE users SET email=:email, status=:status, photo_path=:photo_path, date=:date WHERE id=:id";
        }
        $stmt = $this->pdo->prepare($sql);
        $stmt->execute(array_filter([
            'email'      => $user->email,
            'status'     => $user->status,
            'photo_path' => $user->photo_path,
            'date'       => $user->date,
            'id'         => $user->id ?: false,
        ]));

        return $this->find($this->pdo->lastInsertId());
    }

    /**
     * @param array $row
     *
     * @return User
     */
    private function hydrateUser(array $row)
    {
        $user = new User();

        $user->id         = (int)$row['id'];
        $user->email      = $row['email'];
        $user->status     = $row['status'];
        $user->date       = $row['date'];
        $user->photo_path = $row['photo_path'];

        $user->setPasswordHas($row['passwordHash']);

        return $user;
    }
}