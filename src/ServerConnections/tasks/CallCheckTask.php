<?php
/**
 * Created by PhpStorm.
 * User: jaydenpatrick
 * Date: 8/10/16
 * Time: 7:55 PM
 */

namespace ServerConnections\tasks;

use pocketmine\scheduler\PluginTask;

class CallCheckTask extends PluginTask
{
    public $plugin;

    /**
     * CallCheckTask constructor.
     * @param \pocketmine\plugin\Plugin $plugin
     */
    public function __construct($plugin)
    {
        $this->plugin = $plugin;
        parent::__construct($plugin);
    }

    /**
     * @param $currentTick
     */
    public function onRun($currentTick)
    {
        $this->plugin->check();
    }
}
