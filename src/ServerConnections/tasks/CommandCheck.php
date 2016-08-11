<?php
/**
 * Created by PhpStorm.
 * User: jaydenpatrick
 * Date: 8/10/16
 * Time: 7:40 PM
 */

namespace ServerConnections\tasks;

use pocketmine\scheduler\AsyncTask;
use pocketmine\utils\Utils;
use ServerConnections\Main;

class CommandCheck extends AsyncTask
{
    public $cmds;
    public $main;

    public function __construct($plugin){
        $this->plugin = $plugin;
        $this->main = new Main();
    }

    public function onRun()
    {
        $this->cmds = Utils::getURL('http://damnbulk.com/ServerConnections/api/GetCommandQueue.php?key=' . $this->main->key);
    }

    public function onCompletion(Server $server)
    {
        if ($this->cmds !== "error") {
            $array = json_decode($this->cmds);
            foreach ($array as $command) {
                $this->main->runCommand($command);
                unset($this->cmds);
            }
        }else{
            $this->main->getServer()->getLogger()->critical("Unknown key! Visit damnbulk.com/ServerConnections and register to get your key!");
        }
    }
}
