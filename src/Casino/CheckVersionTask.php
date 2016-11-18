<?php //by @SalmonGER (https://github.com/SalmonGER)
namespace Casino;

use pocketmine\plugin\PluginBase;
use pocketmine\scheduler\AsyncTask;
use pocketmine\utils\TextFormat as TF;
use pocketmine\utils\Utils; 
use pocketmine\utils\Config;
use pocketmine\Server;
use Casino\Casino;

class CheckVersionTask extends AsyncTask
{
    public function __construct($owner){
        $this->name = $owner->getDescription()->getName();
        $this->cversion = $owner->getDescription()->getVersion();
        $this->website = $owner->getDescription()->getWebsite();
        $this->autoupdate = $owner->getConfig()->get('Auto-Update');
        $this->path = $owner->getDataFolder();
        $this->lang = $owner->getConfig()->get('lang');
    }

    public function onRun(){
    	$urlh = file_get_contents('http://infomcpe.ru/updater.php?pluginname='.$this->name.''); 
        $url = json_decode($urlh); 
        $nversion = $url->version;
        $this->description = $url->description;
        
        if($nversion){
            if($this->cversion == $nversion){
                $this->setResult(false);
            }else{
                $this->setResult($nversion);
            }
        }else{
            $this->setResult('Empty');
        }
   }

    public function onCompletion(Server $server){
    	if($this->lang == 1){
        $urlh = file_get_contents('http://infomcpe.ru/updater.php?pluginname=Casino_RU'); 
        $urll = json_decode($urlh);
        }
       if($this->lang == 2){
        $urlh = file_get_contents('http://infomcpe.ru/updater.php?pluginname=Casino_EN'); 
        $urll = json_decode($urlh); 
                } 
   
        if($this->getResult() == 'Empty'){
            $server->getPluginManager()->getPlugin($this->name)->getLogger()->error(TF::RED.'Could not check for Update: "Empty Response" !');
        }elseif($this->getResult()){
               $server->getPluginManager()->getPlugin($this->name)->getLogger()->alert(TF::GOLD.'.$urll->update.$this->name."');
            $server->getPluginManager()->getPlugin($this->name)->getLogger()->alert(TF::RED."$urll->cversion.$this->cversion.");
            $server->getPluginManager()->getPlugin($this->name)->getLogger()->alert(TF::GREEN."$urll->newversion.$nversion.");
            $server->getPluginManager()->getPlugin($this->name)->getLogger()->alert(TF::GREEN.".$urll->description.$this->description.");
            sleep(1);
            if($this->autoupdate){
                $server->getPluginManager()->getPlugin($this->name)->getLogger()->alert(TF::AQUA.".$urll->inupdate.$this->getResult().");
                
                $server->getPluginManager()->getPlugin($this->name)->update();
            }
        }else{
            $server->getPluginManager()->getPlugin($this->name)->getLogger()->notice(TF::GREEN.$urll->noupdate);
        }
    }
}
