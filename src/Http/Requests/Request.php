<?php

namespace PHPHos\Laravel\Http\Requests;

use Illuminate\Contracts\Validation\Validator;
use Illuminate\Foundation\Http\FormRequest;
use PHPHos\Laravel\Exceptions\Exception;
use PHPHos\Laravel\Interfaces\Constant;
use Symfony\Component\HttpFoundation\Response as Http;

abstract class Request extends FormRequest implements Constant
{
    /**
     * @inheritdoc
     */
    public static function rules()
    {
        return [];
    }

    /**
     * @inheritdoc
     */
    public function authorize()
    {
        return true;
    }

    /**
     * @inheritdoc
     */
    protected function failedValidation(Validator $validator)
    {
        $errors = $validator->errors()->all();
        $message = reset($errors);

        Exception::fail(
            $message,
            Http::HTTP_UNPROCESSABLE_ENTITY,
            Http::HTTP_UNPROCESSABLE_ENTITY
        );
    }
}
