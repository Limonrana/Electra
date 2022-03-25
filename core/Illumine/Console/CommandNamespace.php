<?php

namespace Illumine\Console;

class CommandNamespace
{
    /**
     * The namespace of the command.
     *
     * @var string
     */
    protected $namespace;

    /**
     * All the commands list array.
     *
     * @var array
     */
    protected $commands = [];

    /**
     * Create a new command namespace instance.
     *
     * @param  string  $namespace
     * @return void
     */
    public function __construct($namespace)
    {
        $this->namespace = $namespace;
    }

    /**
     * Get the namespace of the command.
     *
     * @return string
     */
    public function getNamespace()
    {
        return $this->namespace;
    }

    /**
     * Load all the commands under the namespace.
     *
     * @param string $commands_path
     * @return array
     */
    public function loadCommands($commands_path)
    {
        foreach (glob($commands_path . '/' . $this->getNamespace() . '/*Command.php') as $commandFile) {
            $this->loadCommandMap($commandFile);
        }

        return $this->getCommands();
    }

    /**
     * Get all the commands.
     *
     * @return array
     */
    public function getCommands()
    {
        return $this->commands;
    }

    /**
     * Get the single command.
     *
     * @param string $commandName
     * @return string
     */
    public function getCommand($commandName)
    {
        return isset($this->commands[$commandName]) ? $this->commands[$commandName] : null;
    }

    /**
     * Load the command map.
     *
     * @param string $commandFile
     * @return void
     */
    protected function loadCommandMap($commandFile)
    {
        $filename = basename($commandFile);

        $command_class = str_replace('.php', '', $filename);
        $command_name = strtolower(str_replace('Command', '', $command_class));
        $full_class_name = sprintf("Illumine\\Console\\Command\\%s\\%s", $this->getNamespace(), $command_class);

        /** @var Command $command */
        $command = new $full_class_name();
        $this->commands[$command_name] = $command;
    }
}