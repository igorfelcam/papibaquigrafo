<?php

namespace App\Repositories\User;

use App\Models\User;

class UserRepository implements UserRepositoryInterface
{
    /**
     * @var $user
     */
    private $user;

    /**
     * TransferAuthService constructor
     *
     * @param User $user
     * @return void
     */
    public function __construct(User $user)
    {
        $this->user = $user;
    }

    /**
     * Get user data
     *
     * @param string $user_email
     * @return User
     */
    public function getUser($user_email)
    {
        $data = $this->user
                    ->where('email', $user_email)
                    ->first();

        if (empty($data)) {
            throw new \Exception("User not found");
        }

        return $data;
    }
}
