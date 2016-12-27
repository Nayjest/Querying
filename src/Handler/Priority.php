<?php

namespace Nayjest\Querying\Handler;

class Priority
{
    const CLONING = 100;
    const PREPARE = 90;
    const MAIN = 80;
    const FETCH = 70;
    const INITIALIZE_ROWS = 60;
    const POST_PROCESS = 50;

    private function __construct()
    {
    }
}
