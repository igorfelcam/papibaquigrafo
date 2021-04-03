<?php

namespace App\Repositories\Wallet;

use App\Models\Wallet;

class WalletRepository implements WalletRepositoryInterface
{
    /**
     * @var $wallet
     */
    private $wallet;

    /**
     * TransferAuthService constructor
     *
     * @param Wallet $wallet
     * @return void
     */
    public function __construct(Wallet $wallet)
    {
        $this->wallet = $wallet;
    }

    /**
     * Get user data
     *
     * @param string $user_email
     * @return Wallet
     */
    public function getProbableWalletsToUser($user_timestamp_created)
    {
        $data = $this->wallet
                    ->where(
                        'created_at', '>=', date('Y-m-d H:i:s', $user_timestamp_created)
                    )
                    ->orderBy('created_at')
                    ->get();

        if (empty($data)) {
            throw new \Exception("Wallet not found");
        }

        return $data;
    }
}
