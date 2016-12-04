<?php

namespace Casino;

use pocketmine\Server;
use pocketmine\scheduler\AsyncTask;
use pocketmine\utils\Utils;
use pocketmine\network\protocol\Info;
use pocketmine\Player;
use pocketmine\level\Level;
use pocketmine\block\Block;
use pocketmine\plugin\PluginBase;
use pocketmine\event\Listener;
use pocketmine\math\Vector3;
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
use pocketmine\event\player\PlayerInteractEvent;
use pocketmine\event\block\SignChangeEvent;
use Casino\CheckVersionTask;
use Casino\UpdaterTask;
use BossBarAPI\API;

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
public function SignChange(SignChangeEvent $event) {
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
        if($event->getBlock()->getId() == 68 || $event->getBlock()->getId() == 63){ 
		$sign = $event->getPlayer()->getLevel()->getTile($event->getBlock());
		   $money = $this->getConfig()->get("money_of_sign");
	                if ($event->getLine(0) == "[Casino]" && $event->getPlayer()->isOp() && $event->getLine(1) == "cheap"){	
                            $event->setLine(0,"§f[§eCasino§f]");
                              $event->getLine(1);
                              $event->getLine(2);
                              $event->getLine(3);
                              $cheaptext = $url->play_cheap;
                              $str = "§e{$url->play_cheap}";
                       $n = round(strlen($str)/2);
                       $stra[0] = substr($str, 0, $n);
                       $stra[1] = substr($str, $n);
                             $event->setLine(1,"§l{$stra[0]}");
                              $event->setLine(2,"§e{$stra[1]}");
                              $event->setLine(3,"§a++ {$cheap}$ ++");
                                $player = $event->getPlayer();
                           $player->sendMessage("§f[§eCasino§f] {$url->create_sign}");
                           //create a new sign 
	            }
	if ($event->getLine(0) == "[Casino]" && $event->getPlayer()->isOp() && $event->getLine(1) == "dear"){	
                            $event->setLine(0,"§f[§eCasino§f]");
                              $event->getLine(1);
                              $event->getLine(2);
                              $event->getLine(3);
                             
                              $str = "§e{$url->play_dear}";
                       $n = round(strlen($str)/2);
                       $stra[0] = substr($str, 0, $n);
                       $stra[1] = substr($str, $n);
                             $event->setLine(1,"§l{$stra[0]}");
                              $event->setLine(2,"§e{$stra[1]}");
                              $event->setLine(3,"§a++ {$dear}$ ++");
                      $player = $event->getPlayer();
                           $player->sendMessage("§f[§eCasino§f] {$url->create_sign}");
                           //create a new sign 
	            }
	if ($event->getLine(0) == "[Casino]" && $event->getPlayer()->isOp() && $event->getLine(1) == "rich"){	
                            $event->setLine(0,"§f[§eCasino§f]");
                              $event->getLine(1);
                              $event->getLine(2);
                              $event->getLine(3);
                             
                              $str = "§e{$url->play_rich}";
                       $n = round(strlen($str)/2);
                       $stra[0] = substr($str, 0, $n);
                       $stra[1] = substr($str, $n);
                             $event->setLine(1,"§e{$stra[0]}");
                              $event->setLine(2,"§e{$stra[1]}");
                              $event->setLine(3,"§a++ {$rich}$ ++");
                      $player = $event->getPlayer();
                           $player->sendMessage("§f[§eCasino§f] {$url->create_sign}");
                           //create a new sign 
	            }
	       }
	}
	public function onPlayerTouch(PlayerInteractEvent $event){
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
              if($event->getBlock()->getId() == 68 || $event->getBlock()->getId() == 63){ 
	           $sign = $event->getPlayer()->getLevel()->getTile($event->getBlock()); 
	          	
			       $signtext = $sign->getText();
			
			          
                        if($signtext[0] == "§f[§eCasino§f]"  ){
                        	
                        	if($signtext[3] == "§a++ {$cheap}$ ++"){
                        
                        	$cmd1 = str_replace($event->getPlayer(), $event->getPlayer()->getName(), "c cheap");
                           $this->getServer()->dispatchCommand($event->getPlayer(), $cmd1);
                           }
                        }
               
            if($signtext[0] == "§f[§eCasino§f]"){
            	    $strd = "§e{$url->play_dear}";
                       $nd = round(strlen($strd)/2);
                       $strad[0] = substr($strd, 0, $nd);     
            	if($signtext[3] == "§a++ {$dear}$ ++"){
                        
                        	$cmd1 = str_replace($event->getPlayer(), $event->getPlayer()->getName(), "c dear");
                           $this->getServer()->dispatchCommand($event->getPlayer(), $cmd1);
                           }
                        }
                         
            if($signtext[0] == "§f[§eCasino§f]" ){
            	
                        if($signtext[3] == "§a++ {$rich}$ ++"){
                        	$cmd1 = str_replace($event->getPlayer(), $event->getPlayer()->getName(), "c rich");
                           $this->getServer()->dispatchCommand($event->getPlayer(), $cmd1);
                           }
                        }
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
$money = $rand[mt_rand(0,count($rand)-1)];

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
$v = Server::getInstance()->getVersion();
//$sender->sendMessage($v);
if (substr($v, 0, 6) === "v0.16."){
$this->eid = API::addBossBar([$sender->getPlayer()], "§a{$sender->getName()} {$url->startc}");
API::setTitle(sprintf("§e{$sender->getName()} {$url->startc}"), $this->eid);
API::setPercentage(20, $this->eid);
}
sleep(1);

$sender->sendPopup("§9[§aCasino§9]§6»§e 1 2");

if (substr($v, 0, 6) === "v0.16."){
API::setPercentage(40, $this->eid);
}
sleep(1);

$sender->sendPopup("§9[§aCasino§9]§6»§e 1 2 3");
if (substr($v, 0, 6) === "v0.16."){
API::setPercentage(60, $this->eid);
}
sleep(1);
$sender->sendPopup("§9[§aCasino§9]§6»§e 1 2 3 4");
if (substr($v, 0, 6) === "v0.16."){
API::setPercentage(80, $this->eid);
}
$player->getlevel()->addSound(new FizzSound($player));
sleep(1);
$sender->sendPopup("§9[§aCasino§9]§6»§e 1 2 3 4 §45");
if (substr($v, 0, 6) === "v0.16."){
API::setPercentage(100, $this->eid);
sleep(1);
$geto = Server::getInstance()->getOnlinePlayers();
API::removeBossBar($geto, $this->eid);
}
if($money >= $cheap){
$moneyd = $money - $cheap;
if (substr($v, 0, 6) === "v0.16."){
$this->eid = API::addBossBar([$sender->getPlayer()], "§e{$sender->getName()} {$url->wowb}");
API::setTitle(sprintf("§e{$sender->getName()} {$url->wowb}"), $this->eid);
API::setPercentage(100, $this->eid);
}
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
if (substr($v, 0, 6) === "v0.16."){
sleep(10);

API::removeBossBar($geto, $this->eid);
}
}
}
if($money <= $cheap){
	$moneyd = $money - $cheap;
	if (substr($v, 0, 6) === "v0.16."){
	$this->eid = API::addBossBar([$sender->getPlayer()], "§e{$sender->getName()} {$url->lostb}");
API::setTitle(sprintf("§e{$sender->getName()} {$url->lostb}"), $this->eid);
API::setPercentage(100, $this->eid);
}
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
if (substr($v, 0, 6) === "v0.16."){
sleep(10);
API::removeBossBar($geto, $this->eid);
}
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
$rand = array(500,1000,100,1,300,750,50,250);
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
$v = Server::getInstance()->getVersion();
//$sender->sendMessage($v);
if (substr($v, 0, 6) === "v0.16."){
$this->eid = API::addBossBar([$sender->getPlayer()], "§a{$sender->getName()} {$url->startd}");
API::setTitle(sprintf("§e{$sender->getName()} {$url->startd}"), $this->eid);
API::setPercentage(20, $this->eid);
}
sleep(1);

$sender->sendPopup("§9[§aCasino§9]§6»§e 1 2");

if (substr($v, 0, 6) === "v0.16."){
API::setPercentage(40, $this->eid);
}
sleep(1);

$sender->sendPopup("§9[§aCasino§9]§6»§e 1 2 3");
if (substr($v, 0, 6) === "v0.16."){
API::setPercentage(60, $this->eid);
}
sleep(1);
$sender->sendPopup("§9[§aCasino§9]§6»§e 1 2 3 4");
if (substr($v, 0, 6) === "v0.16."){
API::setPercentage(80, $this->eid);
}
$player->getlevel()->addSound(new FizzSound($player));
sleep(1);
$sender->sendPopup("§9[§aCasino§9]§6»§e 1 2 3 4 §45");
if (substr($v, 0, 6) === "v0.16."){
API::setPercentage(100, $this->eid);
sleep(1);
$geto = Server::getInstance()->getOnlinePlayers();
API::removeBossBar($geto, $this->eid);
}

if($money >= $dear){
$moneyd = $money - $dear;

if (substr($v, 0, 6) === "v0.16."){
$this->eid = API::addBossBar([$sender->getPlayer()], "§e{$sender->getName()} {$url->wowbd}");
API::setTitle(sprintf("§e{$sender->getName()} {$url->wowbd}"), $this->eid);
API::setPercentage(100, $this->eid);
}
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
if (substr($v, 0, 6) === "v0.16."){
sleep(10);
API::removeBossBar($geto, $this->eid);
}
}
if($money <= $dear){
	$moneyd = $money - $dear;
	
if (substr($v, 0, 6) === "v0.16."){
$this->eid = API::addBossBar([$sender->getPlayer()], "§e{$sender->getName()} {$url->lostbd}");
API::setTitle(sprintf("§e{$sender->getName()} {$url->lostbd}"), $this->eid);
API::setPercentage(100, $this->eid);
}
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
if (substr($v, 0, 6) === "v0.16."){
sleep(10);
API::removeBossBar($geto, $this->eid);
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
     
$rand = array(500,1000,100,1,300,750,50,250,900,2000,1250,1150);
$money = $rand[mt_rand(1,count($rand)-1)];

if($this->getServer()->getPluginManager()->getPlugin("EconomyAPI") != null){
		$this->eco->addMoney($sender, $money);
               }
               if($this->getServer()->getPluginManager()->getPlugin("EconomyPlus") != null){
               $mi =EconomyPlus::getInstance()->addMoney($sender, $money);
               $mi;
             
               }
 
$sender->sendMessage("§9»»»»»§e".$url->rich."§9«««««\n§e♦§6".$url->ante.":§a ".$rich."$"); 
$v = Server::getInstance()->getVersion();
if (substr($v, 0, 6) === "v0.16."){
$this->eid = API::addBossBar([$sender->getPlayer()], "§a{$sender->getName()} {$url->startr}");
API::setTitle(sprintf("§e{$sender->getName()} {$url->startr}"), $this->eid);
API::setPercentage(20, $this->eid);
}
sleep(1);

$sender->sendPopup("§9[§aCasino§9]§6»§e 1 2");

if (substr($v, 0, 6) === "v0.16."){
API::setPercentage(40, $this->eid);
}
sleep(1);

$sender->sendPopup("§9[§aCasino§9]§6»§e 1 2 3");
if (substr($v, 0, 6) === "v0.16."){
API::setPercentage(60, $this->eid);
}
sleep(1);
$sender->sendPopup("§9[§aCasino§9]§6»§e 1 2 3 4");
if (substr($v, 0, 6) === "v0.16."){
API::setPercentage(80, $this->eid);
}
$player->getlevel()->addSound(new FizzSound($player));
sleep(1);
$sender->sendPopup("§9[§aCasino§9]§6»§e 1 2 3 4 §45");
if (substr($v, 0, 6) === "v0.16."){
API::setPercentage(100, $this->eid);
sleep(1);
$geto = Server::getInstance()->getOnlinePlayers();
API::removeBossBar($geto, $this->eid);
}

if($money >= $rich){
$moneyd = $money - $rich;

if (substr($v, 0, 6) === "v0.16."){
$this->eid = API::addBossBar([$sender->getPlayer()], "§e{$sender->getName()} {$url->wowbr}");
API::setTitle(sprintf("§e{$sender->getName()} {$url->wowbr}"), $this->eid);
API::setPercentage(100, $this->eid);
}
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
if (substr($v, 0, 6) === "v0.16."){
sleep(10);
API::removeBossBar($geto, $this->eid);
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
	
if (substr($v, 0, 6) === "v0.16."){
$this->eid = API::addBossBar([$sender->getPlayer()], "§e{$sender->getName()} {$url->lostbr}");
API::setTitle(sprintf("§e{$sender->getName()} {$url->lostbr}"), $this->eid);
API::setPercentage(100, $this->eid);
}
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
if (substr($v, 0, 6) === "v0.16."){
sleep(10);

API::removeBossBar($geto, $this->eid);
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
