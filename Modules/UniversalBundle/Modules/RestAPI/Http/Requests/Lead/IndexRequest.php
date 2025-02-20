<?php

namespace Modules\RestAPI\Http\Requests\Lead;

use Modules\RestAPI\Http\Requests\BaseRequest;

class IndexRequest extends BaseRequest
{
    /**
     * @return bool
     *
     * @throws \veerenjp\RestAPI\Exceptions\UnauthorizedException
     */
    public function authorize()
    {
        $user = api_user();

        return in_array('leads', $user->modules) && ($user->hasRole('admin') || $user->cans('view_lead'));
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [

        ];
    }
}
