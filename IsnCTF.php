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
         $this->api->addHandler("player.connect", array($this, "eventHandler"));	
         	
         $Red = '';
         $Blue = '';
         $RedCount = count($Red);
         $BlueCount = count($Blue);
         
         $this->config = new Config($this->path."config.yml", CONFIG_YAML, array(
                        'msgBLUE' => 'You are now a member of team Blue !', 
                        'msgRED' => 'You are now a member of team Red !',));
         
         
         $this->items = new Config($this->path."items.yml", CONFIG_YAML, array(
			'272' => '1',
			'303' => '1',
			'320' => '5'));
			$this->items = $this->api->plugin->readYAML($this->path . "items.yml");
         }
         
         
   public function eventHandler($data, $event)
	{
		switch ($event) {
			case "player.connect":
                           $username = $data["player"]->username;
                           $player = $data;
			   if(stristr($Red, $username) === TRUE){
str_replace($username, '', $Red);
}
            if(stristr($Blue, $username) === TRUE){
str_replace($username, '', $Blue);
}
			   if ($RedCount >= $BlueCount){
			      $Red = $username;
			      $player->addItem((int)298, 0, (int)1);
			      $player->addItem((int)300, 0, (int)1);
			      $this->api->chat->sendTo(false, $this->config->get('msgRED'), $username);
			   }
			   else{
			      $Blue = $username;
			      $player->addItem((int)310, 0, (int)1);
			      $this->api->chat->sendTo(false, $this->config->get('msgBLUE'), $username);
			   };
			   
			   foreach($this->items as $id => $count){
				$player->addItem((int)$id, 0, (int)$count);}
			   break;
			   
			case "player.interact":
			   $target = $this->api->entity->get($data["target"]);
                           if(stristr($Blue, $target) === TRUE){ $tarteam = 'Blue'; }
                           if(stristr($Red, $target) === TRUE){ $tarteam = 'Red'; }
                           if(stristr($Red, $username) === TRUE){ $plateam = 'Red'; }
                           if(stristr($Blue, $username) === TRUE){ $plateam = 'Blue'; }
                           if($tarteam === $plateam ){
                           return false;
                           }
	
			   break;}}
	 public function __destruct(){
unset($Red, $Blue);
    }
 }
         ?>
