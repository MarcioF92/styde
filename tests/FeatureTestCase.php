<?php

use Laravel\BrowserKitTesting\DatabaseTransactions;
use Laravel\BrowserKitTesting\TestCase as TestCaseAlias;
use Tests\CreatesApplication;
use Tests\TestsHelper;

class FeatureTestCase extends TestCaseAlias
{
    use DatabaseTransactions, CreatesApplication, TestsHelper;

    protected $connectionsToTransact = ['mysql_tests'];

    public function seeErrors(array $fields)
    {
        foreach ($fields as $name => $errors) {
            foreach ((array) $errors as $message) {
                $this->seeInElement(
                    "#field_{$name}.has-error .help-block", $message
                );
            }
        }
    }
}