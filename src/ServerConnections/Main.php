<?php
/**
 * Created by PhpStorm.
 * User: jaydenpatrick
 * Date: 8/10/16
 * Time: 7:46 PM
 */

namespace ServerConnections;

use pocketmine\command\ConsoleCommandSender;
use pocketmine\command\RemoteConsoleCommandSender;
use pocketmine\plugin\PluginBase;
use ServerConnections\tasks\CallCheckTask;
use ServerConnections\tasks\CommandCheck;

class Main extends PluginBase{

    public $key;

    public function onEnable()
    {
        $this->saveDefaultConfig();

        $this->key = $this->getConfig()->get("key");

        if(empty($this->key)){
            $this->getServer()->getLogger()->emergency("No key entered, disabling plugin. Get your key from damnbulk.com/ServerConnections when you register");
            return false;
        }

        $interval = $this->getConfig()->get("seconds");

        $this->getServer()->getScheduler()->scheduleRepeatingTask(new CallCheckTask($this), 20 * $interval);

    }

    public function check()
    {
        $this->getServer()->getScheduler()->scheduleAsyncTask(new CommandCheck($this));
    }

    public function runCommand($command)
    {
        $this->getServer()->dispatchCommand(new ConsoleCommandSender(), $command);
    }

}
