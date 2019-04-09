<?php

declare(strict_types=1);

namespace jkorn\pvpcore;

/**
 * Created by PhpStorm.
 * User: jkorn2324
 * Date: 2019-04-04
 * Time: 16:06
 */

use pocketmine\event\Listener;
use pocketmine\event\entity\EntityDamageByEntityEvent;
use pocketmine\Player;

class PvPCoreListener implements Listener
{
    private $theCore;

    /**
     * PvPCoreListener constructor.
     * @param PvPCore $core
     */
    public function __construct(PvPCore $core)
    {
        $this->theCore = $core;
    }

    /**
     * @param EntityDamageByEntityEvent $event
     */
    public function onEntityDamage(EntityDamageByEntityEvent $event) : void {
        $damager = $event->getDamager(); $damaged = $event->getEntity();
        if($damaged instanceof Player and $damager instanceof Player){
            $lvl = $damaged->getLevel();
            $world = PvPCore::getWorldHandler()->getWorldFromLevel($lvl);
            if(!is_null($world)){
                $useCustomKB = $world->hasCustomKB();
                $time = $world->getAttackDelayTime();
                $knockback = $event->getKnockBack();
                if($useCustomKB){
                    $knockback = $world->getKnockBack();
                    $event->setAttackCooldown($time);
                }
                $event->setKnockBack($knockback);
            }
        }
    }
}