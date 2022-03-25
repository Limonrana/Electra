<?php

namespace Illumine\Console;

class CommandCall
{
    /**
     * The console command instance.
     *
     * @var \Illumine\Console\Command
     */
    public $command;

    /**
     * The console subcommand arguments.
     *
     * @var \Illumine\Console\Command
     */
    public $subcommand;

    /**
     * The console command arguments.
     *
     * @var array
     */
    public $args = [];

    /**
     * The console command options/params.
     *
     * @var array
     */
    public $params = [];

    /**
     * Create a new command call instance.
     *
     * @param  \Illumine\Console\Command  $command
     * @param  array  $arguments
     * @param  array  $options
     * @return void
     */
    public function __construct(array $argv)
    {
        $this->args = $argv;
        $this->command = isset($argv[1]) ? $argv[1] : null;
        $this->subcommand = isset($argv[2]) ? $argv[2] : 'default';
    }

    /**
     * Load Params with Application.
     *
     * @return void
     */
    protected function loadParams(array $args)
    {
        foreach ($args as $arg) {
            $pair = explode('=', $arg);
            if (count($pair) == 2) {
                $this->params[$pair[0]] = $pair[1];
            }
        }
    }

    /**
     * Check param the console command instance.
     *
     * @return boolean
     */
    public function hasParam($param)
    {
        return isset($this->params[$param]);
    }

    /**
     * Get param the console command instance.
     *
     * @return string
     */
    public function getParam($param)
    {
        return $this->hasParam($param) ? $this->params[$param] : null;
    }

}