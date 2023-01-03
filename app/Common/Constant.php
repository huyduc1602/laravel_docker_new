<?php

namespace App\Common;

class Constant
{
    // HTTP status code
    const HTTP_STATUS_OK                   = 200;
    const HTTP_STATUS_CREATED              = 201;
    const HTTP_STATUS_ACCEPTED             = 202;
    const HTTP_STATUS_BAD_REQUEST          = 400;
    const HTTP_STATUS_UNAUTHORIZED         = 401;
    const HTTP_STATUS_FORBIDDEN            = 403;
    const HTTP_STATUS_NOT_FOUND            = 404;
    const HTTP_STATUS_NOT_ACCEPTABLE       = 406;
    const HTTP_STATUS_CONFLICT             = 409;
    const HTTP_STATUS_UNPROCESSABLE_ENTITY = 422;

    // Ajax Pagination
    const DEFAULT_LIMIT            = 10;
    const DEFAULT_DRAW             = 1;
    const DEFAULT_OFFSET           = 0;
    const DEFAULT_DIRECTION        = 'asc';
    const DEFAULT_ORDER_COLUMN     = 1;
    const DEFAULT_COLUMN           = 'id';
    const PER_PAGE_VALUES          = [25, 50, 100];
    const PER_PAGE_VALUES_USER_API = [12];
    const SORT_DESCENDING          = 'desc';

    // Statuses
    const ACTIVE        = 1;
    const INACTIVE      = 0;
    const STATUS_VALUES = [self::ACTIVE, self::INACTIVE];

    // Format date yyyy/MM
    const DATE_FORMAT_YYYY_MM         = 'Y/m';
    const DATE_FORMAT_YYYY_MM_DISPLAY = 'YYYY/MM';
    // Format date yyyy/MM
    const DATE_FORMAT_YYYY_MM_DD_HH_MM_SS = 'Y/m/d H:i:s';
    // Format date yyyy/MM_DD_HH_MM
    const DATE_FORMAT_YYYY_MM_DD_HH_MM = 'Y/m/d H:i';
    const DATE_FORMAT_HH_MM            = 'H:i';
    const DATE_FORMAT_YYYY_MM_DD       = 'Y/m/d';
    const DATE_FORMAT_YYYYMMDDHHMMSS   = 'YmdHis';
    const DEFAULT_TIME_START           = '00:00:00';
    const DEFAULT_TIME_START_H_I       = '00:00';
    const DEFAULT_TIME_END             = '23:59:59';
    const DEFAULT_TIME_END_H_I         = '23:59';
    const DEFAULT_FROM_TIME            = '00:00:00';
    const DEFAULT_TO_TIME              = '23:45:00';

    const DATE_FORMAT_MYSQL_YYYY_MM              = 'Y-m';
    const DATE_FORMAT_MYSQL_YYYY_MM_DD           = 'Y-m-d';
    const DATE_FORMAT_MYSQL_HH_MM_SS             = 'H:i:00';
    const DATE_FORMAT_HH_MM_SS                   = 'H:i:s';
    const DATE_FORMAT_MYSQL_YYYY_MM_DD_HH_MM_SS  = 'Y-m-d H:i:s';
    const DATE_FORMAT_MYSQL_YYYY_MM_DDTHH_MM_SSZ = 'Y-m-d\TH:i:s.000\Z';


    // Roles
    const SYSTEM_ADMIN                 = 'system_admin';
    const COMPANY_ADMIN                = 'company_admin';
    const COMPANY_MEMBER               = 'company_member';
    const NORMAL_USER                  = 'normal_user';
    const SUPER_ADMIN_ROLE_ID          = 1;
    const COMPANY_ADMIN_ROLE_ID        = 2;
    const COMPANY_USER_ROLE_ID         = 3;
    const NORMAL_USER_ROLE_ID          = 4;
    const ROLE_ID                      = [
        self::SYSTEM_ADMIN   => self::SUPER_ADMIN_ROLE_ID,
        self::COMPANY_ADMIN  => self::COMPANY_ADMIN_ROLE_ID,
        self::COMPANY_MEMBER => self::COMPANY_USER_ROLE_ID,
        self::NORMAL_USER    => self::NORMAL_USER_ROLE_ID,
    ];
    const DEFAULT_COMPANY_USER_ROLES   = [self::COMPANY_ADMIN_ROLE_ID, self::COMPANY_USER_ROLE_ID];
    const DEFAULT_USERS_SIDE_ROLE_NAME = [self::COMPANY_ADMIN, self::COMPANY_MEMBER, self::NORMAL_USER];
    const DEFAULT_USERS_SIDE_ROLE_ID   = [self::COMPANY_ADMIN_ROLE_ID, self::COMPANY_USER_ROLE_ID, self::NORMAL_USER_ROLE_ID];

    // String
    const REMEMBER_TOKEN = 60;

    // Time
    const SIXTY_SECONDS          = 60;
    const FIVE_MINUTES           = 5;
    const FIFTEEN_MINUTES        = 15;
    const THIRTY_MINUTES         = 30;
    const SIXTY_MINUTES          = 60;
    const A_DAY_TO_MINUTES       = 24 * self::SIXTY_MINUTES;
    const FIVE_MINUTES_TO_SECOND = self::FIVE_MINUTES * self::SIXTY_SECONDS;
    const MINUTES_IN_A_DAY       = 1440;

    // Default pagination
    const DEFAULT_PER_PAGE          = 25;
    const DEFAULT_PER_PAGE_USER_API = 12;
    const DEFAULT_PAGE              = 1;

    // Max results
    const DEFAULT_MAX_RESULTS = 1000;

    // Validation
    const VALIDATION_RULE = [
        // min
        'minLength8'             => 8,
        // max
        'maxLength7'             => 7,
        'maxLength10'            => 10,
        'maxLength11'            => 11,
        'maxLength24'            => 24,
        'maxLength32'            => 32,
        'maxLength50'            => 50,
        'maxLength64'            => 64,
        'maxLength150'           => 150,
        'maxLength175'           => 175,
        'maxLength255'           => 255,
        'maxLength256'           => 256,
        // regex
        'fullwidthKatakana'      => '/^([ァ-ン]|ー)+$/u',
        'regexEmployeeNumber'    => '/^[a-zA-Z0-9 ~!@#$%^&*()_+\/.-]+$/u',
        'cardholderName'         => '/^(?:[A-Za-z0-9]+ ?)$/u',
        // Regex pattern by Biostar
        'emailAlphabetSymbol'    => '/^([a-zA-Z0-9_-]{1,86}(?:\.[a-zA-Z0-9_-]+)*)@((?:[a-zA-Z]+\.)*[a-zA-Z]{1,60})\.(?:(?:[a-zA-Z]{2,20})$|(?:[a-zA-Z]{2,20}.\[a-zA-Z]{2,6})$)/u',
        'alphabetSymbol'         => '/^[a-zA-Z0-9._^%$#!~@,-]+$/u',
        'alphabetSpace'          => '/^[a-zA-Z0-9 ]+$/u',
        'password'               => '/^(?!.*[\s　])(?=.*[0-9])(?=.*[a-zA-Z])(?=.*[!#$%&=~^|@<>?+*\/_;*-]).{8,64}$/u',
        'onlyNumber'             => '/^[0-9]*$/u',
        // date
        'forwardSlashDateFormat' => self::DATE_FORMAT_YYYY_MM_DD,
        'timeFormat'             => 'H:i',
        // digits
        'digits1'                => 1,
        'digits3'                => 3,
        'digits4'                => 4,
        'digits6'                => 6,
        'digits7'                => 7,
        'digits10'               => 10,
        'digits11'               => 11,
        'digits12'               => 12,
        'digits16'               => 16,
        'digits19'               => 19,
        // between
        'between3And4'           => '3,4',
        'between10And11'         => '10,11',
        'between18And80'         => '18,80',
        'between0And999billion'  => '0,999999999999',
    ];

    const BETWEEN_NUMBER = [
        '18' => 18,
        '80' => 80,
    ];

    // FE urls
    const FE_ADMIN_RESET_PASSWORD_URL = 'admin/reset-password';
    const FE_USER_RESET_PASSWORD_URL  = 'reset-password';
    const BASE_PATH_PREFIX            = '/admin/';
    const FE_USE_FACIlITY_FILE        = '/assets/pdf/servicemanual.pdf';

    // Language
    const DEFAULT_LANGUAGE        = 'vi';
    const DEFAULT_LANGUAGE_VALUES = ['vi', 'en'];

    // Authentication messages
    const UNAUTHENTICATED_MESSAGE = 'Unauthenticated.';

    // Storage
    const PUBLIC_DISK = 'public';
    const SCODE_FILE  = 'scode.json';

    // Migration
    const LIMIT_IMAGE_NAME           = 128;
    const LIMIT_4000_CHARACTERS      = 4000;
    const LIMIT_1000_CHARACTERS      = 1000;
    const LIMIT_256_CHARACTERS       = 256;
    const LIMIT_175_CHARACTERS       = 175;
    const LIMIT_150_CHARACTERS       = 150;
    const LIMIT_128_CHARACTERS       = 128;
    const LIMIT_64_CHARACTERS        = 64;
    const LIMIT_50_CHARACTERS        = 50;
    const LIMIT_32_CHARACTERS        = 32;
    const LIMIT_19_CHARACTERS        = 19;
    const LIMIT_15_CHARACTERS        = 15;
    const LIMIT_11_CHARACTERS        = 11;
    const LIMIT_10_CHARACTERS        = 10;
    const LIMIT_7_CHARACTERS         = 7;
    const DEFAULT_ZERO_VALUE         = 0;
    const DEFAULT_BUSINESS_TIME_FROM = '00:00:00';
    const DEFAULT_BUSINESS_TIME_TO   = '23:45:00';
    const DEFAULT_TIME_FROM_SEED     = '08:00:00';
    const DEFAULT_TIME_TO_SEED       = '23:00:00';

    const DEMO_IMAGE_PATH    = 'demo/demo-%s.jpg';
    const DEFAULT_IMAGE_PATH = 'training/default-images/no-image.jpg';
    const DEFAULT_IMAGE_NAME = 'No image';

    const REQUEST_HEADER_X_FORWARDED_ALL = 0b1011110;
}
