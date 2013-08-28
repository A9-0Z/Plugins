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
   private $api;
    public function __construct(ServerAPI $api, $server = false){
        $this->api = $api;
    }
         public function init(){
         $this->api->addHandler("player.interact", array($this, "eventHandler"));	
         $this->api->addHandler("player.join", array($this, "eventHandler"));	
         	
         $Red = 'A9_0Z';
         $Blue = 'iamadpond';
         $RedCount = count($Red);
         $BlueCount = count($Blue);
         $this->items = new Config($this->path."items.yml", CONFIG_YAML, array(
			'272' => '1',
			'303' => '1',
			'320' => '5'));
			$this->items = $this->api->plugin->readYAML($this->path . "items.yml");
         }
         
         
   public function eventHandler($data, $event)
	{
		switch ($event) {
			case "player.join":
			   $username = $data["player"]->username;
			   if(stristr($Red, $username) === TRUE){
str_replace($username, '', $Red);
}
            if(stristr($Blue, $username) === TRUE){
str_replace($username, '', $Blue);
}
			   if ($RedCount >= $BlueCount){
			      $Red = $username;
			      $username->addItem((int)298, 0, (int)1);
			      $username->addItem((int)300, 0, (int)1);
			      $this->api->chat->sendTo(false, $this->config->get('You are now a member of team Red'), $username);
			   }
			   else{
			      $Blue = $username
			      $player->addItem((int)310, 0, (int)1);
			      $this->api->chat->sendTo(false, $this->config->get('You are now a member of team Blue'), $username);
			   };
			   
			   foreach($this->items as $id => $count){
				$username->addItem((int)$id, 0, (int)$count);}
			   break;
			   
			case "player.interact":
			   $target = $this->api->entity->get($data["target"]);
                           if(stristr($Blue, $target) === TRUE){ $tarteam = 'Blue'; }
                           if(stristr($Red, $target) === TRUE){ $tarteam = 'Red'; }
                           $username = $data["player"]->username;
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
