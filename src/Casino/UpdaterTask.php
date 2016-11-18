<?php //by SalmonGER (https://github.com/SalmonGER)
namespace Casino;

use pocketmine\scheduler\PluginTask;
use pocketmine\utils\TextFormat as TF;
use pocketmine\utils\Utils;
use pocketmine\utils\Config;
use Casino\Casino;

class UpdaterTask extends PluginTask
{
    public function __construct($owner, $version){
        $this->name = $owner->getDescription()->getName();
        parent::__construct($owner);
        $urlh = file_get_contents('http://infomcpe.ru/updater.php?pluginname='.$this->name.''); 
        $urldata = json_decode($urlh); 
        $this->url = $urldata->downloadurl;
        $this->version = $owner->getDescription()->getVersion();
        $this->newversion = $urldata->version;
        $lang = $owner->getConfig()->get("lang");
        
    }

    public function onRun($currenttick){
        $file = Utils::getURL($this->url);
        if($lang == 1){
$urlh = file_get_contents('http://infomcpe.ru/updater.php?pluginname=Casino_RU'); 
        $urll = json_decode($urlh);
        }
    if($lang == 2){
$urlh = file_get_contents('http://infomcpe.ru/updater.php?pluginname=Casino_EN'); 
        $urll = json_decode($urlh); 
                } 
        if($file){
            
                foreach(glob("plugins/*".$this->name."*.phar") as $phar){
                    unlink($phar);
                
                file_put_contents('plugins/'.$this->name.' v'.$this->newversion.'.phar', $file);
                if(!file_exists('plugins/'.$this->name.' v'.$this->newversion.'.phar')){
                        $this->getOwner()->getLogger()->error('Failed to download the update!');
                }else{
                    $this->getOwner()->getServer()->broadcastMessage(TF::RED.TF::BOLD.'.$urll->restart.');
                    $this->getOwner()->getServer()->broadcastTip(TF::RED.TF::BOLD.'.$url->restart.');
                    sleep(7);
                    $this->getOwner()->getServer()->shutdown();
                }
            }
        }else{
            $this->getOwner()->getLogger()->error('Error while downloading new phar!');
        }
    }
}
