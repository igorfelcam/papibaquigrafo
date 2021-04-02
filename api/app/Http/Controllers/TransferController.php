<?php

namespace App\Http\Controllers;

use Laravel\Lumen\Routing\Controller;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class TransferController extends Controller
{
    /**
     * @var $request
     */
    private $request;

    /**
     * TransferController constructor
     *
     * @return void
     */
    public function __construct(Request $request)
    {
        $this->request = $request;
    }

    /**
      * Request values user transfers
      *
      * @return \Illuminate\Http\Response
      */
     public function valuesTransfers()
    {
        try {
            $data = $this->request->only([
                'user_email_payer',
                'user_email_payee',
                'value'
            ]);

            return new JsonResponse(
                [
                    'status'    => true,
                    'data'      => $data,
                    'message'   => ""
                ],
                200
            );
        } catch (\Exception $ex) {
            // transfer log $ex->getMessage()
            return new JsonResponse(
                [
                    'status'    => false,
                    'data'      => [],
                    'message'   => ""
                ],
                400
            );
        }
    }

    /**
     * Request detail user transfers
     *
     * @return \Illuminate\Http\Response
    */
    public function transfersDetails()
    {
        try {
            $data = $this->request->only([
                'user_email'
            ]);

            return new JsonResponse(
                [
                    'status'    => true,
                    'data'      => $data,
                    'message'   => ""
                ],
                200
            );
        } catch (\Exception $ex) {
            // transfer log $ex->getMessage()
            return new JsonResponse(
                [
                    'status'    => false,
                    'data'      => [],
                    'message'   => ""
                ],
                400
            );
        }
    }
}
