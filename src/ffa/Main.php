
<?php

namespace ffa;

use pocketmine\Server;

use pocketmine\Player;

use pocketmine\plugin\PluginBase;

use pocketmine\command\Command;

use pocketmine\command\CommandSender;

use pocketmine\event\Listener;

use pocketmine\level\Level;

use pocketmine\level\Position;

use pocketmine\item\Item;

use pocketmine\item\enchantment\Enchantment;

use pocketmine\item\enchantment\EnchantmentInstance;

use pocketmine\entity\Effect;

use pocketmine\entity\EffectInstance;

use pocketmine\event\player\PlayerJoinEvent;

class Main extends PluginBase implements Listener {

  

  public $kitnormal = [];

  public $kitcung = [];

  public $kitop = [];

  public $kithoimau = [];

  

  public function onEnable(){

    $this->getLogger()->info("Plugin Dang Duoc Thu Nghiem");

    $this->getServer()->getPluginManager()->registerEvents($this, $this);

  }

  

  public function onDisable(){

    $this->getLogger()->info("Plugin Da Tat");

  }

  

  public function onCommand(CommandSender $sender, Command $cmd, String $label, array $args): bool{

    switch($cmd->getName()){

      case "ffa":

        if ($sender instanceof Player){

          $this->FfaUi($sender);

        }else{

          $sender->sendMessage("Pls Use In Game, You Is Op?");

        }

    }

    return true;

  }

  

  public function onJoin(PlayerJoinEvent $event){

    $player = $event->getPlayer();

    $this->kitnormal[strtolower($player->getName())] = "on";

    $this->kitop[strtolower($player->getName())] = "off";

    $this->kitcung[strtolower($player->getName())] = "off";

    $this->kithoimau[strtolower($player->getName())] = "off";

    if($this->kitnormal[strtolower($player->getName())] == "on"){

      $this->kitnormalsuc($player);

    }

  }

  

  public function FfaUi($player){

    $api = $this->getServer()->getPluginManager()->getPlugin("FormAPI");

    $form = $api->createSimpleForm(function(Player $player, int $data = null){

      

      if($data === null){

        return true;

      }

      switch($data){

        case 0:

          $this->VaoFfa($player);

          break;

          

          case 1:

            $this->ChonKit($player);

            break;

            

            case 2:

              $player->sendMessage("§l§c• Đã Thoát Menu Ffa");

              break;

      }

    });

    $form->setTitle("§l§c>=== FFA ===<");

    $form->setContent("§l§b• Chú Ý!: Khi Bạn Không Chọn Kit Kit Mặc Định Sẽ Là Kit Normal");

    $form->addButton("§l§e• Vào Ffa •");

    $form->addButton("§l§e• Chọn Kit •");

    $form->addButton("§l§c• Thoát •");

    $form->sendToPlayer($player);

    return $form;

  }

  public function ChonKit($player){

    $api = $this->getServer()->getPluginManager()->getPlugin("FormAPI");

    $form = $api->createSimpleForm(function(Player $player, int $data = null){

      

      if($data === null){

        return true;

      }

      switch($data){

        case 0:

          if($this->kitnormal[strtolower($player->getName())] == "on"){

            $player->sendMessage("§l§c• Bạn Đã Chọn Kit Này Từ Trước Rồi");

          }else{

            $this->kitnormal[strtolower($player->getName())] = "on";

            $this->kitcung[strtolower($player->getName())] = "off";

            $this->kitop[strtolower($player->getName())] = "off";

            $this->kithoimau[strtolower($player->getName())] = "off";

            $player->sendMessage("§l§a• Đã Chọn Thành Công Kit Thường :D");

          }

          break;

          

          case 1:

            if($this->kitcung[strtolower($player->getName())] == "on"){

              $player->sendMessage("§l§c• Bạn Đã Chọn Kit Này Từ Trước Rồi");

            }else{

              $this->kitcung[strtolower($player->getName())] = "on";

              $this->kitnormal[strtolower($player->getName())] = "off";

              $this->kitop[strtolower($player->getName())] = "off";

              $this->kithoimau[strtolower($player->getName())] = "off";

              $player->sendMessage("§l§a• Đã Chọn Thành Công Kit Cung :D");

            }

            break;

            

            case 2:

              if($this->kitop[strtolower($player->getName())] == "on"){

                $player->sendMessage("§l§c• Bạn Đã Chọn Kit Này Từ Trước Rồi");

              }else{

                $this->kitop[strtolower($player->getName())] = "on";

                $this->kitnormal[strtolower($player->getName())] = "off";

                $this->kitcung[strtolower($player->getName())] = "off";

                $this->kithoimau[strtolower($player->getName())] = "off";

                $player->sendMessage("§l§a• Đã Chọn Thành Công Kit Op :D");

              }

              break;

              

              case 3:

                if($this->kithoimau[strtolower($player->getName())] == "on"){

                  $player->sendMessage("§l§c• Bạn Đã Chọn Kit Này Từ Trước Rồi");

                }else{

                  $this->kithoimau[strtolower($player->getName())] = "on";

                  $this->kitnormal[strtolower($player->getName())] = "off";

                  $this->kitop[strtolower($player->getName())] = "off";

                  $this->kitcung[strtolower($player->getName())] = "off";

                  $player->sendMessage("§l§a• Đã Chọn Thành Công Kit Hồi Máu :D");

                }

                break;

                

                case 4:

                  $this->FfaUi($player);

                  break;

      }

    });

    $form->setTitle("§l§c>=== FFA ===<");

    $form->setContent("§l§b∆ Hãy Chọn Kit Cho Ffa ∆");

    $form->addButton("§l§e• Kit Thường •\n§l§7> Mặc Định <");

    $form->addButton("§l§e• Kit Cung •");

    $form->addButton("§l§e• Kit Op •");

    $form->addButton("§l§e• Kit Hồi Máu •");

    $form->addButton("§l§c• Quay Lại •");

    $form->sendToPlayer($player);

    return $form;

  }

  public function kitnormalsuc($player){

    $api = $this->getServer()->getPluginManager()->getPlugin("FormAPI");

    $form = $api->createSimpleForm(function(Player $player, int $data = null){

      

      if($data === null){

        return true;

      }

      switch($data){

        case 0:

          

          break;

      }

    });

    $form->setTitle("§l§c>=== FFA ===<");

    $form->setContent("§l§b• Kit Của Bạn Đã Được Reset Thành Kit Thường\n§l§b• Nếu Muốn Thay Kit Hãy Ghi /ffa");

    $form->addButton("§l§c• Thoát •");

    $form->sendToPlayer($player);

    return $form;

  }

  public function VaoFfa($player){

    $api = $this->getServer()->getPluginManager()->getPlugin("FormAPI");

    $form = $api->createSimpleForm(function(Player $player, int $data = null){

      

      if($data === null){

        return true;

      }

      switch($data){

         case 0:

           if($this->kitnormal[strtolower($player->getName())] == "on"){

            $this->getServer()->loadLevel("ffa");

            $swordnormal = Item::get(276, 0, 1);

            $applenormal = Item::get(322, 0, 5);

            $munormal = Item::get(310, 0, 1);

            $giapnormal = Item::get(311, 0, 1);

            $quannormal = Item::get(312, 0, 1);

            $giaynormal = Item::get(313, 0, 1);

            $player->removeAllEffects();

            $player->getInventory()->clearAll();

            $player->getArmorInventory()->clearAll();

            $player->getInventory()->addItem($swordnormal);

            $player->getInventory()->addItem($applenormal);

            $player->getArmorInventory()->setHelmet($munormal);

            $player->getArmorInventory()->setChestplate($giapnormal);

            $player->getArmorInventory()->setLeggings($quannormal);

            $player->getArmorInventory()->setBoots($giaynormal);

            $level = $this->getServer()->getLevelByName("ffa");

            $player->teleport(new Position(2, 66, -7, $level));

            $player->sendMessage("§l§a•  Đã Vào Ffa Thành Công");

            $this->getServer()->broadcastMessage("§l§e• Người Chơi §l§c" . $player->getName() . " §l§eĐã Vào Ffa :3");

           }else{

            if($this->kitcung[strtolower($player->getName())] == "on"){

              $this->getServer()->loadLevel("ffa");

              $cungce1 = Enchantment::getEnchantment(21);

              $cungce1p = new EnchantmentInstance($cungce1, 2);

              $cungce2 = Enchantment::getEnchantment(19);

              $cungce2p = new EnchantmentInstance($cungce2, 5);

              $cungce3 = Enchantment::getEnchantment(17);

              $cungce3p = new EnchantmentInstance($cungce3, 100);

              $cungce4 = Enchantment::getEnchantment(22);

              $cungce4p = new EnchantmentInstance($cungce4, 5);

              $cung = Item::get(261, 0, 1);

              $muiten = Item::get(262, 0, 64);

              $muiten2 = Item::get(262, 0, 64);

              $applecung = Item::get(322, 0, 10);

              $thuoc1 = Item::get(373, 14, 1);

              $mucung = Item::get(310, 0, 1);

              $giapcung = Item::get(311, 0, 1);

              $quancung = Item::get(312, 0, 1);

              $giaycung = Item::get(313, 0, 1);

              $cung->addEnchantment($cungce1p);

              $cung->addEnchantment($cungce2p);

              $cung->addEnchantment($cungce3p);

              $cung->addEnchantment($cungce4p);

              $player->removeAllEffects();

              $player->getInventory()->clearAll();

              $player->getArmorInventory()->clearAll();

              $player->getInventory()->addItem($cung);

              $player->getInventory()->addItem($applecung);

              $player->getInventory()->addItem($muiten);

              $player->getInventory()->addItem($muiten2);

              $player->getInventory()->addItem($thuoc1);

              $player->getArmorInventory()->setHelmet($mucung);

              $player->getArmorInventory()->setChestplate($giapcung);

              $player->getArmorInventory()->setLeggings($quancung);

              $player->getArmorInventory()->setBoots($giaycung);

              $level = $this->getServer()->getLevelByName("ffa");

              $player->teleport(new Position(2, 66, -7, $level));

              $player->sendMessage("§l§a• Đã Vào Thành Công Ffa");

              $this->getServer()->broadcastMessage("§l§e• Người Chơi §l§c" . $player->getName() . "§l§e Đã Vào Ffa :3");

            }else{

              if($this->kitop[strtolower($player->getName())] == "on"){

                $opec1 = Enchantment::getEnchantment(12);

                $opec1p = new EnchantmentInstance($opec1, 2);

                $opec2 = Enchantment::getEnchantment(17);

                $opec2p = new EnchantmentInstance($opec2, 100);

                $opec3 = Enchantment::getEnchantment(9);

                $opec3p = new EnchantmentInstance($opec3, 5);

                $opec4 = Enchantment::getEnchantment(13);

                $opec4p = new EnchantmentInstance($opec4, 1);

                $opec5 = Enchantment::getEnchantment(1);

                $opec5p = new EnchantmentInstance($opec5, 5);

                $opec6 = Enchantment::getEnchantment(0);

                $opec6p = new EnchantmentInstance($opec6, 5);

                $opec7 = Enchantment::getEnchantment(5);

                $opec7p = new EnchantmentInstance($opec7, 3);

                $opec8 = Enchantment::getEnchantment(4);

                $opec8p = new EnchantmentInstance($opec8, 5);

                $opec9 = Enchantment::getEnchantment(3);

                $opec9p = new EnchantmentInstance($opec9, 5);

                $swordop = Item::get(276, 0, 1);

                $luaop = Item::get(259, 0, 1);

                $muop = Item::get(310, 0, 1);

                $giapop = Item::get(311, 0, 1);

                $quanop = Item::get(312, 0, 1);

                $giayop = Item::get(313, 0, 1);

                $thuocop1 = Item::get(438, 22, 5);

                $thuocop2 = Item::get(438, 16, 5);

                $thuocop3 = Item::get(438, 24, 5);

                $appleop = Item::get(322, 0, 10);

                $swordop->addEnchantment($opec1p);

                $swordop->addEnchantment($opec2p);

                $swordop->addEnchantment($opec3p);

                $swordop->addEnchantment($opec4p);

                $muop->addEnchantment($opec5p);

                $muop->addEnchantment($opec2p);

                $muop->addEnchantment($opec6p);

                $muop->addEnchantment($opec7p);

                $muop->addEnchantment($opec8p);

                $muop->addEnchantment($opec9p);

                $giapop->addEnchantment($opec5p);

                $giapop->addEnchantment($opec2p);

                $giapop->addEnchantment($opec6p);

                $giapop->addEnchantment($opec7p);

                $giapop->addEnchantment($opec8p);

                $giapop->addEnchantment($opec9p);

                $giayop->addEnchantment($opec5p);

                $giayop->addEnchantment($opec2p);

                $giayop->addEnchantment($opec6p);

                $giayop->addEnchantment($opec7p);

                $giayop->addEnchantment($opec8p);

                $giayop->addEnchantment($opec9p);

                $quanop->addEnchantment($opec5p);

                $quanop->addEnchantment($opec2p);

                $quanop->addEnchantment($opec6p);

                $quanop->addEnchantment($opec7p);

                $quanop->addEnchantment($opec8p);

                $quanop->addEnchantment($opec9p);

                $this->getServer()->loadLevel("ffa");

                $player->removeAllEffects();

                $player->getInventory()->clearAll();

                $player->getArmorInventory()->clearAll();

                $player->getInventory()->addItem($swordop);

                $player->getInventory()->addItem($appleop);

                $player->getInventory()->addItem($luaop);

                $player->getInventory()->addItem($thuocop1);

                $player->getInventory()->addItem($thuocop2);

                $player->getInventory()->addItem($thuocop3);

                $player->getArmorInventory()->setHelmet($muop);

                $player->getArmorInventory()->setChestplate($giapop);

                $player->getArmorInventory()->setLeggings($quanop);

                $player->getArmorInventory()->setBoots($giayop);

                $level = $this->getServer()->getLevelByName("ffa");

                $player->teleport(new Position(2, 66, -7, $level));

                $player->sendMessage("§l§a• Đã Vào Thành Công Ffa");

                $this->getServer()->broadcastMessage("§l§e• Người Chơi §l§c" . $player->getName() . " §l§eĐã Vào Ffa");

              }else{

                if($this->kithoimau[strtolower($player->getName())] == "on"){

                  $hmec1 = Enchantment::getEnchantment(17);

                  $hmec1p = new EnchantmentInstance($hmec1, 100);

                  $hmec2 = Enchantment::getEnchantment(9);

                  $hmec2p = new EnchantmentInstance($hmec2, 2);

                  $hmec3 = Enchantment::getEnchantment(0);

                  $hmec3p = new EnchantmentInstance($hmec3, 2);

                  $hmec4 = Enchantment::getEnchantment(1);

                  $hmec4p = new EnchantmentInstance($hmec4, 2);

                  $hmec5 = Enchantment::getEnchantment(3);

                  $hmec5p = new EnchantmentInstance($hmec5, 2);

                  $applehoimau = Item::get(322, 0, 10);

                  $swordhoimau = Item::get(276, 0, 1);

                  $hoimau1 = Item::get(373, 22, 10);

                  $hoimau2 = Item::get(438, 22, 10);

                  $hoimau3 = Item::get(438, 24, 5);

                  $muhoimau = Item::get(310, 0, 1);

                  $giaphoimau = Item::get(311, 0, 1);

                  $quanhoimau = Item::get(312, 0, 1);

                  $giayhoimau = Item::get(313, 0, 1);

                  $swordhoimau->addEnchantment($hmec1p);

                  $swordhoimau->addEnchantment($hmec2p);

                  $muhoimau->addEnchantment($hmec1p);

                  $muhoimau->addEnchantment($hmec3p);

                  $muhoimau->addEnchantment($hmec4p);

                  $muhoimau->addEnchantment($hmec5p);

                  $giaphoimau->addEnchantment($hmec1p);

                  $giaphoimau->addEnchantment($hmec3p);

                  $giaphoimau->addEnchantment($hmec4p);

                  $giaphoimau->addEnchantment($hmec5p);

                  $quanhoimau->addEnchantment($hmec1p);

                  $quanhoimau->addEnchantment($hmec3p);

                  $quanhoimau->addEnchantment($hmec4p);

                  $quanhoimau->addEnchantment($hmec5p);

                  $giayhoimau->addEnchantment($hmec1p);

                  $giayhoimau->addEnchantment($hmec3p);

                  $giayhoimau->addEnchantment($hmec4p);

                  $giayhoimau->addEnchantment($hmec5p);

                  $player->removeAllEffects();

                  $player->getInventory()->clearAll();

                  $player->getArmorInventory()->clearAll();

                  $player->getInventory()->addItem($swordhoimau);

                  $player->getInventory()->addItem($applehoimau);

                  $player->getInventory()->addItem($hoimau1);

                  $player->getInventory()->addItem($hoimau2);

                  $player->getInventory()->addItem($hoimau3);

                  $player->getArmorInventory()->setHelmet($muhoimau);

                  $player->getArmorInventory()->setChestplate($giaphoimau);

                  $player->getArmorInventory()->setLeggings($quanhoimau);

                  $player->getArmorInventory()->setBoots($giayhoimau);

                  $this->getServer()->loadLevel("ffa");

                  $level = $this->getServer()->getLevelByName("ffa");

                  $player->teleport(new Position(2, 66, -7, $level));

                  $player->sendMessage("§l§a• Đã Vào Thành Công Ffa");

                  $this->getServer()->broadcastMessage("§l§e• Người Chơi §l§c" . $player->getName() . " §l§eĐã Vào Ffa");

                }

              }

            }

           }

           break;

          

          case 1:

            $this->ChonKit($player);

            break;

            

            case 2:

              $this->FfaUi($player);

              break;

      }

    });

    $form->setTitle("§l§c>=== FFA ===<");

    $form->setContent("§l§b• Vào FFA Ngay !");

    $form->addButton("§l§a• Vào Ngay !");

    $form->addButton("§l§a• Chọn Lại Kit");

    $form->addButton("§l§c• Quay Lại •");

    $form->sendToPlayer($player);

    return $form;

  }

  

}
