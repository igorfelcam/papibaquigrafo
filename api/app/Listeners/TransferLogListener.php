<?php

namespace App\Listeners;

use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;
use App\Events\TransferLogEvent;
use App\Repositories\Log\Transfer\TransferLogRepository;

class TransferLogListener
{
    /**
     * @var $transferLogRepository
     */
    private $transferLogRepository
    ;
    /**
     * Create the event listener.
     *
     * @return void
     */
    public function __construct(TransferLogRepository $transferLogRepository)
    {
        $this->transferLogRepository = $transferLogRepository;
    }

    /**
     * Handle the event.
     *
     * @param TransferLogEvent $event
     * @return void
     */
    public function handle(TransferLogEvent $event)
    {
        $data = [];

        foreach ($event as $key => $value) {
            $data[$key] = $value;
        }

        $this->transferLogRepository->save($data);
    }
}
