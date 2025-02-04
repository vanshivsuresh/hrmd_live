<?php

namespace veerenjp\RestAPI\Exceptions\Parse;

use veerenjp\RestAPI\Exceptions\ApiException;
use veerenjp\RestAPI\Exceptions\ErrorCodes;

class FilterNotFoundException extends ApiException
{

    protected $code = ErrorCodes::REQUEST_PARSE_EXCEPTION;

    protected $innerError = ErrorCodes::INNER_FILTER_NOT_FOUND;

    protected $message = "Requested filter not found";

}