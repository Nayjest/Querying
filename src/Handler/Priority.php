<?php

namespace Nayjest\Querying\Handler;

class Priority
{
    const PREPARE = 10;
    const MAIN_BEGIN = 10;
    const MAIN = 50;
    const MAIN_END = 80;
    const HYDRATE = 99;
    const POST_PROCESS_BEGIN = 100;
    const POST_PROCESS = 110;
    const POST_PROCESS_END = 200;

    private function __construct()
    {
    }
}
