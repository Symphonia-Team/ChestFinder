<?php

namespace bluzzi\chestfinder;

use pocketmine\event\Listener;
use pocketmine\event\player\PlayerItemHeldEvent;
use pocketmine\event\player\PlayerJoinEvent;
use pocketmine\item\Item;
use pocketmine\item\LegacyStringToItemParser;
use pocketmine\player\Player;
use bluzzi\chestfinder\task\ChestFinder;

class Events implements Listener {

	public $using = array();

	public function onJoin(PlayerJoinEvent $event) : void {
		$this->checkAndStart($event->getPlayer(), $event->getPlayer()->getInventory()->getItemInHand());
	}

	public function onHeld(PlayerItemHeldEvent $event) : void {
		$this->checkAndStart($event->getPlayer(), $event->getItem());
	}

	/**
	 * Check if the item in the player's hand matches the ChestFinder item and start the ChestFinder task.
	 * @param Player $player
	 * @param Item $itemHeld
	 * @return void
	 */
	private function checkAndStart(Player $player, Item $itemHeld) : void {
		// I use LegacyStringToItemParser instead of StringToItemParser because, the option of before (StringToItemParser) takes only with the minecraft: or _ character, while the Legacy version with the ID:META
		$item = LegacyStringToItemParser::getInstance()->parse(Main::getDefaultConfig()->get("id"));
		$name = $player->getName();

		if($itemHeld->equals($item, true, false)){
			if(empty($this->using[$name])){
				Main::getInstance()->getScheduler()->scheduleRepeatingTask(new ChestFinder($player, $this), Main::getDefaultConfig()->get("repeat") * 20);
				
				$this->using[$name] = true;
			}
		}
	}
}
