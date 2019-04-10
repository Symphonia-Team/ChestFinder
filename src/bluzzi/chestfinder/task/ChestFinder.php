<?php

namespace bluzzi\chestfinder\task;

use pocketmine\scheduler\Task;

use pocketmine\Player;

use pocketmine\item\Item;;

use pocketmine\tile\Chest;

use pocketmine\utils\Config;

class ChestFinder extends Task {

    private $player;
    private $event;
    private $plugin;

    public function __construct(Player $player, $plugin, $event){
        $this->player = $player;
        $this->plugin = $plugin;
        $this->event = $event;
    }

    public function onRun(int $tick){
        if(!($this->player->isOnline())){
            unset($this->event->using[$this->player->getName()]);
            $this->plugin->getScheduler()->cancelTask($this->getTaskId());
            return;
        }

        $itemHeld = $this->player->getInventory()->getItemInHand();
        $item = Item::fromString($this->plugin->config->get("id"));

        if(!($itemHeld->equals($item, true, false))){
            unset($this->event->using[$this->player->getName()]);
            $this->plugin->getScheduler()->cancelTask($this->getTaskId());
            return;
        }

        //Chests detection:
        $chestCount = 0;
        $theChest;

        $radius = $this->plugin->config->get("radius");

        $xMax = $this->player->getX() + $radius;
        $zMax = $this->player->getZ() + $radius;

        for($x = $this->player->getX() - $radius; $x <= $xMax; $x += 16){
            for($z = $this->player->getZ() - $radius; $z <= $zMax; $z += 16){
                $chunk = $this->player->getLevel()->getChunk($x >> 4, $z >> 4);

                if(!$this->player->getLevel()->isChunkLoaded($x >> 4, $z >> 4)){
                    $this->player->getLevel()->laodChunk($x >> 4, $z >> 4);
                }
                
                foreach($chunk->getTiles() as $tile){
                    if(!$tile instanceof Chest) continue;

                    if($this->player->distance($tile) <= $this->plugin->config->get("radius")){
                        if(empty($theChest)){
                            $theChest = $tile;
                        } else {
                            if($this->player->distance($tile) < $this->player->distance($theChest)){
                                $theChest = $tile;
                            }
                        }
        
                        $chestCount++;
                    }
                }
            }
        }

        //Send popup message:
        if($chestCount !== 0){
            $replace = array(
                "{chestCount}" => $chestCount,
                "{chestDistance}" => round($this->player->distance($theChest), 0),
                "{lineBreak}" => "\n"
            );

            $message = $this->plugin->config->get("chest-detected");

            foreach($replace as $key => $value){
                $message = str_replace($key, $value, $message);
            }

            $this->player->sendPopup($message);
        } else {
            $this->player->sendPopup($this->plugin->config->get("no-chest"));
        }
    }
}
