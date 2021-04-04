<?php

namespace App\Repositories\Log\Transfer;

use App\Repositories\Log\LogRepositoryInterface;
use App\Models\TransferLog;

class TransferLogRepository implements LogRepositoryInterface
{
    /**
     * @var $transferLog
     */
    private $transferLog;

    /**
     * TransferLogRepository constructor
     *
     * @param TransferLog $transferLog
     * @return void
     */
    public function __construct(TransferLog $transferLog)
    {
        $this->transferLog = $transferLog;
    }

    /**
     * Register data to Transfer log
     *
     * @param array $data['payer_email', 'payee_email', 'message', 'value']
     * @return bool
     */
    public function save($data)
    {
        if (count($data) === 0) {
            return false;
        }

        foreach ($data as $key => $value) {
            $this->transferLog->$key = $value;
        }
        $this->transferLog->save();

        return true;
    }
}
