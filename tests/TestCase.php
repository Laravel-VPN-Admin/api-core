<?php

namespace Tests;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\TestCase as BaseTestCase;
use Illuminate\Foundation\Testing\WithoutMiddleware;
use Nuwave\Lighthouse\Testing\MakesGraphQLRequests;

abstract class TestCase extends BaseTestCase
{
    use CreatesApplication, MakesGraphQLRequests, RefreshDatabase, WithoutMiddleware;
}
