<?php

namespace App\Common;

use Carbon\Carbon;
use Exception;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Password;
use Illuminate\Support\Str;
use Illuminate\Support\Arr;
use function __;
use function trans;

class CommonFunction
{
    /**
     * Prepare data from ajax request
     *
     * @param array $requestData
     * @return array
     */
    public static function prepareAjaxRequest(array $requestData): array
    {
        $limit = $requestData['length'] ?? Constant::DEFAULT_LIMIT;
        $draw = $requestData['draw'] ?? Constant::DEFAULT_DRAW;
        $offset = $requestData['start'] ?? Constant::DEFAULT_OFFSET;
        $search = $requestData['search']['value'] ?? '';
        $column = $requestData['order'][0]['column'] ?? Constant::DEFAULT_ORDER_COLUMN;
        $order = $requestData['columns'][$column]['data'] ?? Constant::DEFAULT_COLUMN;
        $sort = $requestData['order'][0]['dir'] ?? Constant::DEFAULT_DIRECTION;

        return [
            'search' => $search,
            'limit'  => $limit,
            'draw'   => $draw,
            'offset' => $offset,
            'order'  => $order,
            'sort'   => $sort,
        ];
    }

    /**
     * Response message json data
     *
     * @param $data
     * @return JsonResponse
     */
    public static function responseMessageJsonData($data): JsonResponse
    {
        return response()->json(['errors' => $data['errors'], 'message' => $data['message']], $data['status']);
    }

    /**
     * Response json data
     *
     * @param $data
     * @return JsonResponse
     */
    public static function responseJsonData($data): JsonResponse
    {
        if ($data['errors'] ?? false) {
            return self::responseMessageJsonData($data);
        }

        return self::responseBaseJsonData($data['data'], $data['status']);
    }

    /**
     * Response base json data
     *
     * @param array $data
     * @param int $status
     * @return JsonResponse
     */
    public static function responseBaseJsonData(array $data, int $status = 200): JsonResponse
    {
        return response()->json(['data' => $data], $status);
    }

    /**
     * Generate token data
     *
     * @param string $token
     * @return array
     */
    public static function generateTokenData(string $token): array
    {
        return [
            'accessToken' => $token,
            'tokenType'   => 'bearer',
            'expiresIn'   => auth(getApiGuard())->factory()->getTTL() * Constant::SIXTY_SECONDS,
        ];
    }

    /**
     * Response success message json data
     *
     * @param string $message
     * @return JsonResponse
     */
    public static function responseSuccessMessageJsonData(string $message): JsonResponse
    {
        return self::responseMessageJsonData(generateSuccessMessage($message));
    }

    /**
     * Response error message json data
     *
     * @param string $message
     * @return JsonResponse
     */
    public static function responseErrorMessageJsonData(string $message): JsonResponse
    {
        return self::responseMessageJsonData(generateErrorMessage($message));
    }

    /**
     * Handle send reset password link
     *
     * @param string $email
     * @param bool $isUseCallback
     * @return array
     */
    public static function handleSendResetLink(string $email, bool $isUseCallback = false): array
    {
        if ($isUseCallback) {
            $status = Password::sendResetLink(['email' => $email], function ($admin, $token) {
                // TODO: handle email template for register a new admin via reuse reset password template
                $admin->sendPasswordResetNotification($token);
            });
        } else {
            $status = Password::sendResetLink(['email' => $email]);
        }

        if ($status == Password::RESET_LINK_SENT) {
            return generateSuccessMessage(__($status));
        }

        return generateErrorMessage(trans($status));
    }

    /**
     * Parse date from format
     *
     * @param string $date
     * @param string $format
     * @return Carbon|false
     */
    public static function parseDate(string $date, string $format)
    {
        try {
            return Carbon::createFromFormat($format, $date);
        } catch (Exception $e) {
            logger()->error('arse date from format errors: ', [$e->getFile(), $e->getLine(), $e->getMessage()]);
        }
        return false;
    }

    /** Convert array key camelCase to snake_case
     *
     * @param array $data
     * @return array
     */
    public static function convertArrayKeyToSnakeCase(array $data): array
    {
        return collect($data)->mapWithKeys(function ($item, $key) {
            return [Str::snake($key) => $item];
        })->all();
    }

    /**
     * Get csv file name
     *
     * @param string $fileName
     * @return string
     */
    public static function getCsvFileName(string $fileName)
    {
        return urlencode($fileName . '_' . date('Ymd-Hi') . '.csv');
    }

    /**
     * Get usage time
     *
     * @param string $from
     * @param string $to
     * @return int
     */
    public static function getUsageTime(string $from, string $to)
    {
        if (!empty($from) && !empty($to)) {
            $startTime = Carbon::parse($from);
            $endTime = Carbon::parse($to);

            $totalDuration = abs($startTime->getTimestamp() - $endTime->getTimestamp()) / 60;
            return $totalDuration / 60;
        }
        return 0;
    }

    /**
     * Get SCode by code
     *
     * @param array $codeList
     * @param string $code
     * @return void
     */
    public static function getSCodeByCode(array $codeList, string $code)
    {
        if (empty($codeList)) {
            return null;
        }

        $codes = array_column($codeList, 'code');
        $index = array_search($code, $codes);

        if ($index !== false) {
            return $codeList[$index];
        }
        return null;
    }

    /**
     * Get file path from storage
     *
     * @param string $path
     * @return string
     */
    public static function getFilePath(string $path): string
    {
        return asset(Storage::url($path));
    }

    /**
     * Generate cache key
     *
     * @param string $key
     * @param array $data
     * @return string
     */
    public static function generateCacheKey(string $key, array $data): string
    {
        return $key . '_' . md5(Arr::query(Arr::sortRecursive($data)));
    }

    /**
     * Get default image path
     *
     * @return string
     */
    public static function defaultImagePath(): string
    {
        return asset(Storage::url(Constant::DEFAULT_IMAGE_PATH));
    }

    /**
     * Check permission to access screen
     *
     * @param array $roles
     * @param       $companyId
     * @return bool
     */
    public static function checkPermission(array $roles, $companyId = null): bool
    {
        $user = auth(getApiGuard())->user();
        if (!in_array($user?->role_id, $roles, true)) {
            return false;
        }

        if ($user?->role_id === Constant::COMPANY_ADMIN_ROLE_ID &&
                $companyId !== null && $user->company_id !== (int) $companyId) {
            return false;
        }

        return true;
    }

}
