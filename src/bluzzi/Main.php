<?php

namespace bluzzi;

use pocketmine\plugin\PluginBase;

use pocketmine\Server;

use pocketmine\utils\Config;

use bluzzi\Events;

class Main extends PluginBase {
    
    public $config;

    public function onEnable(){
        if(!file_exists($this->getDataFolder() . "config.yml")){
            $this->saveResource("config.yml");
        }

        $this->config = new Config($this->getDataFolder() . "config.yml", Config::YAML);

        Server::getInstance()->getPluginManager()->registerEvents(new Events($this), $this);
    }
}
