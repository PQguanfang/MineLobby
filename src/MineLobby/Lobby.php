<?php

namespace Lobby;

use pocketmine\plugin\PluginBase;
use pocketmine\event\Listener;
use pocketmine\lang\BaseLang;
use pocketmine\scheduler\Task;
use pocketmine\Player;
use pocketmine\item\Item;
use pocketmine\math\Vector3;
use pocketmine\utils\Config;
use pocketmine\command\ConsoleCommandSender;
use pocketmine\command\CommandSender;
use pocketmine\command\Command;
use pocketmine\event\player\PlayerInteractEvent;
use pocketmine\event\player\PlayerJoinEvent;
use pocketmine\event\player\PlayerQuitEvent;
use pocketmine\nbt\tag\FloatTag;
use pocketmine\nbt\tag\CompoundTag;
use pocketmine\nbt\tag\DoubleTag;
use pocketmine\nbt\tag\ListTag;
use pocketmine\entity\Entity;
use pocketmine\event\entity\ExplosionPrimeEvent;
use pocketmine\event\entity\EntityDamageEvent;
use pocketmine\entity\Effect;
use pocketmine\entity\EffectInstance;
use pocketmine\event\block\BlockBreakEvent;
use pocketmine\event\block\BlockPlaceEvent;
use pocketmine\event\player\PlayerExhaustEvent;
use pocketmine\event\player\PlayerDropItemEvent;
use pocketmine\event\player\PlayerItemConsumeEvent;
use pocketmine\level\sound\AnvilUseSound;
use pocketmine\level\sound\EndermanTeleportSound;
use pocketmine\utils\Textformat as Color;

class Lobby extends PluginBase implements Listener {
    public $prefix = "§7[§9Mine§6Lobby§7]";
    public $hideall = [];

    public function onJoin(PlayerJoinEvent $ev) {
		
        $player = $ev->getPlayer();
        $name = $player->getName();
        $player->getInventory()->clearAll();
        $ev->setJoinMessage("§7[§9+§7]" . Color::DARK_GRAY . $name);
        $player->setFood(20);
        $player->setHealth(20);
        $player->setGamemode(2);
        $player->getlevel()->addSound(new AnvilUseSound($player));
        $player->teleport($this->getServer()->getDefaultLevel()->getSafeSpawn());
        $player->sendMessage($config->get("Join"));
        $player->getInventory()->setSize(9);
        $player->getInventory()->setItem(7, Item::get(339)->setCustomName("§aT"));
        $player->getInventory()->setItem(0, Item::get(345)->setCustomName("§eN"));
        $player->getInventory()->setItem(2, Item::get(399)->setCustomName("§5L"));
        $player->getInventory()->setItem(6, Item::get(388)->setCustomName("§2D"));
        $player->getInventory()->setItem(8, Item::get(54)->setCustomName("§aG"));
        if($player->hasPermission("lobby.yt")){
            $player->getInventory()->setItem(4, Item::get(288)->setCustomName("§fFly"));
        }else{
            $player->getInventory()->setItem(4, Item::get(152)->setCustomName("§fFly §7[§6Premium§7]"));
        }
        $player->getInventory()->setItem(1, Item::get(369)->setCustomName("§eEMM §8[§cOff§8]"));
    }
