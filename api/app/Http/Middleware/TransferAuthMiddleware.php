<?php

namespace App\Http\Middleware;

use Closure;

use Illuminate\Http\JsonResponse;

use App\Repositories\User\UserRepositoryInterface;
use App\Services\TransferAuthService;

class TransferAuthMiddleware
{
    /**
     * @var $user
     * @var $transferAuthService
     */
    private $user;
    private $transferAuthService;

    /**
     * TransferAuthMiddleware constructor
     *
     * @param UserRepositoryInterface $user
     * @param TransferAuthService $transferAuthService
     */
    public function __construct(UserRepositoryInterface $user, TransferAuthService $transferAuthService)
    {
        $this->user                 = $user;
        $this->transferAuthService  = $transferAuthService;
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
            if (empty($this->user->getUser($request->user_email_payer))) {
                throw new \Exception("Payer not found");
            }

            if (empty($this->user->getUser($request->user_email_payee))) {
                throw new \Exception("Payee not found");
            }

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
