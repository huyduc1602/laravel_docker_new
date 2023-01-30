<?php

namespace App\Http\Middleware;

use Closure;
use Exception;
use Illuminate\Http\Request;
use App\Common\CommonFunction;
use App\Common\Constant;
use Illuminate\Http\JsonResponse;

class UserAuthentication
{
    /**
     * Handle an incoming request.
     *
     * @param Request $request
     * @param Closure $next
     * @return \Illuminate\Http\JsonResponse|mixed
     */
    public function handle(Request $request, Closure $next)
    {
        $user = auth(getApiGuard())->user();
        if (empty($user)) {
            return $this->handleResponse(__('messages.AMSG.00043'), Constant::HTTP_STATUS_UNAUTHORIZED, false);
        }

        if (!$user->can_access_user_side || !$user->status) {
            return $this->handleResponse(__('messages.AMSG.00040'), Constant::HTTP_STATUS_FORBIDDEN);
        }

        try {
            $loggedRoleId = auth(getApiGuard())->payload()->get('loggedRoleId') ?? '';
            if ($loggedRoleId !== $user?->role_id) {
                return $this->handleResponse(__('messages.AMSG.00040'), Constant::HTTP_STATUS_FORBIDDEN);
            }
        } catch (Exception $e) {
            return $this->handleResponse(__('messages.AMSG.00040'), Constant::HTTP_STATUS_FORBIDDEN);
        }

        return $next($request);
    }

    /**
     * Handle response
     *
     * @param string $message
     * @param int $statusCode
     * @param bool $isLogout
     * @return JsonResponse
     */
    private function handleResponse(string $message, int $statusCode, bool $isLogout = true): JsonResponse
    {
        if ($isLogout) {
            auth(getApiGuard())->logout();
        }

        return CommonFunction::responseMessageJsonData(generateErrorMessage($message, $statusCode));
    }
}
