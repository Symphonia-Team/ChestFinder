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
        # Creating the configuration if it is not done and updating it:
		if(file_exists($this->getDataFolder() . "config.yml")){
			$config = new Config($this->getDataFolder() . "config.yml", Config::YAML);

			if($config->get("version") != $this->getDescription()->getVersion() or !$config->exists("version")){
				$this->getLogger()->warning("Critical changes have been made in the new version of the plugin and it seem that your config.yml is a older config.");
				$this->getLogger()->warning("Your config has been updated, be careful to check the content change !");
				$this->getLogger()->warning("You can find your old config in oldConfig.yml file.");

				rename($this->getDataFolder() . "config.yml", $this->getDataFolder() . "oldConfig.yml");
				$this->saveResource("config.yml", true);
			}
		} else {
			$this->getLogger()->info("The ChestFinder config as been created !");
			$this->saveResource("config.yml");
		}

        # Register statics:
        self::$main = $this;
        self::$config = new Config($this->getDataFolder() . "config.yml", Config::YAML);

        # Register events:
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
