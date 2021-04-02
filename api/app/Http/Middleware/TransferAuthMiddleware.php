<?php

namespace App\Http\Middleware;

use Closure;
use App\Services\TransferAuthService;
use Illuminate\Http\JsonResponse;

class TransferAuthMiddleware
{
    /**
     * @var $transferAuthService
     */
    private $transferAuthService;

    /**
     * TransferAuthMiddleware constructor
     *
     * @param TransferAuthService $transferAuthService
     */
    public function __construct(TransferAuthService $transferAuthService)
    {
        $this->transferAuthService = $transferAuthService;
    }

    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
        try {
            if (!$this->transferAuthService->hasTransferAuth()) {
                throw new \Exception("Error Processing Authorization");
            }

            return $next($request);

        } catch (\Exception $ex) {
            // transfer log $ex->getMessage()
            return new JsonResponse(
                [
                    'status'    => false,
                    'data'      => [],
                    'message'   => "Unauthorized to transfer"
                ],
                401
            );
        }
    }
}
