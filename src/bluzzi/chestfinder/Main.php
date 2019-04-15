<?php

namespace bluzzi\chestfinder;

use pocketmine\plugin\PluginBase;

use pocketmine\Server;

use pocketmine\utils\Config;

use bluzzi\chestfinder\Events;

class Main extends PluginBase {

    /** @var $main, $config instances */
    public static $main, $config;

    public function onEnable(){
        if(!file_exists($this->getDataFolder() . "config.yml")){
            $this->saveResource("config.yml");
        }

        self::$main = $this;
        self::$config = new Config($this->getDataFolder() . "config.yml", Config::YAML);

        Server::getInstance()->getPluginManager()->registerEvents(new Events(), $this);
    }

    /**
     * Return Main instance.
     * @return Main
     */
    public static function getInstance() : Main {
        return self::$main;
    }

    /**
     * Return instance of plugin config.
     * @return Config
     */
    public static function getDefaultConfig() : Config {
        return self::$config;
    }
}
