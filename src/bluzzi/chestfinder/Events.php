<?php

namespace bluzzi\chestfinder;

use pocketmine\event\Listener;
use pocketmine\event\player\PlayerItemHeldEvent;
use pocketmine\event\player\PlayerJoinEvent;

use pocketmine\level\format\Chunk;

use pocketmine\item\Item;

use pocketmine\Player;

use bluzzi\chestfinder\task\ChestFinder;
use bluzzi\chestfinder\Main;

class Events implements Listener {

    public $using = array();

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
        $item = Item::fromString(Main::getDefaultConfig()->get("id"));
        $name = $player->getName();

        if($itemHeld->equals($item, true, false)){
            if(empty($this->using[$name])){
                Main::getInstance()->getScheduler()->scheduleRepeatingTask(new ChestFinder($player, $this), Main::getDefaultConfig()->get("repeat") * 20);
                $this->using[$name] = true;
            }
        }
    }
}
