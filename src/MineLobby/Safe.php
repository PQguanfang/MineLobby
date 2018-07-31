<?php

namespace MineLobby;

use pocketmine\plugin\PluginBase;
use pocketmine\event\Listener;
use pocketmine\level\Position;
use pocketmine\level\Level;
use pocketmine\Player;
use pocketmine\entity\Entity;
use pocketmine\math\Vector3;
use pocketmine\event\player\PlayerMoveEvent;
    
class Safe extends PluginBase implements Listener{

       public function onVoidDamage(EntityDamageEvent $event): void
        {
            $entity = $event->getEntity();
            if ($entity instanceof Player) {
                if ($entity->getPosition()->getY() < 0) {
                    $event->setCancelled(true);
                    $entity->teleport($this->getServer()->getDefaultLevel()->getSafeSpawn());
                    $event->getPlayer()->sendMessage(TF::AQUA . "您已被传送回主城");
                }
            }
        }
    }
