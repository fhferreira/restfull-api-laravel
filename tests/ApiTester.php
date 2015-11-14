<?php

use Faker\Factory as Faker;

class ApiTester extends TestCase
{
    protected $fake;

    protected $times = 1;

    /**
     * ApiTester constructor.
     */
    public function __construct()
    {
        $this->fake = Faker::create();
    }

    public function times($count)
    {
        $this->times = $count;
    }

}