<?php

namespace veerenjp\RestAPI\Exceptions\Parse;

use veerenjp\RestAPI\Exceptions\ApiException;
use veerenjp\RestAPI\Exceptions\ErrorCodes;

class InvalidFilterDefinitionException extends ApiException
{

    protected $code = ErrorCodes::REQUEST_PARSE_EXCEPTION;

    protected $innerError = ErrorCodes::INNER_INVALID_FILTER_DEFINITION;

    protected $message = "Filter defined incorrectly";

}