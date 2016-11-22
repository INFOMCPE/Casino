<?php

namespace Casino;

use pocketmine\Server;
use pocketmine\scheduler\AsyncTask;
use pocketmine\utils\Utils;
use pocketmine\Player;
use pocketmine\plugin\PluginBase;
use pocketmine\event\Listener;
use pocketmine\command\Command;
use pocketmine\command\CommandSender;
use pocketmine\item\enchantment\Enchantment;
use pocketmine\entity\Effect;
use pocketmine\item\Item;
use pocketmine\utils\Config;
use pocketmine\command\ConsoleCommandSender;
use pocketmine\player\Inventory;
use pocketmine\utils\Random;
use pocketmine\level\sound\{ClickSound, PopSound, ButtonClickSound, FizzSound, ExplodeSound, BlockPlaceSound, GenericSound, NoteblockSound, EndermanTeleportSound, BatSound};
use pocketmine\event\player\PlayerEvent;
use EconomyPlus\EconomyPlus;
use Casino\CheckVersionTask;
use Casino\UpdaterTask;

class Casino extends PluginBase Implements Listener{

public $eco; 

public function onEnable(){
       $this->getServer()->getPluginManager()->registerEvents($this, $this);
       $this->getServer()->getScheduler()->scheduleAsyncTask(new CheckVersionTask($this));
       $this->getLogger()->info("Казино работает");
       $this->saveDefaultConfig();
       $this->eco = $this->getServer()->getPluginManager()->getPlugin("EconomyAPI"); 
       $this->ecop = $this->getServer()->getPluginManager()->getPlugin("EconomyPlus"); 
       if($this->getServer()->getPluginManager()->getPlugin("EconomyAPI") != null){
               $this->eco= $this->getServer()->getPluginManager()->getPlugin("EconomyAPI");
          }
}
public function getLang(){
	    $this->data = $this->getDataFolder();
        $this->cfg = new Config($this->data . "config.yml", Config::YAML);
    	return $this->getConfig()->get("lang");
    }
public function update(){
		    $this->getServer()->getScheduler()->scheduleTask(new UpdaterTask($this, $this->getDescription()->getVersion()));
	  }
	
	public function onCommand(CommandSender $sender, Command $command, $label, array $args){
		//use Config

$cheap = $this->getConfig()->get("cheap");
$dear = $this->getConfig()->get("dear");
$rich = $this->getConfig()->get("rich");
$lang = $this->getConfig()->get("lang");
if($lang == 1){
$urlh = file_get_contents('http://infomcpe.ru/updater.php?pluginname=Casino_RU'); 
        $url = json_decode($urlh); 
        $test = $url->betting_preview;
        }
    if($lang == 2){
$urlh = file_get_contents('http://infomcpe.ru/updater.php?pluginname=Casino_EN'); 
        $url = json_decode($urlh); 
        $test = $url->betting_preview;
        } 
        if($lang == null){
$urlh = file_get_contents('http://infomcpe.ru/updater.php?pluginname=Casino_EN'); 
        $url = json_decode($urlh); 
        $test = $url->betting_preview;
        } 
   
        
if($this->getServer()->getPluginManager()->getPlugin("EconomyAPI") != null){
$moneye = $this->eco->myMoney($sender); 
               }
               if($this->getServer()->getPluginManager()->getPlugin("EconomyPlus") != null){
               	
               $moneye = EconomyPlus::getInstance()->getMoney($sender);
               }
        
            switch($command->getName()){
            	
      case "casino":
if(count($args) == 0){
$sender->sendMessage("§9§l—————§eCasino§9—————\n§6/c list - §f".$url->betting_preview."\n§6/c cheap - §f".$url->play_cheap."\n§6/c dear - §f".$url->play_dear."\n§6/c rich - §f".$url->play_rich."\n§6/c money - §f".$url->check_money."\n§9§l—————§eCasino§9—————");
}
      switch($args [0]){
     
      case "list":
      
      $sender->sendMessage("§e»§7{$url->cheap_def} - §b{$cheap} $ §7 {$url->game}\n§e»§7{$url->dear} - §b{$dear} $ §7 {$url->game}\n§e»§7{$url->rich} - §b{$rich} $ §7 {$url->game}");
     break;
      case "cheap":
      if($this->getServer()->getPluginManager()->getPlugin("EconomyAPI") != null){
$money = $this->eco->myMoney($sender); 
               }
               if($this->getServer()->getPluginManager()->getPlugin("EconomyPlus") != null){
               	
               $money = EconomyPlus::getInstance()->getMoney($sender);
               }
if($money >= $cheap){
	if($this->getServer()->getPluginManager()->getPlugin("EconomyAPI") != null){
               $this->eco->reduceMoney($sender, $cheap);
               }
               if($this->getServer()->getPluginManager()->getPlugin("EconomyPlus") != null){
               $mi =EconomyPlus::getInstance()->reduceMoney($sender, $cheap);
               $mi;
             
               }
     
$rand = array(100, 200, 300, 10, 50, 250, 1);
$money = $rand[mt_rand(2,count($rand)-1)];

	if($this->getServer()->getPluginManager()->getPlugin("EconomyAPI") != null){
		
$this->eco->addMoney($sender, $money);
               }
               if($this->getServer()->getPluginManager()->getPlugin("EconomyPlus") != null){
               $mi =EconomyPlus::getInstance()->addMoney($sender, $money);
               $mi;
             
               }
$player = $sender->getPlayer(); 

   
//$sender->sendMessage("§9[§aCasino§9]§6»§e {$url->cheap_def} \n§e♦§6 {$url->ante}:§a {$cheap}$");
$sender->sendMessage("§9[§aCasino§9]§6» §e {$url->cheap_def} \n♦ §6 {$url->ante}§a {$cheap}$");
sleep(1);
$sender->sendPopup("§9[§aCasino§9]§6»§e 1");

sleep(1);
$sender->sendPopup("§9[§aCasino§9]§6»§e 1 2");

sleep(1);
$sender->sendPopup("§9[§aCasino§9]§6»§e 1 2 3");

sleep(1);
$sender->sendPopup("§9[§aCasino§9]§6»§e 1 2 3 4");

$player->getlevel()->addSound(new FizzSound($player));
sleep(1);
$sender->sendPopup("§9[§aCasino§9]§6»§e 1 2 3 4 §45");


if($money >= $cheap){
$moneyd = $money - $cheap;
	if($this->getConfig()->get("Popup") == true){
$player->getlevel()->addSound(new ExplodeSound($player));

if($this->getServer()->getPluginManager()->getPlugin("EconomyAPI") != null){
$moneye = $this->eco->myMoney($sender); 
               }
               if($this->getServer()->getPluginManager()->getPlugin("EconomyPlus") != null){
               	
               $moneye = EconomyPlus::getInstance()->getMoney($sender);
               }

$sender->sendPopup("§9[§aCasino§9]§6» §e♦§6{$url->won}:§a {$moneyd} $\n §e{$url->bal}§a {$moneye} $");
}
if($this->getConfig()->get("Popup") == false){
	
$player->getlevel()->addSound(new ExplodeSound($player));

if($this->getServer()->getPluginManager()->getPlugin("EconomyAPI") != null){
$moneye = $this->eco->myMoney($sender); 
               }
               if($this->getServer()->getPluginManager()->getPlugin("EconomyPlus") != null){
               	
               $moneye = EconomyPlus::getInstance()->getMoney($sender);
               }
               
$sender->sendMessage("§9[§aCasino§9]§6» §e♦§6{$url->won}:§a {$moneyd} $\n §e{$url->bal}§a {$moneye} $");

}
}
if($money <= $cheap){
	$moneyd = $money - $cheap;
	if($this->getConfig()->get("Popup") == true){

$sender->sendPopup("§9[§aCasino§9]§6» §e♦§6{$url->lost}:§a {$moneyd} $\n §e{$url->bal}§a {$moneye} $");
}
if($this->getConfig()->get("Popup") == false){
	
if($this->getServer()->getPluginManager()->getPlugin("EconomyAPI") != null){
$moneye = $this->eco->myMoney($sender); 
               }
               if($this->getServer()->getPluginManager()->getPlugin("EconomyPlus") != null){
               	
               $moneye = EconomyPlus::getInstance()->getMoney($sender);
               }
$sender->sendMessage("§9[§aCasino§9]§6» §e♦§6{$url->lost}§a {$moneyd} $\n §e{$url->bal}§a {$moneye} $");
}
}
     }else{
$sender->sendMessage("§9[§aCasino§9]§6»§f{$url->nomoney}");
}
     break;
      case "money":
    if($this->getServer()->getPluginManager()->getPlugin("EconomyAPI") != null){
$money = $this->eco->myMoney($sender); 
               }
               if($this->getServer()->getPluginManager()->getPlugin("EconomyPlus") != null){
               	
               $money = EconomyPlus::getInstance()->getMoney($sender);
               }
$sender->sendMessage("§9[§aCasino§9]§6»§f{$url->you} §c{$money} $");
     break;
      case "dear":
    if($this->getServer()->getPluginManager()->getPlugin("EconomyAPI") != null){
$money = $this->eco->myMoney($sender); 
               }
               if($this->getServer()->getPluginManager()->getPlugin("EconomyPlus") != null){
               	
               $money = EconomyPlus::getInstance()->getMoney($sender);
               }
$player = $sender->getPlayer(); 
if($money >= $dear){
     if($this->getServer()->getPluginManager()->getPlugin("EconomyAPI") != null){
               $this->eco->reduceMoney($sender, $dear);
               }
               if($this->getServer()->getPluginManager()->getPlugin("EconomyPlus") != null){
               $mi =EconomyPlus::getInstance()->reduceMoney($sender, $dear);
               $mi;
             
               }
$rand = array(500,1000,100,0,300,750,50,250);
$money = $rand[mt_rand(1,count($rand)-1)];
if($this->getServer()->getPluginManager()->getPlugin("EconomyAPI") != null){
		$this->eco->addMoney($sender, $money);
               }
               if($this->getServer()->getPluginManager()->getPlugin("EconomyPlus") != null){
               $mi =EconomyPlus::getInstance()->addMoney($sender, $money);
               $mi;
             
               }
$player = $sender->getPlayer(); 
$sender->sendMessage("§9»»»»»§e".$url->dear."§9«««««\n§e♦§6".$url->ante.":§a".$dear." $");
sleep(1);
$sender->sendPopup("§9[§aCasino§9]§6»§e 1");

sleep(1);
$sender->sendPopup("§9[§aCasino§9]§6»§e 1 2");

sleep(1);
$sender->sendPopup("§9[§aCasino§9]§6»§e 1 2 3");

sleep(1);
$sender->sendPopup("§9[§aCasino§9]§6»§e 1 2 3 4");

$player->getlevel()->addSound(new FizzSound($player));
sleep(1);
$sender->sendPopup("§9[§aCasino§9]§6»§e 1 2 3 4 §45");


if($money >= $dear){
$moneyd = $money - $dear;
	if($this->getConfig()->get("Popup") == true){
$player->getlevel()->addSound(new ExplodeSound($player));

    if($this->getServer()->getPluginManager()->getPlugin("EconomyAPI") != null){
$moneye = $this->eco->myMoney($sender); 
               }
               if($this->getServer()->getPluginManager()->getPlugin("EconomyPlus") != null){
               	
               $moneye = EconomyPlus::getInstance()->getMoney($sender);
               }

$sender->sendPopup("§9[§aCasino§9]§6» §e♦§6{$url->won}:§a {$moneyd} $\n §e{$url->bal}§a {$moneye} $");
}
if($this->getConfig()->get("Popup") == false){
	
$player->getlevel()->addSound(new ExplodeSound($player));
    if($this->getServer()->getPluginManager()->getPlugin("EconomyAPI") != null){
$moneye = $this->eco->myMoney($sender); 
               }
               if($this->getServer()->getPluginManager()->getPlugin("EconomyPlus") != null){
               	
               $moneye = EconomyPlus::getInstance()->getMoney($sender);
               }
$sender->sendMessage("§9[§aCasino§9]§6» §e♦§6{$url->won}:§a {$moneyd} $\n §e{$url->bal}§a {$moneye} $");
}
}
if($money <= $dear){
	$moneyd = $money - $dear;
	if($this->getConfig()->get("Popup") == true){

if($this->getServer()->getPluginManager()->getPlugin("EconomyAPI") != null){
$moneye = $this->eco->myMoney($sender); 
               }
               if($this->getServer()->getPluginManager()->getPlugin("EconomyPlus") != null){
               	
               $moneye = EconomyPlus::getInstance()->getMoney($sender);
               }

$sender->sendPopup("§9[§aCasino§9]§6» §e♦§6{$url->lost}:§a {$moneyd} $\n §e{$url->bal}§a {$moneye} $");
}
if($this->getConfig()->get("Popup") == false){
	
if($this->getServer()->getPluginManager()->getPlugin("EconomyAPI") != null){
$moneye = $this->eco->myMoney($sender); 
               }
               if($this->getServer()->getPluginManager()->getPlugin("EconomyPlus") != null){
               	
               $moneye = EconomyPlus::getInstance()->getMoney($sender);
               }
$sender->sendMessage("§9[§aCasino§9]§6» §e♦§6{$url->lost}:§a {$moneyd} $\n §e{$url->bal}§a {$moneye} $");
}
}
     }else{
$sender->sendMessage("§9[§aCasino§9]§6»§f{$url->nomoney}");
}
     break;
      case "rich":
if($this->getServer()->getPluginManager()->getPlugin("EconomyAPI") != null){
$money = $this->eco->myMoney($sender); 
               }
               if($this->getServer()->getPluginManager()->getPlugin("EconomyPlus") != null){
               	
               $money = EconomyPlus::getInstance()->getMoney($sender);
               }
$player = $sender->getPlayer(); 
if($money >= $rich){
     
	if($this->getServer()->getPluginManager()->getPlugin("EconomyAPI") != null){
               $this->eco->reduceMoney($sender, $rich);
               }
               if($this->getServer()->getPluginManager()->getPlugin("EconomyPlus") != null){
               $mi =EconomyPlus::getInstance()->reduceMoney($sender, $rich);
               $mi;
             
               }
     
$rand = array(500,1000,100,0,300,750,50,250,900,2000,1250,1150);
$money = $rand[mt_rand(1,count($rand)-1)];

if($this->getServer()->getPluginManager()->getPlugin("EconomyAPI") != null){
		$this->eco->addMoney($sender, $money);
               }
               if($this->getServer()->getPluginManager()->getPlugin("EconomyPlus") != null){
               $mi =EconomyPlus::getInstance()->addMoney($sender, $money);
               $mi;
             
               }
 
$sender->sendMessage("§9»»»»»§e".$url->rich."§9«««««\n§e♦§6".$url->ante.":§a ".$rich."$"); 
sleep(1);
$sender->sendPopup("§9[§aCasino§9]§6»§e 1");
sleep(1);
$sender->sendPopup("§9[§aCasino§9]§6»§e 1 2");
sleep(1);
$sender->sendPopup("§9[§aCasino§9]§6»§e 1 2 3");
sleep(1);
$sender->sendPopup("§9[§aCasino§9]§6»§e 1 2 3 4");

$player->getlevel()->addSound(new FizzSound($player));
sleep(1);
$sender->sendPopup("§9[§aCasino§9]§6»§e 1 2 3 4 §45");


if($money >= $rich){
$moneyd = $money - $rich;
	if($this->getConfig()->get("Popup") == true){
$player->getlevel()->addSound(new ExplodeSound($player));
if($this->getServer()->getPluginManager()->getPlugin("EconomyAPI") != null){
$moneye = $this->eco->myMoney($sender); 
               }
               if($this->getServer()->getPluginManager()->getPlugin("EconomyPlus") != null){
               	
               $moneye = EconomyPlus::getInstance()->getMoney($sender);
               }

$sender->sendPopup("§9[§aCasino§9]§6» §e♦§6{$url->won}:§a {$moneyd} $\n §e{$url->bal}§a {$moneye} $");
}
if($this->getConfig()->get("Popup") == false){
	
$player->getlevel()->addSound(new ExplodeSound($player));

if($this->getServer()->getPluginManager()->getPlugin("EconomyAPI") != null){
$moneye = $this->eco->myMoney($sender); 
               }
               if($this->getServer()->getPluginManager()->getPlugin("EconomyPlus") != null){
               	
               $moneye = EconomyPlus::getInstance()->getMoney($sender);
               }
$sender->sendMessage("§9[§aCasino§9]§6» §e♦§6{$url->won}:§a {$moneyd} $\n §e{$url->bal}§a {$moneye} $");
}
}
if($this->getServer()->getPluginManager()->getPlugin("EconomyAPI") != null){
$moneye = $this->eco->myMoney($sender); 
               }
               if($this->getServer()->getPluginManager()->getPlugin("EconomyPlus") != null){
               	
               $moneye = EconomyPlus::getInstance()->getMoney($sender);
               }
if($money <= $rich){
	$moneyd = $money - $rich;
	if($this->getConfig()->get("Popup") == true){


if($this->getServer()->getPluginManager()->getPlugin("EconomyAPI") != null){
$moneye = $this->eco->myMoney($sender); 
               }
               if($this->getServer()->getPluginManager()->getPlugin("EconomyPlus") != null){
               	
               $moneye = EconomyPlus::getInstance()->getMoney($sender);
               }

$sender->sendPopup("§9[§aCasino§9]§6» §e♦§6{$url->lost}:§a {$moneyd} $\n §e{$url->bal}§a {$moneye} $");
}
if($this->getConfig()->get("Popup") == false){
	

if($this->getServer()->getPluginManager()->getPlugin("EconomyAPI") != null){
$moneye = $this->eco->myMoney($sender); 
               }
               if($this->getServer()->getPluginManager()->getPlugin("EconomyPlus") != null){
               	
               $moneye = EconomyPlus::getInstance()->getMoney($sender);
               }
$sender->sendMessage("§9[§aCasino§9]§6» §e♦§6{$url->lost}:§a {$moneyd} $\n §e{$url->bal}§a {$moneye} $");
}
}
     }else{
$sender->sendMessage("§9[§aCasino§9]§6»§f{$url->nomoney}");
}
     break;
        }
         
     }
  }
}
