<?php

namespace bluzzi\chestfinder\task;

use pocketmine\block\tile\Chest;
use pocketmine\block\VanillaBlocks;
use pocketmine\item\LegacyStringToItemParser;
use pocketmine\player\Player;
use pocketmine\scheduler\Task;
use bluzzi\chestfinder\Main;
use bluzzi\chestfinder\Events;

class ChestFinder extends Task {

	public function __construct(private Player $player, private Events $event){}

	public function onRun() : void {
		if(!($this->player->isOnline())){
			unset($this->event->using[$this->player->getName()]);
			$this->getHandler()->cancel();
			return;
		}

		$itemHeld = $this->player->getInventory()->getItemInHand();

		// I use LegacyStringToItemParser instead of StringToItemParser because, the option of before (StringToItemParser) takes only with the minecraft: or _ character, while the Legacy version with the ID:META
		$item = LegacyStringToItemParser::getInstance()->parse(Main::getDefaultConfig()->get("id"));

		if(!($itemHeld->equals($item, true, false))){
			unset($this->event->using[$this->player->getName()]);
			$this->getHandler()->cancel();
			return;
		}

		# Chests detection:
		$chestCount = 0;

		$radius = Main::getDefaultConfig()->get("radius");

		$xMax = $this->player->getPosition()->getX() + $radius;
		$zMax = $this->player->getPosition()->getZ() + $radius;

		for($x = $this->player->getPosition()->getX() - $radius; $x <= $xMax; $x += 16){
			for($z = $this->player->getPosition()->getZ() - $radius; $z <= $zMax; $z += 16){
				if(!$this->player->getPosition()->getWorld()->isChunkLoaded($x >> 4, $z >> 4)){
					$this->player->getPosition()->getWorld()->loadChunk($x >> 4, $z >> 4);
				} else {
					$chunk = $this->player->getPosition()->getWorld()->getChunk($x >> 4, $z >> 4);

					foreach($chunk->getTiles() as $tile){
						if (!in_array($tile->getBlock()->getId() == VanillaBlocks::TRAPPED_CHEST()->getId() ? "TrappedChest" : $tile::class, Main::$detects)) continue;

						if($this->player->getPosition()->distance($tile->getBlock()->getPosition()->asVector3()) <= Main::getDefaultConfig()->get("radius")){
							if(empty($theChest)){
								$theChest = $tile;
							} else {
								if($this->player->getPosition()->distance($tile->getBlock()->getPosition()->asVector3()) < $this->player->getPosition()->distance($theChest->getPosition()->asVector3())){
									$theChest = $tile;
								}
							}

							$chestCount++;
						}
					}
				}
			}
		}

		# Send popup message:
		if($chestCount !== 0){
			$message = str_replace(
				array("{chestCount}", "{chestDistance}", "{lineBreak}"),
				array($chestCount, round($this->player->getPosition()->distance($theChest->getBlock()->getPosition()->asVector3())), "\n"), // Not PHP_EOL, because make a character  ō
				Main::getDefaultConfig()->get("chest-detected")
			);
		} else {
			$message = Main::getDefaultConfig()->get("no-chest");
		}

		switch(Main::getDefaultConfig()->get("message-position")){
			case "tip":
				$this->player->sendTip($message . str_repeat("\n", 3));
			break;

			case "title":
				$this->player->sendTitle(" ", $message);
			break;

			default:
				$this->player->sendPopup($message);
			break;
		}
	}
}
