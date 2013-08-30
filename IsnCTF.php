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
1.0: Initial release
*/
class IsnCTF implements Plugin{
   private $api, $path;
    public function __construct(ServerAPI $api, $server = false){
        $this->api = $api;
    }
         public function init(){
         $this->api->addHandler("player.interact", array($this, "eventHandler"));       
         $this->api->addHandler("player.spawn", array($this, "eventHandler"));        
                
         $GLOBALS['Red']= 'PlaceHold1';
         $GLOBALS['Blue']= 'PlaceHold2';
         $GLOBALS['RedCount']= count($Red);
         $GLOBALS['BlueCount']= count($Blue);
         
         $this->config = new Config($this->api->plugin->configPath($this)."config.yml", CONFIG_YAML, array(
                        'msgBLUE' => 'You are now a member of team Blue !', 
                        'msgRED' => 'You are now a member of team Red !',));
                        $this->config = $this->api->plugin->readYAML($this->api->plugin->configPath($this). "config.yml");
         
         $this->items = new Config($this->api->plugin->configPath($this)."items.yml", CONFIG_YAML, array(
                        '272' => '1',
                        '303' => '1',
                        '320' => '5'));
                        $this->items = $this->api->plugin->readYAML($this->api->plugin->configPath($this). "items.yml");
         }


    
         
         
   public function eventHandler($data, $event)
	{
		global $Red,$Blue,$BlueCount,$RedCount,$username,$player;
		
		switch ($event) {
			case "player.spawn":
		          global $Red,$Blue,$BlueCount,$RedCount,$username,$player;
                          $GLOBALS['username']= $this->api->player->get($data->iusername);
                          $GLOBALS['player']= $data;
			   if(stristr($Red, $username) === TRUE){
str_replace($username, '', $Red);
}
            if(stristr($Blue, $username) === TRUE){
str_replace($username, '', $Blue);
}
                         
			   if ($RedCount <= $BlueCount){
		       $GLOBALS['Red'] = $username;
			      $player->addItem((int)298, 0, (int)1);
			      $player->addItem((int)300, 0, (int)1);
			      $username->sendChat('You are now a member of team Red !');
			   
			   } else {
	               $GLOBALS['Blue']= $username;
			      $player->addItem((int)310, 0, (int)1);
			      $username->sendChat('You are now a member of team Blue !');
			   };
			   
			   foreach($this->items as $id => $count){
				$player->addItem((int)$id, 0, (int)$count);}
			   break;
			   
			case "player.interact":
			   global $Red,$Blue,$BlueCount,$RedCount,$username,$player;	
			
      $player = $this->api->player->getbyEID($data["entity"]->eid);
      $target = $this->api->player->getbyEID($data["targetentity"]->eid);
     /* if($source != instanceof Player or $target != instanceof Player) {
       $this->throwUnhandledErrorException(NOT_OBJECT);
      } else { */
      $usernameP = $player->username; 
       $target = $target->username;
   
                           if(stristr($Blue, $target) === TRUE){  $GLOBALS['tarteam'] = 'Blue'; }
                           if(stristr($Red, $target) === TRUE){ $GLOBALS['tarteam'] = 'Red'; }
                           if(stristr($Red, $usernameP) === TRUE){ $GLOBALS['plateam'] = 'Red'; }
                           if(stristr($Blue, $usernameP) === TRUE){ $GLOBALS['plateam'] = 'Blue'; }
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
