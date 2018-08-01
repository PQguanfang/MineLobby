<?php

namespace MineLobby;

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
        $player->getInventory()->setItem(7, Item::get(339)->setCustomName("§a选择玩法"));
        $player->getInventory()->setItem(0, Item::get(345)->setCustomName("§e切换大厅"));
        $player->getInventory()->setItem(2, Item::get(399)->setCustomName("§5个性效果"));
        $player->getInventory()->setItem(6, Item::get(388)->setCustomName("§2大厅玩具"));
        $player->getInventory()->setItem(8, Item::get(54)->setCustomName("§a活动"));
        if($player->hasPermission("lobby.yt")){
            $player->getInventory()->setItem(4, Item::get(288)->setCustomName("§f开启/关闭飞行"));
	    $player->getInventory()->setItem(1, Item::get(369)->setCustomName("§e隐藏/显示玩家"));
        }else{
            $player->getInventory()->setItem(4, Item::get(152)->setCustomName("§f开启/关闭飞行 §7[§6VIP§7]"));
            $player->getInventory()->setItem(1, Item::get(369)->setCustomName("§e隐藏/显示玩家 §8[§6VIP§8]"));
	}
    }
	
    public function onBreak(BlockBreakEvent $ev) {
		
        $player = $ev->getPlayer();
        $ev->setCancelled(true);
    }

    public function onPlace(BlockPlaceEvent $ev) {
        $player = $ev->getPlayer();
        $ev->setCancelled(true);
    }
	
    public function Hunger(PlayerExhaustEvent $ev) {
        $ev->setCancelled(true);
    }
	
    public function ItemMove(PlayerDropItemEvent $ev){
        $ev->setCancelled(true);
    }
	
    public function onConsume(PlayerItemConsumeEvent $ev){
        $ev->setCancelled(true);
    }
	
    public function onDamage(EntityDamageEvent $ev){
        if($ev->getCause() === EntityDamageEvent::CAUSE_FALL){
            $ev->setCancelled(true);
        }
    }
	
    public function onInteract(PlayerInteractEvent $ev){
        $player = $ev->getPlayer();
        $item = $ev->getItem();

	if($item->getCustomName() == "§a选择玩法"){
	    $player->getInventory()->clearAll();
            $player->getInventory()->setSize(9);
            $player->getInventory()->setItem(0, Item::get(138)->setCustomName("§a纯净生存"));
            $player->getInventory()->setItem(1, Item::get(2)->setCustomName("§6模组生存"));
            $player->getInventory()->setItem(2, Item::get(35)->setCustomName("§1RPG§4生存"));
            $player->getInventory()->setItem(6, Item::get(355, 14)->setCustomName("§c小游戏"));
            $player->getInventory()->setItem(8, Item::get(267)->setCustomName("§4创造地皮"));
            $player->getInventory()->setItem(7, Item::get(399)->setCustomName("§2返回主城"));
            $player->getInventory()->setItem(4, Item::get(351, 1)->setCustomName("§c返回上一级"));
		
