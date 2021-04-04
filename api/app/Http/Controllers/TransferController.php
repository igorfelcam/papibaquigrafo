<?php

namespace App\Http\Controllers;

use Laravel\Lumen\Routing\Controller;

use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

use App\Services\WalletService;
use App\Services\TransferAuthService;
use App\Rules\EmailRule;
use App\Rules\ValueRule;
use App\Events\TransferLogEvent;
use App\Jobs\NotificationJob;

class TransferController extends Controller
{
    /**
     * @var $request
     * @var $wallet
     * @var $db
     * @var $transferAuthService
     */
    private $request;
    private $walletService;
    private $db;
    private $transferAuthService;

    /**
     * TransferController constructor
     *
     * @param Request $request
     * @param WalletService $walletService
     * @param DB $db
     * @param TransferAuthService $transferAuthService
     * @return void
     */
    public function __construct(Request $request, WalletService $walletService, DB $db, TransferAuthService $transferAuthService)
    {
        $this->request              = $request;
        $this->walletService        = $walletService;
        $this->db                   = $db;
        $this->transferAuthService  = $transferAuthService;
    }

    /**
     * Request values user transfers
     *
     * @return \Illuminate\Http\Response
     */
    public function valuesTransfers()
    {
        try {
            $transferLogEvent   = new TransferLogEvent();
            $data               = $this->validateRequestData();
            $payer_wallet       = $this->walletService->getUserWallet($data['user_email_payer']);

            if ($this->transferAuthService->userIsShopkeeper($data['user_email_payer'])) {
                throw new \Exception("Shopkeeper cannot transfer");
            }

            if ($data['value'] > $payer_wallet->value) {
                throw new \Exception("Insufficient balance to make the transfer");
            }

            $payee_wallet = $this->walletService->getUserWallet($data['user_email_payee']);

            $this->db::transaction(function () use ($payer_wallet, $payee_wallet, $data) {
                $payer_wallet->value = $payer_wallet->value - $data['value'];
                $payer_wallet->save();

                $payee_wallet->value = $payee_wallet->value + $data['value'];
                $payee_wallet->save();
            });

            $transferLogEvent->payer_email  = $data['user_email_payer'];
            $transferLogEvent->payee_email  = $data['user_email_payee'];
            $transferLogEvent->value        = $data['value'];
            $transferLogEvent->message      = "Transfer complete";
            $transferLogEvent->status       = "success";

            event($transferLogEvent);

            dispatch(new NotificationJob($data['user_email_payee']));

            return new JsonResponse(
                [
                    'status'    => true,
                    'data'      => "",
                    'message'   => "Successful transfer from " .$data['user_email_payer']. " to " .$data['user_email_payee']
                ],
                200
            );
        }
        catch (\Exception $ex) {

            $transferLogEvent->payer_email  = $data['user_email_payer'];
            $transferLogEvent->payee_email  = $data['user_email_payee'];
            $transferLogEvent->value        = $data['value'];
            $transferLogEvent->message      = $ex->getMessage();
            $transferLogEvent->status       = "error";

            event($transferLogEvent);

            return new JsonResponse(
                [
                    'status'    => false,
                    'data'      => [],
                    'message'   => "An error occurred while performing the transfer"
                ],
                400
            );
        }
    }

    /**
     * Validates the request data
     *
     * @return array $data
     */
    private function validateRequestData()
    {
        $data = $this->validate(
            $this->request,
            [
                'user_email_payer'  => ['required', 'string', new EmailRule],
                'user_email_payee'  => ['required', 'string', new EmailRule],
                'value'             => ['required', 'string', new ValueRule],
            ]
        );

        $data['value'] = number_format(
            (float) str_replace(",", ".", $data['value']),
            4,
            '.',
            ''
        );

        return $data;
    }
}
