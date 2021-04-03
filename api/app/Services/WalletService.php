<?php

namespace App\Services;

use App\Repositories\User\UserRepositoryInterface;
use App\Repositories\Wallet\WalletRepositoryInterface;

class WalletService
{
    /**
     * @var $user
     * @var $wallet
     */
    private $user;
    private $wallet;

    /**
     * TransferAuthService constructor
     *
     * @param UserRepositoryInterface $user
     * @param WalletRepositoryInterface $wallet
     * @return void
     */
    public function __construct(WalletRepositoryInterface $wallet, UserRepositoryInterface $user)
    {
        $this->user     = $user;
        $this->wallet   = $wallet;
    }

    /**
     * Get payer user wallet
     *
     * @param string $user_email_payer
     * @return \Wallet
     */
    public function getUserWallet($user_email_payer)
    {
        $user               = $this->user->getUser($user_email_payer);
        $probable_wallets   = $this->wallet->getProbableWalletsToUser($user->created_at->timestamp);
        $payer_wallet       = null;

        foreach ($probable_wallets as $wallet) {
            if (password_verify("$user->email:$user->document", $wallet->owner)) {
                $payer_wallet = $wallet;
                break;
            }
        }

        if ($payer_wallet === null) {
            throw new \Exception("Wallet payer not found");
        }

        return $payer_wallet;
    }
}
