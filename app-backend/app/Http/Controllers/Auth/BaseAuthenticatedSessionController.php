<?php

namespace App\Http\Controllers\Auth;

use App\Common\CommonFunction;
use App\Http\Controllers\Controller;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class BaseAuthenticatedSessionController extends Controller
{

    /**
     * @param $authService
     */
    public function __construct(protected $authService)
    {
    }

    /**
     * Destroy an authenticated session.
     *
     * @return JsonResponse
     */
    public function destroy(): JsonResponse
    {
        $result = $this->authService->logout();

        return CommonFunction::responseMessageJsonData($result);
    }
}
