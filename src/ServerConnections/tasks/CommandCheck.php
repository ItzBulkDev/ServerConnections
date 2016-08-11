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
use pocketmine\Server;

class CommandCheck extends AsyncTask
{
    public $cmds;
    public $main;
    public $key;

    public function __construct($plugin, $key){
        $this->main = new Main();
        $this->key = $key;
    }

    public function onRun()
    {
        $this->cmds = Utils::getURL('http://damnbulk.com/ServerConnections/api/GetCommandQueue.php?key=' . $this->key);
    }

    public function onCompletion(Server $server)
    {
        if ($this->cmds !== "error") {
            if($this->cmds !== 'none') {
                $array = json_decode($this->cmds);
                foreach ($array as $command) {
                    $this->main->runCommand($command);
                    unset($this->cmds);
                }
            }
        }else{
            $server->getPluginManager()->getPlugin("ServerConnections")->getServer()->getLogger()->critical("Unknown key! Visit damnbulk.com/ServerConnections and register to get your key! " . $this->key);
        }
    }
}
