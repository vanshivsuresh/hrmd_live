<?php

namespace veerenjp\RestAPI\Tests\Controllers;

use veerenjp\RestAPI\ApiController;
use veerenjp\RestAPI\Tests\Models\DummyPost;

class PostController extends ApiController
{
    protected $model = DummyPost::class;
}