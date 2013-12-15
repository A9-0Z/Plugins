<?php
/*
__PocketMine Plugin__
name=IsnTeam
description=Capture the Flag plugin !
version=1.0
author=A9_0Z
class=IsnTeam
apiversion=9,10,11,12,13,14,
*/
/*
Small Changelog
===============
Commit summary: Extended description: (optional)
A9-0Z samuelandrewmark@gmail.com

Commit summary: Extended description: (optional)
A9-0Z samuelandrewmark@gmail.com

1.0: Initial release
*/
class IsnTeam implements Plugin{
    private $api, $this, $path, $server, $config;
    public $level;
    private $nr = 0;
    private $timer = 0;
    private $interval;

    public function __construct(ServerAPI $api, $server = false){
        $this->api = $api;
    }

    public function init(){
        $this->api->addHandler("player.interact", array($this, "eventHandler"));
        $this->api->addHandler("player.spawn", array($this, "eventHandler"));
        $this->api->addHandler("player.quit", array($this, "eventHandler"));
        $this->api->addHandler("player.death", array($this, "eventHandler"));
        $this->api->addHandler("player.armor", array($this, "eventHandler"));
        $this->api->addHandler("player.drop", array($this, "eventHandler"));
        
        $this->path = $this->api->plugin->configPath($this);
        $this->score = new Config($this->path . "scores.yml", CONFIG_YAML, array("Blue" => 0, "Red" => 0));
        $this->score = $this->api->plugin->readYAML($this->path . "scores.yml");
        
        $GLOBALS['Red']= array('PlaceHold','PlaceHold1');
        $GLOBALS['Blue']= array('PlaceHold2','Placehold3');
        $GLOBALS['RedCount']= count(isset($Red));
        $GLOBALS['BlueCount']= count(isset($Blue));
        $GLOBALS['RedSC']= array();
        $GLOBALS['BlueSC']= array();
        $GLOBALS['BluedCount']= $this->score['Blue'];
        $GLOBALS['RedsCount']= $this->score['Red'];
        $GLOBALS['BlueSCount']= (string)$GLOBALS['BluedCount'];
        $GLOBALS['RedSCount']= (string)$GLOBALS['RedsCount'];
        
        $this->items = new Config($this->api->plugin->configPath($this)."items.yml", CONFIG_YAML, array(
            '272' => '1',
            '320' => '5'));
            $this->items = $this->api->plugin->readYAML($this->api->plugin->configPath($this). "items.yml");
        }
    
    
     public function eventHandler($data, $event) {
        global $Red,$Blue,$BlueCount,$RedCount,$username,$player;
            switch ($event) {
                case "player.spawn":
                    global $Red,$Blue,$BlueCount,$RedCount,$username,$player;
                    $GLOBALS['username']= $this->api->player->get($data->iusername);
                    $GLOBALS['player']= $data;
                        foreach($player->inventory as $slot => $data){
                            if(isset($item) and $item->getID() !== $data->getID()){
                                continue;
                        }
                        $player->setSlot($slot, BlockAPI::getItem(AIR, 0, 0));}
                                       
                        foreach($player->armor as $slot => $data){
                            if(isset($item) and $item->getID() !== $data->getID()){
                                continue;
                        }
                        $player->setArmor($slot, BlockAPI::getItem(AIR, 0, 0));}
         
                        $GLOBALS['RedCount']= count($Red);
                        $GLOBALS['BlueCount']= count($Blue);
         
                        $search = array_search($username,$Blue);
                        if ($search !== FALSE){
                        $Blue = str_replace($username,'',$Blue);
                        $GLOBALS['Blue'] = array_filter($Blue);}

                        $search = array_search($username,$Red);
                        if ($search !== FALSE){
                        $Red = str_replace($username,'',$Red);
                        $GLOBALS['Red'] = array_filter($Red);}

                         
                        if ($RedCount < $BlueCount){
                        array_push($GLOBALS['Red'],$username);
                            
                            $player->setArmor(0, BlockAPI::getItem(LEATHER_CAP, 0, 0));
                            $player->setArmor(2, BlockAPI::getItem(LEATHER_PANTS, 0, 0));
                            $username->sendChat('You are now a member of team Red !');
                        }
                        if ($RedCount >= $BlueCount){
                        array_push($GLOBALS['Blue'],$username);
                            
                            $player->setArmor(0, BlockAPI::getItem(DIAMOND_HELMET, 0, 0));
                            $username->sendChat('You are now a member of team Blue !');
                        }
                           
                        foreach($this->items as $id => $count){
                            $player->addItem((int)$id, 0, (int)$count);}
                            $player->setArmor(1, BlockAPI::getItem(CHAIN_CHESTPLATE, 0, 0));
                        break;
                        
                        case "player.armor":
                        $username = $data["player"]->username;
                        $player = $data["player"];
                        if ($data["slot0"] === 255){
                            $search = array_search($GLOBALS['username'],$GLOBALS['Blue']);
                            if ($search !== FALSE){
                                $player->setArmor(0, BlockAPI::getItem(DIAMOND_HELMET, 0, 0));
                                
                                }
                                $search2 = array_search($GLOBALS['username'],$GLOBALS['Red']);
                                if ($search2 !== FALSE){
                                    $player->setArmor(0, BlockAPI::getItem(LEATHER_CAP, 0, 0));
                                         
                                }
                        }
                        if ($data["slot1"] === 255){
                                $player->setArmor(1, BlockAPI::getItem(CHAIN_CHESTPLATE, 0, 0));
                        }
                        if ($data["slot2"] === 255){
                                $search2 = array_search($GLOBALS['username'],$GLOBALS['Red']);
                                if ($search2 !== FALSE){
                                    $player->setArmor(2, BlockAPI::getItem(LEATHER_PANTS, 0, 0));
                                }}
                        break;
                        
                        case "player.quit":
                            global $Red,$Blue,$BlueCount,$RedCount;
                            $GLOBALS['username']= $this->api->player->get($data->iusername);
                            
                        $search = array_search($username,$Blue);
                        if ($search !== FALSE){
                        $Blue = str_replace($username,'',$Blue);
                        $GLOBALS['Blue'] = array_filter($Blue);}

                        $search = array_search($username,$Red);
                        if ($search !== FALSE){
                        $Red = str_replace($username,'',$Red);
                        $GLOBALS['Red'] = array_filter($Red);}
                        break;
                        
                        case "player.interact":
                           global $Red,$Blue,$BlueCount,$RedCount;
                       
     
      $player = $this->api->player->getbyEID($data["entity"]->eid);
      $target = $this->api->player->getbyEID($data["targetentity"]->eid);
     /* if($source != instanceof Player or $target != instanceof Player) {
$this->throwUnhandledErrorException(NOT_OBJECT);
} else { */
      $usernameP = $player->username;
       $target = $target->username;
   
                           $search = array_search($target,$Blue);
                           if ($search !== FALSE){ $GLOBALS['tarteam'] = 'Blue'; }
                           $search = array_search($target,$Red);
                           if ($search !== FALSE){ $GLOBALS['tarteam'] = 'Red'; }
                           $search = array_search($usernameP,$Red);
                           if ($search !== FALSE){ $GLOBALS['plateam'] = 'Red'; }
                           $search = array_search($usernameP,$Blue);
                           if ($search !== FALSE){ $GLOBALS['plateam'] = 'Blue'; }
                           global $tarteam,$plateam;
                           if($tarteam === $plateam ){
                           $player->sendChat("Player is on your team !!");
                           return false;
                           }
         
                           break;
                           
                           case player.death:
                            global $Red,$Blue,$BlueCount,$RedCount;
                            $GLOBALS['username']= $this->player->username;
                            $this->api->chat->broadcast("Got here");
                            safe_var_dump($this->player);
                            
                        $searchB = array_search($username,$Blue);
                        if ($searchB !== FALSE){ $bsc = $this->score->get("Blue"); $this->score->set("Blue", $bsc + 1);
                            $this->api->chat->broadcast("[ISN] " . 'Red Team Score = ' . $GLOBALS['RedSCount']);
                            $this->api->chat->broadcast("[ISN] " . 'Blue Team Score = ' . $GLOBALS['BlueSCount']);}
                            
                        $searchR = array_search($username,$Red);
                        if ($searchR !== FALSE){ $rsc = $this->score->get("Red"); $this->score->set("Red", $rsc + 1);
                            $this->api->chat->broadcast("[ISN] " . 'Red Team Score = ' . $GLOBALS['RedSCount']);
                            $this->api->chat->broadcast("[ISN] " . 'Blue Team Score = ' . $GLOBALS['BlueSCount']);}
                            break;
                            }}
    public function __destruct(){
global $Red,$Blue,$BlueCount,$RedCount;
unset($GLOBALS['Red']);
unset($GLOBALS['Blue']);
    }
 }
        
