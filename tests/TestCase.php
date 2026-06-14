<?php

namespace Tests;

use Illuminate\Foundation\Testing\TestCase as BaseTestCase;
use Tests\Concerns\ActsAsRoles;

abstract class TestCase extends BaseTestCase
{
    use ActsAsRoles;
    use CreatesApplication;
}
