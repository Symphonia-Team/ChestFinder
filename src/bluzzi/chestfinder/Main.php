<?php

namespace bluzzi\chestfinder;

use pocketmine\plugin\PluginBase;

use pocketmine\Server;

use pocketmine\utils\Config;

use bluzzi\chestfinder\Events;

class Main extends PluginBase {
    
    public $config;
    public $chests = [];

    public function onEnable(){
        if(!file_exists($this->getDataFolder() . "config.yml")){
            $this->saveResource("config.yml");
        }

        $this->config = new Config($this->getDataFolder() . "config.yml", Config::YAML);

        Server::getInstance()->getPluginManager()->registerEvents(new Events($this), $this);
    }
}
