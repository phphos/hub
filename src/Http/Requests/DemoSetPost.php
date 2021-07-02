<?php

namespace PHPHos\Laravel\Http\Requests;

use PHPHos\Laravel\Http\Requests\Request;

class DemoSetPost extends Request
{
    /**
     * @inheritdoc
     */
    public static function rules()
    {
        return [
            'avatar' => 'required|max:255',
            'nickname' => 'required|max:32',
            'sex' => 'required',
            'birthday' => 'required',
        ];
    }
}
