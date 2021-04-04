<?php

namespace App\Jobs;

use App\Services\NotificationService;

class NotificationJob extends Job
{
    /**
     * @var string $user_email
     */
    private $user_email;

    /**
     * Create a new job instance.
     *
     * @param string $user_email
     * @return void
     */
    public function __construct($user_email)
    {
        $this->user_email = $user_email;
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle(NotificationService $notificationService)
    {
        $notificationService->notifyTransferReceived($this->user_email);
    }
}
