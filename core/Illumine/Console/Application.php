<?php

namespace Illumine\Console;


class Application
{
    /**
     * The Electra application instance.
     *
     * @var \Illumine\Console\Application
     */
    protected $app_signature;

    /**
     * The Electra commands output by your application.
     *
     * @var object
     */
    protected $output;

    /**
     * The Electra commands register by the application.
     *
     * @var object
     */
    protected $commandRegistry;

    /**
     * Create a new Electra console application.
     *
     * @param  \Illumine\Console\Application  $app
     * @return void
     */
    public function __construct()
    {
        $this->output = new OutputStyle();
        $this->commandRegistry = new CommandRegistry(__DIR__ . '/Command');
    }

    /**
     * Get the Electra console application.
     *
     * @return Application
     */
    public function getSignature()
    {
        return $this->app_signature;
    }

    /**
     * Set the Electra console application.
     *
     * @return Application
     */
    public function setSignature($app_signature)
    {
        $this->app_signature = $app_signature;
    }


    /**
     * Print the Electra console application.
     *
     * @return Application
     */
    public function printSignature()
    {
        $this->getOutput()->display(sprintf("usage: %s", $this->getSignature()));
    }

    /**
     * Register the given command with the console application.
     * @param string $command_name
     * @param \Illumine\Console\Command $command
     * @return void
     */
    public function registerCommand($name, Command $command)
    {
        $this->commandRegistry->registerCommand($name, $command);
    }

    /**
     * Get output the Electra console application.
     *
     * @return object
     */
    public function getOutput()
    {
        return $this->output;
    }

    /**
     * Run the console application.
     *
     * @param  array  $arguments
     * @param string  $default_command
     * @return string
     */
    public function runCommand(array $argv = [], $default_command = '--help')
    {
        $input = new CommandCall($argv);

        if (count($input->args) < 2) {
            $this->printSignature();
            exit;
        }

        $controller = $this->commandRegistry->getCallableCommand($input->command, $input->subcommand);

        if ($controller instanceof Command) {
            $controller->boot($this);
            $controller->run($input);
            $controller->teardown();
            exit;
        }

        $this->runSingle($input);
    }

    /**
     * Run Single Command the console application.
     *
     * @param CommandCall  $input
     * @return string
     */
    protected function runSingle(CommandCall $input)
    {
        try {
            $callable = $this->commandRegistry->getCallable($input->command);
            call_user_func($callable, $input);
        } catch (\Exception $e) {
            $this->getOutput()->display("ERROR: " . $e->getMessage());
            $this->printSignature();
            exit;
        }
    }
}