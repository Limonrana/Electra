<?php

namespace Illumine\Console\Command;

use Illumine\Console\Command;

class HelloCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'hello {name}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Command description';

    /**
     * Run the console command.
     * @param array $arguments
     * @return array
     */
    public function run($argv)
    {
        $name = isset ($argv[2]) ? $argv[2] : "World";
        $this->getApp()->getOutput()->display("Hello $name!!!");
    }
}