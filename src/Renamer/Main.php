<?php
namespace Renamer;

use pocketmine\Server;
use pocketmine\Player;
use pocketmine\plugin\PluginBase;
use pocketmine\item\Item;
use pocketmine\block\Block;
use pocketmine\event\player\PlayerInteractEvent;
use pocketmine\math\Vector3;
use pocketmine\level\Position;
use pocketmine\tile\Tile;
use pocketmine\tile\Chest;
use pocketmine\nbt\NBT;
use pocketmine\inventory\Inventory;
use pocketmine\command\Command;
use pocketmine\command\CommandSender;
use pocketmine\event\Listener;
use pocketmine\utils\TextFormat as C;
use jojoe77777\FormAPI\CustomForm;

class Main extends PluginBase implements Listener{
    
    public $x=0;
    
    public function onEnable(){
        $this->getServer()->getPluginManager()->registerEvents($this,$this);
    }
    
	public function onCommand(CommandSender $sender, Command $cmd, string $label,array $args) : bool {
	if(($cmd->getName()) == "rename"){
	$this->x=1;
	$sender->sendMessage("Use the item you want to rename");
	}
return true;	
	}
    
    public function onInteract(PlayerInteractEvent $e){
    $player = $e->getPlayer();
    $item = $player->getInventory()->getItemInHand();
   if(!$item->getId() == 0){
    if($this->x == 0){
     if($item->getId() == 421){
    $player->getInventory()->removeItem($item);
    $player->sendMessage(C::YELLOW.C::UNDERLINE."Long Tap the item in hand to rename");
    $this->x=1;
    return true;
     }
    }
    if($this->x == 1)
    {
    $form = new CustomForm(function (Player $sender, $data){
        if($data === null){
            $sender->getInventory()->addItem(Item::get(421,0,1));
            $this->x=0;
            return true;
        }
   $player = $sender;
    $item = $player->getInventory()->getItemInHand();
    $player->getInventory()->removeItem($item);
    $item->setCustomName($data[0]);
    $player->getInventory()->addItem($item);
    $this->x=0; 
   
    });
    //stuff for form
    $form->setTitle("Set Item Name");
    $form->addInput("Item Name:","Awesome Item");
    $player->sendForm($form);
    }
    }
    }
    
    public function onDisable(){
     $this->getLogger()->info("§cOffline");
    }
}
