<?php

namespace Illumine\Console;

class OutputStyle
{
    /**
     * @var \Illumine\Console\OutputStyle
     */
    public function out($message)
    {
        echo $message;
    }

    /**
     * @var \Illumine\Console\OutputStyle
     */
    public function newline()
    {
        $this->out("\n");
    }

    /**
     * @var \Illumine\Console\OutputStyle
     */
    public function display($message)
    {
        $this->newline();
        $this->out($message);
        $this->newline();
        $this->newline();
    }
}