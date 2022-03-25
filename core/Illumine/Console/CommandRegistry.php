<?php

namespace Illumine\Console;

class CommandRegistry
{

    /**
     * Command path string
     * @var string
     */
    protected $commands_path;

    /**
     * Command namespace array
     * @var array
     */
    protected $namespaces = [];

    /**
     * The commands registered with the application.
     * @var array
     */
    protected $default_registry = [];

    /**
     * The commands registered with the application.
     *
     * @var array
     */
    protected $registry = [];

    /**
     * Register a command with the application.
     *
     * @var array
     */
    protected $commands = [];

    /**
     * Create a new command registry instance.
     *
     * @param  string  $commands_path
     * @return void
     */
    public function __construct($commands_path)
    {
        $this->commands_path = $commands_path;
        $this->autoloadNamespaces();
    }

    /**
     * Autoload the all namespaces.
     *
     * @return void
     */
    public function autoloadNamespaces()
    {
        foreach (glob($this->getCommandsPath() . '/*', GLOB_ONLYDIR) as $namespace_path) {
            $this->registerNamespace(basename($namespace_path));
        }
    }

    /**
     * Register a command namespace in the IoC container.
     *
     * @param  string  $command_namespace
     * @return void
     */
    public function registerNamespace($command_namespace)
    {
        $namespace = new CommandNamespace($command_namespace);
        $namespace->loadCommands($this->getCommandsPath());
        $this->namespaces[strtolower($command_namespace)] = $namespace;
    }

    /**
     * Get Namespace from namespaces property.
     *
     * @param  string  $command
     * @return \Illumine\Console\CommandNamespace
     */
    public function getNamespace($command)
    {
        return isset($this->namespaces[$command]) ? $this->namespaces[$command] : null;
    }

    /**
     * Get the commands path.
     *
     * @return string
     */
    public function getCommandsPath()
    {
        return $this->commands_path;
    }

    /**
     * Register a command with the application.
     *
     * @return array
     */
    public function registerCommand($name, $callable)
    {
        $this->default_registry[$name] = $callable;
    }

    /**
     * Get the command registered with the application.
     *
     * @return \Illumine\Console\Command
     */
    public function getCommand($command)
    {
        return isset($this->default_registry[$command]) ? $this->default_registry[$command] : null;
    }

    /**
     * Get the command callback with the application.
     *
     * @return
     */
    public function getCallableCommand($command, $subcommand = null)
    {
        $namespace = $this->getNamespace($command);

        if ($namespace !== null) {
            return $namespace->getCommand($subcommand);
        }

        return null;
    }

//    /**
//     * @param string $command
//     * @param \Closure $callable
//     */
//    public function register($command, $callable)
//    {
//        $this->registry[$command] = $callable;
//    }
//
//    /**
//     * @param string $command
//     * @return string
//     */
//    public function get($command)
//    {
//        return $this->registry[$command];
//    }
//
//    /**
//     * Register the given command with the console application.
//     * @param string $command_name
//     * @param \Illumine\Console\Command $command
//     * @return \Illumine\Console\Command
//     */
//    public function registerCommand($command_name, Command $command)
//    {
//        $this->commands = [ $command_name => $command ];
//    }
//
//    /**
//     * Get the command class with the given name.
//     * @param string $command_name
//     * @return \Illumine\Console\Command
//     */
//    public function getCommand($command_name)
//    {
//        return isset($this->commands[$command_name]) ? $this->commands[$command_name] : null;
//    }

    /**
     * Get command callable.
     * @param string $command_name
     * @return object | array $command
     */
    public function getCallable($command_name)
    {
        $single_command = $this->getCommand($command_name);
        if ($single_command === null) {
            throw new \Exception(sprintf("Command \"%s\" not found.", $command_name));
        }

        return $single_command;

    }

}