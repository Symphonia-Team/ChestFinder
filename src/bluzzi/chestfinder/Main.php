<?php

namespace bluzzi\chestfinder;

use pocketmine\plugin\PluginBase;

use pocketmine\Server;

use pocketmine\utils\Config;

use bluzzi\chestfinder\Events;

class Main extends PluginBase {
    
    public $chests = [];
    /** @var $config instance of plugin config */
    public static $config;

    public function onEnable(){
        if(!file_exists($this->getDataFolder() . "config.yml")){
            $this->saveResource("config.yml");
        }

        self::$config = new Config($this->getDataFolder() . "config.yml", Config::YAML);

        Server::getInstance()->getPluginManager()->registerEvents(new Events($this), $this);
    }

    /**
     * Return instance of plugin config.
     * @return Config
     */
    public static function getConfig() : Config {
        return self::$config;
    }
}
