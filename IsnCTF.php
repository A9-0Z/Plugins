<?php
/*
__PocketMine Plugin__
name=IsnCTF
description=Capture the Flag plugin !
version=1.0
author=A9_0Z
class=IsnCTF
apiversion=9
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
class IsnCTF implements Plugin{
   private $api, $this, $path, $server, $config;
   public $level;
   private $nr = 0;
   private $interval;
    public function __construct(ServerAPI $api, $server = false){
        $this->api = $api;
    }
         public function init(){
         $this->api->addHandler("player.interact", array($this, "eventHandler"));       
         $this->api->addHandler("player.spawn", array($this, "eventHandler"));        
         $this->api->addHandler("player.block.place", array($this, "eventHandler"));
         $this->api->addHandler("player.block.break", array($this, "eventHandler"));
         $this->api->addHandler("player.armor", array($this, "eventHandler"));
         $this->api->addHandler("player.drop", array($this, "eventHandler"));
                
         $GLOBALS['Red']= array('PlaceHold','PlaceHold1');
         $GLOBALS['Blue']= array('PlaceHold2','Placehold3');
         $GLOBALS['RedCount']= count($Red);
         $GLOBALS['BlueCount']= count($Blue);
         $GLOBALS['RedSC']= array();
         $GLOBALS['BlueSC']= array();
         $GLOBALS['BlueSCount']= count($BlueSC);
         $GLOBALS['RedSCount']= count($RedSC);
         $GLOBALS['PlayerCount']= count($this->api->player->getAll());
         $GLOBALS['level']= $this->api->level->getDefault();
         
         $this->configSC = new Config($this->api->plugin->configPath($this) . "configSC.yml", CONFIG_YAML, array('interval' => 1, 'messages' => array("Example message")));
                $this->interval = $this->configSC->get("interval");
                $this->api->schedule(20 * 60 * $this->interval, array($this, "msg"), array(), false);
                
         $this->configST = new Config($this->api->plugin->configPath($this) . "configST.yml", CONFIG_YAML, array('interval' => 1.3, 'messages' => array("Example message")));
                $this->intervalSt = $this->configSC->get("interval");
                $this->api->schedule(20 * 60 * $this->intervalSt, array($this, "stop"), array(), false);
         
         $this->items = new Config($this->api->plugin->configPath($this)."items.yml", CONFIG_YAML, array(
                        '272' => '1',
                        '320' => '5'));
                        $this->items = $this->api->plugin->readYAML($this->api->plugin->configPath($this). "items.yml");
         }


    public function msg() {
    	global $BlueSC,$RedSC,$BlueSCount,$RedSCount;
    	        $GLOBALS['BlueSCount']= count($BlueSC);
                $GLOBALS['RedSCount']= count($RedSC);
                $messagesArray = $this->configSC->get("messages");
                
                        $message = $messagesArray[$this->nr];
                        $this->api->chat->broadcast("[ISN] " . 'Red Team Score = ' . $GLOBALS['RedSCount']);
                        $this->api->chat->broadcast("[ISN] " . 'Blue Team Score = ' . $GLOBALS['BlueSCount']);
                      
                        if ($this->nr < count($messagesArray)-1) {
                                $this->nr++;
                        
                        }
                
                $this->api->schedule(20 * 60 * $this->interval, array($this, "msg"), array(), false);
        }
         
   public function stop() {
    	global $BlueSC,$RedSC,$BlueSCount,$RedSCount;
    	        $GLOBALS['BlueSCount']= count($BlueSC);
                $GLOBALS['RedSCount']= count($RedSC);
                $messagesArray = $this->configSC->get("messages");
                
                        $message = $messagesArray[$this->nr];
                        $this->api->chat->broadcast("[ISN] " . 'There are 10 minutes remaining!');
                        
                      
                        if ($this->nr < count($messagesArray)-1) {
                                $this->nr++;
                        
                        }
                
                $this->api->schedule(20 * 60 * 2, array($this, "stop2"), array(), false);
        }
   
   public function stop2() {
    	global $BlueSC,$RedSC,$BlueSCount,$RedSCount;
    	        $GLOBALS['BlueSCount']= count($BlueSC);
                $GLOBALS['RedSCount']= count($RedSC);
                $messagesArray = $this->configSC->get("messages");
                
                        $message = $messagesArray[$this->nr];
                        $this->api->chat->broadcast("[ISN] " . 'There are 8 minutes remaining!');
                        
                      
                        if ($this->nr < count($messagesArray)-1) {
                                $this->nr++;
                        
                        }
                
                $this->api->schedule(20 * 60 * 2, array($this, "stop3"), array(), false);
        }
   
   public function stop3() {
    	global $BlueSC,$RedSC,$BlueSCount,$RedSCount;
    	        $GLOBALS['BlueSCount']= count($BlueSC);
                $GLOBALS['RedSCount']= count($RedSC);
                $messagesArray = $this->configSC->get("messages");
                
                        $message = $messagesArray[$this->nr];
                        $this->api->chat->broadcast("[ISN] " . 'There are 6 minutes remaining!');
                        
                      
                        if ($this->nr < count($messagesArray)-1) {
                                $this->nr++;
                        
                        }
                
                $this->api->schedule(20 * 60 * 2, array($this, "stop4"), array(), false);
        }
    
    public function stop4() {
    	global $BlueSC,$RedSC,$BlueSCount,$RedSCount;
    	        $GLOBALS['BlueSCount']= count($BlueSC);
                $GLOBALS['RedSCount']= count($RedSC);
                $messagesArray = $this->configSC->get("messages");
                
                        $message = $messagesArray[$this->nr];
                        $this->api->chat->broadcast("[ISN] " . 'There are 4 minutes remaining!');
                        
                      
                        if ($this->nr < count($messagesArray)-1) {
                                $this->nr++;
                        
                        }
                
                $this->api->schedule(20 * 60 * 2, array($this, "stop5"), array(), false);
        }
    
    public function stop6() {
    	global $BlueSC,$RedSC,$BlueSCount,$RedSCount;
    	        $GLOBALS['BlueSCount']= count($GLOBALS['BlueSC']);
                $GLOBALS['RedSCount']= count($GLOBALS['RedSC']);
                $messagesArray = $this->configSC->get("messages");
                if($GLOBALS['RedSCount'] > $GLOBALS['BlueSCount']){$winners = 'The Red Team have won !!';}
                if($GLOBALS['RedSCount'] < $GLOBALS['BlueSCount']){$winners = 'The Blue Team have won !!';}
                if($GLOBALS['RedSCount'] === $GLOBALS['BlueSCount']){$winners = 'Ah Really Guys, a DRAW ?!!';}
                        $message = $messagesArray[$this->nr];
                        $this->api->chat->broadcast("[ISN] " . $winners );
                        $this->api->chat->broadcast("[ISN] " . 'Match Finished Thanks for Playing!');
                        $this->api->console->run("stop");
                        if ($this->nr < count($messagesArray)-1) {
                                $this->nr++;
                        
                        }
                
                
        }
    
    public function stop5() {
    	global $BlueSC,$RedSC,$BlueSCount,$RedSCount;
    	        $GLOBALS['BlueSCount']= count($BlueSC);
                $GLOBALS['RedSCount']= count($RedSC);
                $messagesArray = $this->configSC->get("messages");
                
                        $message = $messagesArray[$this->nr];
                        $this->api->chat->broadcast("[ISN] " . 'There are 2 minutes remaining!');
                        
                      
                        if ($this->nr < count($messagesArray)-1) {
                                $this->nr++;
                        
                        }
                
                $this->api->schedule(20 * 60 * 1, array($this, "stop7"), array(), false);
        }
         
      public function stop7() {
    	global $BlueSC,$RedSC,$BlueSCount,$RedSCount;
    	        $GLOBALS['BlueSCount']= count($BlueSC);
                $GLOBALS['RedSCount']= count($RedSC);
                $messagesArray = $this->configSC->get("messages");
                
                        $message = $messagesArray[$this->nr];
                        $this->api->chat->broadcast("[ISN] " . 'There is 1 minute remaining!');
                        
                      
                        if ($this->nr < count($messagesArray)-1) {
                                $this->nr++;
                        
                        }
                
                $this->api->schedule(20 * 60 * 1, array($this, "stop6"), array(), false);
        }    
         
   public function eventHandler($data, $event)
	{
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
		              $player->setSpawn(127, 68, 156);
		              $player->teleport(127, 68, 156);
			      $player->setArmor(0, BlockAPI::getItem(LEATHER_CAP, 0, 0));
			      $player->setArmor(2, BlockAPI::getItem(LEATHER_PANTS, 0, 0));
			      $username->sendChat('You are now a member of team Red !');
			   } 
			   if ($RedCount >= $BlueCount){
	                array_push($GLOBALS['Blue'],$username);
	                      $player->setSpawn(126 68 93);
	                      $player->teleport(126 68 93);
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
                                	$this->api->console->run("spawnpoint $username 126 68 93");
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
		
		        case "player.block.break":
		        	global $Red,$Blue,$BlueCount,$RedCount,$RedSC,$BlueSC;
	        $username = $data["player"]->username;
		$target = $data["target"];
		if ($target->getID() === 35){ 
			if ($target->getMetadata() === 14){ 
			  $search = array_search($GLOBALS['username'],$GLOBALS['Blue']);
                           if ($search !== FALSE){
                           $this->api->chat->broadcast("[ISN] " . 'Red Flag Stolen by ' . $username . '!');
                           return true;
                           }
                           if ($search === FALSE){ 
                           	return false;
                           }
			}
			if ($target->getMetadata() === 11){
				$search = array_search($GLOBALS['username'],$GLOBALS['Red']);
                           if ($search !== FALSE){
                           $this->api->chat->broadcast("[ISN] " . 'Blue Flag Stolen by ' . $username . '!'); 
                           return true;
                           }
                           if ($search === FALSE){return false;
                           }
			}
		} if ($target->getID() !== 35){
			return false;}
		        break;
		
	         	case "player.drop":
	         		return false;
	         		break;
		
                        case "player.block.place":
                           global $Red,$Blue,$BlueCount,$RedCount,$RedSC,$BlueSC;
      $GLOBALS['player']= $data;                     
      $target = $data["block"];
      $item = $data["item"];
      $username = $data["player"]->username;
     if ($item->getID() === 35){ 
      	        $x = $target->x;
                $y = $target->y;
                $z = $target->z;
      	$this->api->level->getDefault()->setBlock(new Vector3((int) $x, (int) $y, (int) $z), new AirBlock());
      	if ($item->getMetadata() === 14){  $this->api->level->getDefault()->setBlock(new Vector3((int) 118, (int) 65, (int) 145), new WoolBlock(14));
             $search = array_search($username,$Blue);
             if ($search !== FALSE){

                if(118 <= $x and $x <= 120){if(64<= $y and $y <= 66){if(51<= $z and $z <= 53){
                        $this->api->chat->broadcast("[ISN] " . 'Blue Team Scored !');	
                	$this->api->chat->broadcast('Flag Captured by ' . $username . ' !');
                	
                	 array_push($GLOBALS['BlueSC'],$username);
                	 
                	
                	
                       
                           
                    }}	
                }
                
          }
     }

       
      	if ($item->getMetadata() === 11){
             $search = array_search($username,$Red);
             if ($search !== FALSE){ $this->api->level->getDefault()->setBlock(new Vector3((int) 134, (int) 66, (int) 103), new WoolBlock(14));
      		$x = $target->x;
                $y = $target->y;
                $z = $target->z;
                if(118 <= $x and $x <= 120){if(64 <= $y and $y <= 66){if(102 <= $z and $z <= 104){
                        $this->api->chat->broadcast("[ISN] " . 'Red Team Scored !');	
                	$this->api->chat->broadcast('Flag Captured by ' . $username . ' !');
                	 array_push($GLOBALS['RedSC'],$username);
                
               	
                 	
                }}}
             }
        }
     }                 break;
      
      
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
	 
			   break;}}
	 public function __destruct(){
global $Red,$Blue,$BlueCount,$RedCount;	 	
unset($GLOBALS['Red']);
unset($GLOBALS['Blue']);
    }
 }
         ?>
