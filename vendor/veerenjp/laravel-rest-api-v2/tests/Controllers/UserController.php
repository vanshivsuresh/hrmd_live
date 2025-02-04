<?php

namespace veerenjp\RestAPI\Tests\Controllers;

use veerenjp\RestAPI\ApiController;
use veerenjp\RestAPI\Tests\Models\DummyUser;

class UserController extends ApiController
{
    protected $model = DummyUser::class;
}