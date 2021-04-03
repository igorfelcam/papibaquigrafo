<?php

namespace App\Repositories\Wallet;

interface WalletRepositoryInterface
{
    public function getProbableWalletsToUser($user_timestamp_created);
}
