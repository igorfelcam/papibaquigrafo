<?php

namespace App\Services;

use GuzzleHttp\Client as GuzzleClient;

class TransferAuthService
{
    /**
     * @var $guzzleClient
     */
    private $guzzleClient;

    /**
     * TransferAuthService constructor
     *
     * @param GuzzleClient $guzzleClient
     * @return void
     */
    public function __construct(GuzzleClient $guzzleClient)
    {
        $this->guzzleClient = $guzzleClient;
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
}
