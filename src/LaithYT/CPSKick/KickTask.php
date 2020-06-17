<?php

namespace LaithYT\CPSKick;

/*  Copyright (2018 - 2020) (C) LaithYoutuber 
 *
 * Plugin By LaithYT , Gihhub:                                                                           
 *                                                                                                      
 *		88  		8855555555	88888889888	888888888888 88			88	 88888888888'8	888888888888'8  
 *		88			88		88		88			88		 88			88	 88		 	88	88			88  
 *		88			88		88		88			88	   	 88			88	 88			88	88			88  
 *		88			88		88		88			88		 88			88	 88			88	88			88  
 *		88			88		88		88			88		 88			88	 88			88	88			88  
 *		88			8855555588		88			88		 8855555555588   8888888855553	88555555555588	
 *		88			88		88		88			88		 88			88	 			88	88			88  
 *		88			88		88		88			88		 88			88	 			88	88			88  
 *		88			88		88		88			88		 88			88				88	88			88 
 *		85      	88		88		88			88		 88			88				88	88			88  
 *		8855555555	88		88	88888889888		88		 88			88   5555555555588	88888888888888  
 *		                                                                                                
 *		Youtube: Laith Youtuber                                                                         
 *		Facebook: Laith A Al Haddad                                                                     
 *		Discord: Laith.97#8167    
 *       
 *      Hey I'am used Code getCPS From Plugin CPS Author JackMD thx 
 *      github: https://github.com/JackMD/CPS
 *
 */

use pocketmine\scheduler\Task;

use pocketmine\Player;
use pocketmine\Server;

use pocketmine\utils\TextFormat as TF;
use pocketmine\utils\Config;

use LaithYT\CPSKick\Main;

class KickTask extends Task
{
	/* @var Main */
	public $plugin;
	
	/* @var config */
	public $cfg;
	
	public function __construct(Main $p){
	 	 $this->plugin = $p;
		 $this->cfg = new Config($this->plugin->getDataFolder() . "config.yml", Config::YAML);
	}
	 
	public function onRun(int $tick){
		foreach($this->plugin->getServer()->getOnlinePlayers() as $player){
			$maxcps = $this->cfg->get("MAX_CPS_KICK");
			$pcps = $this->plugin->getClicks($player);
			$Reason = $this->cfg->get("Reason");
			if($pcps >= $maxcps){
				$player->getPlayer()->kick(" " . $Reason);
			}
		}
	}
}
