<?php

use Illuminate\Support\Str;

if (!function_exists('getAdminGuard')) {
    /**
     * Get admin guard
     *
     * @return string
     */
    function getAdminGuard(): string
    {
        return 'admin';
    }
}

if (!function_exists('getAdminProviderGuard')) {
    /**
     * Get admin provider guard
     *
     * @return string
     */
    function getAdminProviderGuard(): string
    {
        return 'admins';
    }
}

if (!function_exists('getApiGuard')) {
    /**
     * Get api guard
     *
     * @return string
     */
    function getApiGuard(): string
    {
        return 'api';
    }
}

if (!function_exists('generateErrorMessage')) {
    /**
     * Generate error message
     *
     * @param string $message
     * @param int $status
     * @return array
     */
    function generateErrorMessage(string $message, int $status = 404): array
    {
        return ['errors' => true, 'message' => $message, 'status' => $status];
    }
}

if (!function_exists('generateSuccessMessage')) {
    /**
     * Generate success message
     *
     * @param string $message
     * @param int $status
     * @return array
     */
    function generateSuccessMessage(string $message = '', int $status = 200): array
    {
        return ['errors' => false, 'message' => $message, 'status' => $status];
    }
}

if (!function_exists('generateSuccessData')) {
    /**
     * Generate success data
     *
     * @param mixed $data
     * @param int $status
     * @return array
     */
    function generateSuccessData(mixed $data, int $status = 200): array
    {
        return ['errors' => false, 'data' => $data, 'status' => $status];
    }
}

if (!function_exists('isLocalEnvironment')) {
    /**
     * Check local environment
     *
     * @return bool
     */
    function isLocalEnvironment(): bool
    {
        return config('app.env') == 'local';
    }
}

if (!function_exists('formatSlashToUpperScoreDate')) {
    /**
     * Format slash(/) to upper score (-) date
     *
     * @param string $date
     * @return string
     */
    function formatSlashToUpperScoreDate(string $date): string
    {
        return str_replace('/', '-', $date);
    }
}

if (!function_exists('formatDashToSlashDate')) {
    /**
     * Format dash (-) to slash(/) date
     *
     * @param string $date
     * @return string
     */
    function formatDashToSlashDate(string $date): string
    {
        return str_replace('-', '/', $date);
    }
}

if (!function_exists('checkValidNumber')) {
    /**
     * Check a number valid or not
     *
     * @param mixed $number
     * @return bool
     */
    function checkValidNumber(mixed $number): bool
    {
        if (!ctype_digit($number) || Str::startsWith($number, '0')) {
            return false;
        }

        $number = (int) $number;
        if (!is_integer($number) || empty($number)) {
            return false;
        }

        return true;
    }
}

if (!function_exists('generateBookingId')) {
    /**
     * Generate booking id
     *
     * @return string
     */
    function generateBookingId(): string
    {
        return date('ymdHi') . strtoupper(Str::random(5));
    }
}

if (!function_exists('checkIsInvalidNumber')) {
    /**
     * Check a number invalid or not
     *
     * @param mixed $number
     * @return bool
     */
    function checkIsInvalidNumber(mixed $number): bool
    {
        if (!ctype_digit($number) || Str::startsWith($number, '0')) {
            return true;
        }

        return (strlen($number) > \App\Common\Constant::LIMIT_19_CHARACTERS);
    }
}

if (!function_exists('addSecondsToTime')) {
    /**
     * Add seconds to time
     *
     * @param string $time
     * @return string
     */
    function addSecondsToTime(string $time): string
    {
        return "{$time}:00";
    }
}

if (!function_exists('generateRandomCharacter')) {
    /**
     * Generate 6 character
     *
     * @param ?int $number
     * @return string
     * @throws Exception
     */
    function generateRandomCharacter(?int $number = 3): string
    {
        return strtoupper(bin2hex(random_bytes($number)));
    }
}

if (!function_exists('generateVeritransAccountId')) {
    /**
     * Generate booking id
     *
     * @return string
     * @throws Exception
     */
    function generateVeritransAccountId(): string
    {
        return date('ymdHi') . random_int(10000, 99999);
    }
}

if (!function_exists('generateShuffleRandomString')) {
    /**
     * Generate shuffle random string
     *
     * @param int $length
     * @return string
     */
    function generateShuffleRandomString(int $length = 5): string
    {
        return str_shuffle(date('ymdHi') . strtoupper(Str::random($length)));
    }
}

