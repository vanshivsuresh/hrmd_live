<?php

namespace veerenjp\RestAPI\Tests\Controllers;

use veerenjp\RestAPI\ApiController;
use veerenjp\RestAPI\Tests\Models\DummyComment;

class CommentController extends ApiController
{
    protected $model = DummyComment::class;
}