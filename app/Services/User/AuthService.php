<?php

namespace App\Services\User;

use App\Common\BioStarConstant;
use App\Common\CodeMaster;
use App\Common\CommonFunction;
use App\Common\Constant;
use App\Http\Requests\User\LoginRequest;
use App\Http\Resources\User\FileManagementResource;
use App\Mail\Admin\BioStar2LinkFailure;
use App\Mail\Auth\IndividualUserRegisterSuccess;
use App\Mail\Auth\SendMailRegister;
use App\Services\BaseAuthService;
use App\Services\BioStarService;
use Aws\Credentials\Credentials;
use Aws\Exception\AwsException;
use Aws\Sns\SnsClient;
use Carbon\Carbon;
use Exception;
use Illuminate\Support\Facades\Crypt;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Storage;
use Illuminate\Validation\ValidationException;
use SimpleSoftwareIO\QrCode\Facades\QrCode;

class AuthService extends BaseAuthService
{
    /**
     * Handle login a admin
     *
     * @param LoginRequest $request
     * @return array
     * @throws ValidationException
     */
    public function login(LoginRequest $request): array
    {
        $data = $request->authenticate();

        if (!empty($data['errors'])) {
            return $data;
        }

        $user = $data['data']['info'];

        if ($user['roleId'] === Constant::NORMAL_USER_ROLE_ID) {
            $fileApplying = $this->fileManagementRepository->findFileApplying(CodeMaster::CATEGORY_CODE[CodeMaster::CATEGORY_D1029]['termsOfService']);
            $currentVersion = $fileApplying->file_version ?? '';
            $individualUser = $this->individualUserRepository->findWhere(['user_id' => $user['id']]);

            if (!$individualUser) {
                throw ValidationException::withMessages(['email' => [__('messages.AMSG.00001')]]);
            }

            if ($currentVersion !== $individualUser->accept_policy_version) {
                if (!$request->get('acceptTermOfService')) {
                    throw ValidationException::withMessages(['acceptTermOfService' => new FileManagementResource($fileApplying)]);
                }

                $this->individualUserRepository->whereAndUpdate([
                    'user_id' => $user['id'],
                ], [
                    'accept_policy_version' => $currentVersion,
                    'accept_policy_date'    => Carbon::now()->format(Constant::DATE_FORMAT_MYSQL_YYYY_MM_DD),
                ]);
            }
        }

        return $data;
    }

    /**
     * Handle send mail confirm register
     *
     * @param array $request
     * @return array
     */
    public function sendMailRegister(array $request): array
    {
        try {
            // 4-1) ユーザー取得
            if ($this->userRepository->findWhere(['email' => $request['email']]) !== null) {
                // 4-2) 存在確認
                return generateErrorMessage(__('messages.AMSG.00020', [
                    'attribute' => __('common.attributes.email')
                ]), Constant::HTTP_STATUS_NOT_ACCEPTABLE);
            }
            // 4-3) 通知メールを送信する。
            $expireTime = Carbon::now()->addMinutes(config('auth.email.verification.expire'));
            $params = [
                'email'  => $request['email'],
                'url'    => config('app.fe_user_url') . '/register?q='
                    . Crypt::encryptString('email=' . $request['email'] . '&expire=' . $expireTime),
                'expire' => $expireTime->toDateTimeString()
            ];
            Mail::to($request['email'])->send(new SendMailRegister($params));
        } catch (Exception $e) {
            logs()->error($e->getMessage());
            return generateErrorMessage(__('messages.AMSG.00073'), Constant::HTTP_STATUS_BAD_REQUEST);
        }
        return generateSuccessMessage();
    }

    /**
     * Check valid url register
     *
     * @param array $request
     * @return array
     */
    public function verifyRegistrationLink(array $request): array
    {
        try {
            parse_str(Crypt::decryptString($request['q']), $params);
            $expire = $params['expire'] ?? '';
            $email = $params['email'] ?? '';
            if (empty($expire) || empty($email)) {
                return generateErrorMessage(__('messages.AMSG.00106'));
            }
            // 3-1) 登録リンクの有効期限チェック
            if (Carbon::parse($params['expire'])->lte(Carbon::now())) {
                return generateErrorMessage(__('messages.AMSG.00087'));
            }
            // 3-2) メールアドレスチェック
            if (!is_null($this->userRepository->findWhere(['email' => $email]))) {
                return generateErrorMessage(__('messages.AMSG.00020', [
                    'attribute' => __('common.attributes.email')
                ]), Constant::HTTP_STATUS_CONFLICT);
            }
        } catch (Exception $e) {
            return generateErrorMessage(__('messages.AMSG.00106'));
        }
        return generateSuccessData(['email' => $email]);
    }

    /**
     * Create user information
     *
     * @param array $request
     * @return array
     * @throws Exception
     */
    public function store(array $request): array
    {
        DB::beginTransaction();
        try {
            $dataSave                    = CommonFunction::convertArrayKeyToSnakeCase($request);
            if (!$this->userRepository->createIndividualUser($dataSave)) {
                DB::rollBack();
                return generateErrorMessage(__('messages.AMSG.00054'), Constant::HTTP_STATUS_BAD_REQUEST);
            }
        } catch (Exception $e) {
            logs()->error($e);
            DB::rollBack();
            return generateErrorMessage(__('messages.AMSG.00054'), Constant::HTTP_STATUS_CONFLICT);
        }
        DB::commit();
        return generateSuccessMessage(__('messages.AMSG.00016', [
            'attribute' => __('common.attributes.user')
        ]));
    }

}
