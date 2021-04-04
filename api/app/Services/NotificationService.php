<?php

namespace App\Services;

use GuzzleHttp\Client as GuzzleClient;

class NotificationService
{
    /**
     * @var $guzzleClient
     */
    private $guzzleClient;

    /**
     * NotificationService constructor
     *
     * @param GuzzleClient $guzzleClient
     * @return void
     */
    public function __construct(GuzzleClient $guzzleClient)
    {
        $this->guzzleClient = $guzzleClient;
    }

    /**
     * Notify when the user receives a transfer
     *
     * @return bool
     */
    public function notifyTransferReceived($user_email)
    {
        $response = $this->guzzleClient->request(
            "GET",
            "https://run.mocky.io/v3/b19f7b9f-9cbf-4fc6-ad22-dc30601aec04"
        );

        $response_status    = $response->getStatusCode();
        $response_body      = json_decode($response->getBody()->getContents());

var_dump(
    $user_email,
    $response_status,
    $response_body
);die;

        if (
            $response_status !== 200 ||
            !isset($response_body->message) ||
            $response_body->message !== "Enviado"
        ) {
            return false;
        }

        return true;
    }
}
