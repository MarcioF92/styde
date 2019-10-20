<?php

use Laravel\BrowserKitTesting\DatabaseTransactions;
use Tests\CreatesApplication;
use Tests\TestsHelper;

abstract class TestCase extends Illuminate\Foundation\Testing\TestCase
{
    use CreatesApplication, DatabaseTransactions, TestsHelper;
}
