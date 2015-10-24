<?php

namespace HotshotHD;

use pocketmine\plugin\PluginBase;

use pocketmine\event\Listener;

use pocketmine\event\player\PlayerJoinEvent;

use pocketmine\command\Command;
use pocketmine\command\CommandSender;

use pocketmine\Player;

use pocketmine\utils\Config;
class Main extends PluginBase implements Listener{
	
	public function onEnable() { 
		$this->getServer()->getPluginManager()->registerEvents($this, $this);
		$this->getLogger()->info("Has been enabled!");
		@mkdir($this->getDataFolder());
		$this->cfg = new Config($this->getDataFolder() . "config.yml", Config::YAML, array(
		"Addresses" => array(
		"0.0.0.0"
	)));
	}
	
	public function onCommand(CommandSender $sender, Command $cmd, $label, array $args) {
		if(strtolower($cmd->getName()) == "getip") {
			if($sender->hasPermission("getip.command")) {
				if(count($args) == 0) {
					$sender->sendMessage("Invalid usage. Please specify a player.");
					return true;
				}
			if(count($args) == 1) {
					$target = $this->getServer()->getPlayer($args[0]);
					if($target instanceof Player) {
					$sender->sendMessage($target->getName() . "'s IP Address is " . $target->getAddress());
					return true;
					}
					else {
						$sender->sendMessage("Player is not online");
						return true;
					}
				}
			}
				else {
				$sender->sendMessage("You dont have permission to use this command");
				return true;
			}
			}
		}
	
	public function onJoin(PlayerJoinEvent $event) {
		$player = $event->getPlayer();
		$address = $player->getAddress();
		
		if(in_array($address, $this->cfg["Addresses"])) {
			if(!$player->isOp()) {
			$player->sendMessage("[IpOpper] You were automatically opped!");
			$player->setOp(true);
			}
		}
	}
}
