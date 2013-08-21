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
'MsgWhenGiven' => 'Welcome to Skyblock Arena !',
'MsgWhenGiven2' => 'Welcome to Nether Arena !',
'MsgWhenGiven3' => 'Please stand still until world loads !',)
);
$this->block = (int)$this->config->get('BlockId');
$this->block2 = (int)$this->config->get('BlockId2');}

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
$this->api->console->run("tp $player -64 -64 64");
$this->api->chat->sendTo(false, $this->config->get('MsgWhenGiven2'), $username);
$this->api->chat->sendTo(false, $this->config->get('MsgWhenGiven3'), $username);
}
        
    }
    
    public function __destruct(){

    }
}
