<?php

return [

    /*
    |--------------------------------------------------------------------------
    | Validation Language Lines
    |--------------------------------------------------------------------------
    |
    | The following language lines contain the default error messages used by
    | the validator class. Some of these rules have multiple versions such
    | as the size rules. Feel free to tweak each of these messages here.
    |
    */

    'alpha_num' => '※:attributeは英数記号で入力してください。',

    'max' => [
        'string' => '※:attributeは:max字以下で入力してください。',
    ],

    'required' => '※:attributeが入力されていません。',

    'between' => [
        'string' => '※:attributeは:min桁～:max桁で入力して下さい。',
        ],
    /*
    |--------------------------------------------------------------------------
    | Custom Validation Language Lines
    |--------------------------------------------------------------------------
    |
    | Here you may specify custom validation messages for attributes using the
    | convention "attribute.rule" to name the lines. This makes it quick to
    | specify a specific custom language line for a given attribute rule.
    |
    */

    'custom' => [
        'attribute-name' => [
            'rule-name' => 'custom-message',
        ],
    ],

    /*
    |--------------------------------------------------------------------------
    | Custom Validation Attributes
    |--------------------------------------------------------------------------
    |
    | The following language lines are used to swap our attribute placeholder
    | with something more reader friendly such as "E-Mail Address" instead
    | of "email". This simply helps us make our message more expressive.
    |
    */

    'attributes' => [
        'username' => 'ユーザー名',
        'password' => 'パスワード',
        'title' => 'タイトル',
        'release_date' => '公開開始日',
        'information' => 'お知らせ',
        'url' => 'URL',
    ],

];
