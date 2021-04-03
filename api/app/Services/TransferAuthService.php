<?php

namespace App\Services;

use GuzzleHttp\Client as GuzzleClient;
use App\Repositories\User\UserRepositoryInterface;

class TransferAuthService
{
    /**
     * @var $guzzleClient
     * @var $user
     */
    private $guzzleClient;
    private $user;

    /**
     * TransferAuthService constructor
     *
     * @param GuzzleClient $guzzleClient
     * @param UserRepositoryInterface $user
     * @return void
     */
    public function __construct(GuzzleClient $guzzleClient, UserRepositoryInterface $user)
    {
        $this->guzzleClient = $guzzleClient;
        $this->user         = $user;
    }

    /**
     * Check if has authorized to make a transfer
     *
     * @return bool
     */
    public function hasTransferAuth()
    {
        $response = $this->guzzleClient->request(
            "GET",
            "https://run.mocky.io/v3/8fafdd68-a090-496f-8c9a-3442cf30dae6"
        );

        $response_status    = $response->getStatusCode();
        $response_body      = json_decode($response->getBody()->getContents());

        if (
            $response_status !== 200 ||
            !isset($response_body->message) ||
            $response_body->message !== "Autorizado"
        ) {
            return false;
        }

        return true;
    }

    /**
     * Validates if payer is a shopkeeper
     *
     * @param string $user_email_payer
     * @return bool
     */
    public function userIsShopkeeper($user_email_payer)
    {
        $user = $this->user->getUser($user_email_payer);

        if (empty($user)) {
            throw new \Exception("User not found");
        }

        return strlen($user->document) === 14;
    }
}
