<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use App\Common\Constant;

class PasswordUpdate extends Mailable
{
    use Queueable, SerializesModels;

    /**
     * @var string
     */
    private string $fullName;

    /**
     * @var int
     */
    private int $roleId;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct($fullName, $roleId)
    {
        $this->fullName = $fullName;
        $this->roleId   = $roleId;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        $comoluText = str_contains(request()->getPathInfo(), Constant::BASE_PATH_PREFIX)
            ? __('emails.passwordUpdateNotification.line6') : __('emails.textComoluUrl');


        $redirectUrl = $this->roleId == Constant::SUPER_ADMIN_ROLE_ID || $this->roleId == Constant::COMPANY_ADMIN_ROLE_ID
            ? config('app.fe_admin_url') . '/admin/login' : config('app.fe_user_url') . '/login';

        $this->from(config('mail.from.reset_password'), config('app.name'))
             ->subject(__('emails.passwordUpdateNotification.subject'))
             ->markdown('emails.password_update_notification');
        $this->viewData['headerTitle'] = __('emails.passwordUpdateNotification.textHeader');
        $this->viewData['fullName'] = $this->fullName . __('emails.commonPassword.fullWidthSpace') . __('emails.textUser');
        $this->viewData['redirectUrl'] = $redirectUrl;
        $this->viewData['comoluText'] = $comoluText;

        return $this;
    }
}
