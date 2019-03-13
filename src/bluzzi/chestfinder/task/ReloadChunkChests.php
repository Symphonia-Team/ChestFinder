<?php

namespace bluzzi\chestfinder\task;

use pocketmine\scheduler\Task;

class ReloadChunkChests extends Task {

    private $event;
    private $chunk;

    public function __construct($event, $chunk){
        $this->event = $event;
        $this->chunk = $chunk;
    }

    public function onRun(int $tick){
        $this->event->reloadChunkChests($this->chunk);
    }
}