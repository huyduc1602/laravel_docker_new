<?php

namespace App\Rules\User;

use Illuminate\Contracts\Validation\Rule;
use App\Repositories\User\UserRepository;

class ValidateUserEmail implements Rule
{
    /**
     * @var string
     */
    private $error;

    /**
     * Determine if the validation rule passes.
     *
     * @param  string  $attribute
     * @param  mixed  $value
     * @return bool
     */
    public function passes($attribute, $value)
    {
        $account = app(UserRepository::class)->findWhere(['email' => $value]);
        if (empty($account)) {
            $this->setErrorData(__('messages.AMSG.00001'));

            return false;
        }

        if (!$account->can_access_user_side) {
            $this->setErrorData(__('messages.AMSG.00001'));

            return false;
        }

        return true;
    }

    /**
     * Set error data
     *
     * @param string $message
     * @return void
     */
    private function setErrorData(string $message): void
    {
        $this->error = $message;
    }

    /**
     * Get the validation error message.
     *
     * @return string
     */
    public function message()
    {
        return $this->error;
    }
}
