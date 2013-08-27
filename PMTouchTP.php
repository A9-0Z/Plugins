<?php

/*
__PocketMine Plugin__
name=PMTouchTP
description=Tap a specific block to TP !
version=1.0
author=A9_0Z
class=PMTouchTP
apiversion=9
*/

/*
Small Changelog
===============
1.0: Initial release
*/

class PMTouchTP implements Plugin{
   private $api;
    public function __construct(ServerAPI $api, $server = false){
        $this->api = $api;
    }
         public function init(){
        $this->api->addHandler("player.block.touch", array($this, "touchHandler"));
		  $this->path = $this->api->plugin->configPath($this);
		  $this->config = new Config($this->path."config.yml", CONFIG_YAML, array(
'BlockId' => '155',
'BlockId2' => '246',
'BlockId3' => '22',
'MsgWhenGiven' => 'Welcome to Skyblock Arena !',
'MsgWhenGiven2' => 'Welcome to Nether Arena !',
'MsgWhenGiven3' => 'Please stand still until world loads !',
'MsgWhenGiven4' => 'Items Reset !',

$this->items = new Config($this->path."items.yml", CONFIG_YAML, array(
			'262' => '10',
			'261' => '1',
			'272' => '1',
			'303' => '1',
			'272' => '1',)
);
$this->items = $this->api->plugin->readYAML($this->path . "items.yml");
$this->block = (int)$this->config->get('BlockId');
$this->block2 = (int)$this->config->get('BlockId2');
$this->block3 = (int)$this->config->get('BlockId3');}
$this->block4 = (int)$this->config->get('BlockId4');

    public function touchHandler($data){
        $target = $data["target"];
        
        if ($target->getID() === $this->block){
$username = $data["player"]->username;
$player = $this->api->player->get($username);
$this->api->console->run("tp $player 64 64 64");
$this->api->chat->sendTo(false, $this->config->get('MsgWhenGiven'), $username);
$this->api->chat->sendTo(false, $this->config->get('MsgWhenGiven3'), $username);
}
        if ($target->getID() === $this->block2){
$username = $data["player"]->username;
$player = $this->api->player->get($username);
$this->api->console->run("tp $player 44 78 174");
$this->api->chat->sendTo(false, $this->config->get('MsgWhenGiven2'), $username);
$this->api->chat->sendTo(false, $this->config->get('MsgWhenGiven3'), $username);
}
        if ($target->getID() === $this->block2){
$username = $data["player"]->username;
$player = $this->api->player->get($username);
$this->api->console->run("tp $player 44 78 174");
$this->api->chat->sendTo(false, $this->config->get('MsgWhenGiven2'), $username);
$this->api->chat->sendTo(false, $this->config->get('MsgWhenGiven3'), $username);
}
        if ($target->getID() === $this->block){
			$username = $data["player"]->username;
			$player = $this->api->player->get($username);
			foreach($this->items as $id => $count){
				$player->addItem((int)$id, 0, (int)$count);
			}
			$this->api->chat->sendTo(false, $this->config->get('MsgWhenGiven4'), $username);
        } 
    }
    
    public function __destruct(){

    }
}
