<?php

namespace Illumine\Console;

abstract class Command
{
    /**
     * The console command app instance.
     * @var \Illumine\Console\Application
     */
    protected $app;

    /**
     * The console command input.
     * @var  CommandCall
     */
    protected $input;

    /**
     * Handle the console command.
     *
     * @return void
     */
    abstract public function handle();

    /**
     * Get the console command arguments.
     *
     * @param Application $app
     * @return void
     */
    public function boot(Application $app)
    {
        $this->app = $app;
    }

    /**
     * Execute the console command.
     *
     * @param CommandCall $input
     * @return void
     */
    public function run(CommandCall $input)
    {
        $this->input = $input;
        $this->handle();
    }

    /**
     * Called when `run` is successfully finished.
     *
     * @return void
     */
    public function teardown()
    {
        //
    }

    /**
     * Get the console command arguments.
     *
     * @return array
     */
    protected function getArgs()
    {
        return $this->input->args;
    }

    /**
     * Get the console command parameters.
     *
     * @return array
     */
    protected function getParams()
    {
        return $this->input->params;
    }

    /**
     * Check param the console command instance.
     *
     * @return boolean
     */
    protected function hasParam($param)
    {
        return $this->input->hasParam($param);
    }

    /**
     * Get the console command parameter.
     *
     * @return string
     */
    protected function getParam($param)
    {
        return $this->input->getParam($param);
    }

    /**
     * Get Application Instance.
     * @param array $args
     * @return object
     */
    public function getApp()
    {
        return $this->app;
    }

    /**
     * Get the console command output.
     *
     * @return string | array | object | null
     */
    protected function getOutput()
    {
        return $this->getApp()->getOutput();
    }

}