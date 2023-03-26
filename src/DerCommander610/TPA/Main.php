<?php

namespace DerCommander610\TPA;

use pocketmine\command\Command;
use pocketmine\command\CommandSender;
use pocketmine\Player;
use pocketmine\plugin\PluginBase;

class Main extends PluginBase {

    private $TPA = [];

    public function onCommand(CommandSender $sender, Command $command, string $label, array $args): bool
    {
         switch($command->getName()) {

             case "tpa":
                 if(!$sender instanceof Player){
                     $sender->sendMessage("Du kannst diesen befehl nur Ingame verwenden!");
                     return false;
                 }
                 if(isset($args[0])){
                     $sender->sendMessage("§cDu musst den Spielernamen eingeben um den eine TPA anfrage schicken zu können!");
                     return false;
                 }

                 $player = $this->getServer()->getPlayer($args[0]);

                 if(!$player){
                     $sender->sendMessage("§cDieser Spieler ist nicht Online!");
                     return false;
                 }
                 if($sender->getName() == $player->getName()){
                     $sender->sendMessage("§cNetter versuch!");
                         return false;
                 }


                 $this->TPA[$player->getName()] = $sender->getName();
                 $sender->sendMessage("§aDu hast erfolgreich eine TPA geschickt!");
                 $player->sendMessage("§aDu hast eine TPA anfrage erhalten! mach /tpaccept um es anzunehmen! mach /tpadecline um die anfrage abzulehen!");
                 break;

             case "tpaccept":
                     if(!$sender instanceof Player) {
                         $sender->sendMessage("Du kannst diesen befehl nur Ingame verwenden!");
                         return false;
                     }

                     if(!isset($this->TPA[$sender->getName()])){
                         $sender->sendMessage("$cDu hast noch keine TPA`s erhalten!");
                         return false;
                     }

                     $player = $this->getServer()->getPlayer($this->TPA[$sender->getName()]);

                   if(!$player) {
                       $sender->sendMessage("§cDer Spieler der dir eine TPA geschickt hat ist Offline! Sein TPA ist nun ungültig!");
                       return false;
                     }

                 $player = $this->getServer()->getPlayer($args[0]);

                 if(!$player){
                     $sender->sendMessage("§cDieser Spieler ist nicht Online!");
                     return false;
                     }

                  unset($this->TPA[$sender->getName()]);
                      $player->teleport($sender->getPosition());
                      $sender->sendMessage("§aDu hast" . $sender->getName() . "`s TPA anfrage erfolgreich angenommen!");
                      $player->sendMessage("§e" . $sender->getName() . "§a hat deine TPA angenommen!");
                  break;

                  case "tpadecline":
                      if(!$sender instanceof Player) {
                          $sender->sendMessage("Du kannst diesen befehl nur Ingame verwenden!");
                          return false;

                          {

                      $player = $this->getServer()->getPlayer($this->TPA[$sender->getName()]);

                      if(!$player) {
                          $sender->sendMessage("§cDer Spieler der dir eine TPA geschickt hat den du ablehen kannst ist zurzeit Offline gegangen! Sein TPA ist nun ungültig!");
                          return false;
                      }

                      unset($this->TPA[$sender->getName()]);
                      $sender->sendMessage("§cDu hast§e" . $sender->getName() . "`s §cTPA erfolgreich abgelehnt!");
                      $player->sendMessage("§e" . $sender->getName() . "§chat deine TPA abgelehnt!!");
                      break;
        }
        return true;
    }
  }
}
