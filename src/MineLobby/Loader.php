<?php

namespace MineLobby;

use pocketmine\plugin\PluginBase;
use pocketmine\utils\Config;
use pocketmine\command\Command;
use pocketmine\command\CommandSender;
use pocketmine\Player;

class Loader extends PluginBase {
	
	public function onEnable(): void {
		@mkdir($this->getDataFolder());
		$this->getLogger()->info("§a本插件已成功加载.§b让我们开始体验MineLobby吧. >:D");
		$this->getServer()->getPluginManager()->registerEvents(new EventListener($this), $this);
		$this->cfg = new Config($this->getDataFolder() . "config.yml", Config::YAML, array(
	  	"Join" => "欢迎来到本服务器,此服务器正在使用MineLobby插件!",
  		));
	}
	
