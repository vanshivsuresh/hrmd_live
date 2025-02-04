<?php

namespace veerenjp\RestAPI\Exceptions\Parse;

use veerenjp\RestAPI\Exceptions\ApiException;
use veerenjp\RestAPI\Exceptions\ErrorCodes;

class InvalidOrderingDefinitionException extends ApiException
{
    protected $code = ErrorCodes::REQUEST_PARSE_EXCEPTION;

    protected $innerError = ErrorCodes::INNER_ORDERING_INVALID;

    protected $message = "Ordering defined incorrectly";
}