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

use pocketmine\Player;
use pocketmine\Server;

use pocketmine\plugin\PluginBase;
use pocketmine\event\Listener;

use pocketmine\utils\TextFormat as TF;
use pocketmine\utils\Config;

use LaithYT\CPSKick\KickTask;

class Main extends PluginBase {
	
	/** @var array */
	public $clicks;
	
	public $defualtcps = 30;
	
	public function onEnable(){
		@mkdir($this->getDataFolder());
		
		foreach ($this->getResources() as $resource) {
            $this->saveResource($resource->getFilename());
		}
		
		$this->getServer()->getPluginManager()->registerEvents(new AddClicksEvent($this), $this);
		
		$this->getScheduler()->scheduleRepeatingTask(new KickTask($this), 20);
		
		$this->inItConfig();
	}
	
	public function inItConfig(){
		$c = new Config($this->getDataFolder() . "config.yml", Config::YAML, [
		"MAX_CPS_KICK" => $this->defualtcps,
		"Reason" => "you got a kick because use auto clicker"
		]);
		
		$cps = $c->get("MAX_CPS_KICK");
		$reason = $c->get("Reason");
		if(!is_numeric($cps)){
			$c->set("MAX_CPS_KICK", $this->defualtcps);
			$c->save();
			error_log("Max CPS Kick is not a number, has been set defualt 30");
		} else {
			if(empty($cps) or $cps == null){
				$c->set("MAX_CPS_KICK", $this->defualtcps);
				$c->save();
			}
			
			if(empty($reason) or $reason == null){
				$c->set("Reason", "you got a kick because use auto clicker");
				$c->save();
			}
		}
	}
	
	/**
	 * @param Player $player
	 * @return int
	 */
	public function getClicks(Player $player): int{
		if(!isset($this->clicks[$player->getLowerCaseName()])){
			return 0;
		}
		$time = $this->clicks[$player->getLowerCaseName()][0];
		$clicks = $this->clicks[$player->getLowerCaseName()][1];
		if($time !== time()){
			unset($this->clicks[$player->getLowerCaseName()]);
			return 0;
		}
		return $clicks;
	}
	
	/**
	 * @param Player $player
	 */
	public function addClick(Player $player): void{
		if(!isset($this->clicks[$player->getLowerCaseName()])){
			$this->clicks[$player->getLowerCaseName()] = [time(), 0];
		}
		$time = $this->clicks[$player->getLowerCaseName()][0];
		$clicks = $this->clicks[$player->getLowerCaseName()][1];
		if($time !== time()){
			$time = time();
			$clicks = 0;
		}
		$clicks++;
		$this->clicks[$player->getLowerCaseName()] = [$time, $clicks];
	}
	
}
