<?php

namespace bluzzi\chestfinder;

use pocketmine\event\Listener;
use pocketmine\event\player\PlayerItemHeldEvent;
use pocketmine\event\player\PlayerJoinEvent;
use pocketmine\event\level\ChunkLoadEvent;
use pocketmine\event\block\BlockPlaceEvent;
use pocketmine\event\block\BlockBreakEvent;

use pocketmine\level\format\Chunk;

use pocketmine\item\Item;

use pocketmine\Player;

use pocketmine\utils\Config;

use bluzzi\chestfinder\task\ChestFinder;
use bluzzi\chestfinder\task\ReloadChunkChests;

class Events implements Listener {

    private $plugin;

    public $using = array();

    public function __construct($plugin){
        $this->plugin = $plugin;
    }

    public function onJoin(PlayerJoinEvent $event){
        $this->checkAndStart($event->getPlayer(), $event->getPlayer()->getInventory()->getItemInHand());
    }

    public function onHeld(PlayerItemHeldEvent $event){
        $this->checkAndStart($event->getPlayer(), $event->getItem());
    }

    /**
     * Check if the item in the player's hand matches the ChestFinder item and start the ChestFinder task.
     * @param Player $player
     * @return void
     */
    private function checkAndStart(Player $player, Item $itemHeld) : void {
        $item = Item::fromString($this->plugin->config->get("id"));
        $name = $player->getName();

        if($itemHeld->equals($item, true, false)){
            if(empty($this->using[$name])){
                $this->plugin->getScheduler()->scheduleRepeatingTask(new ChestFinder($player, $this->plugin, $this), $this->plugin->config->get("repeat") * 20);
                $this->using[$name] = true;
            }
        }
    }
}
