<?php

namespace bluzzi\chestfinder;

use pocketmine\event\Listener;
use pocketmine\event\player\PlayerItemHeldEvent;
use pocketmine\event\player\PlayerJoinEvent;
use pocketmine\event\level\ChunkLoadEvent;
use pocketmine\event\block\BlockPlaceEvent;
use pocketmine\event\block\BlockBreakEvent;

use pocketmine\item\Item;

use pocketmine\Player;

use pocketmine\utils\Config;

use bluzzi\chestfinder\ChestFinder;

class Events implements Listener {

    private $plugin;

    public $using = array();

    public function __construct($plugin){
        $this->plugin = $plugin;
    }

    public function onHeld(PlayerItemHeldEvent $event){
        $this->checkAndStart($event->getPlayer(), $event->getItem());
    }

    public function onJoin(PlayerJoinEvent $event){
        $this->checkAndStart($event->getPlayer(), $event->getPlayer()->getInventory()->getItemInHand());
    }

    public function onChunkLoad(ChunkLoadEvent $event){
        $chunk = $event->getChunk();

        foreach($chunk->getTiles() as $tile){
            if($tile instanceof \pocketmine\tile\Chest){
                array_push($this->plugin->chests, $tile);
            }
        }
    }

    public function onPlace(BlockPlaceEvent $event){
        $block = $event->getBlock();

        if($block instanceof \pocketmine\block\Chest){
            array_push($this->plugin->chests, $block);
        }
    }

    public function onBreak(BlockBreakEvent $event){
        $block = $event->getBlock();

        if($block instanceof \pocketmine\block\Chest){
            $key = array_search($block, $this->plugin->chests);
            unset($this->plugin->chests[$key]);
        }
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
