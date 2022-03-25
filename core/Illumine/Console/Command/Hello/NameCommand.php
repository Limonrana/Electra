<?php

namespace Illumine\Console\Command\Hello;

use Illumine\Console\Command;

class NameCommand extends Command
{
    public function handle()
    {
        $name = $this->hasParam('user') ? $this->getParam('user') : 'World';

        $this->getOutput()->display(sprintf("Hello, %s!", $name));
    }
}