<?php

namespace Modules\RestAPI\Http\Requests;

use veerenjp\RestAPI\Exceptions\ApiException;
use Illuminate\Foundation\Http\FormRequest;

class BaseRequest extends FormRequest
{
    protected function failedAuthorization()
    {
        throw new ApiException('This action is unauthorized.');
    }
}
