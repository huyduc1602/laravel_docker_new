<?php

namespace App\Http\Resources\User;

use App\Common\Constant;
use App\Models\User;
use Illuminate\Http\Resources\Json\JsonResource;
use Carbon\Carbon;

class UserResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param \Illuminate\Http\Request $request
     * @return array|\Illuminate\Contracts\Support\Arrayable|\JsonSerializable
     */
    public function toArray($request)
    {
        $userInformation = [
            'id'                    => $this->id,
            'roleId'                => $this->role_id,
            'email'                 => $this->email,
            'firstName'             => $this->first_name,
            'lastName'              => $this->last_name,
            'birthday'              => $this->birthday_display,
            'gender'                => $this->gender,
        ];
        if ($this->role_id !== Constant::NORMAL_USER_ROLE_ID) {
            return $userInformation;
        }
        $userInfo = new User($this->user);
        return [
            ...$userInformation,
            'phoneNumber'          => $userInfo->resource['phone_number'] ?? '',
        ];

    }
}
