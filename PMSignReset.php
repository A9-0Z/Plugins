<?php

/*
__PocketMine Plugin__
name=PMSignReset
description=Tap a specific block to receive PM !
version=1.0
author=A9_0Z
class=PMSignReset
apiversion=9
*/

/* 
Small Changelog
===============
1.0: Initial release
*/

class PMSignReset implements Plugin{
    private $api;
    public function __construct(ServerAPI $api, $server = false){
        $this->api = $api;
    }
    public function init(){
        $this->api->addHandler("player.block.touch", array($this, "touchHandler"));
  	$this->path = $this->api->plugin->configPath($this);
		$this->config = new Config($this->path."config.yml", CONFIG_YAML, array(
			'BlockId' => '248',
			'MsgWhenGiven' => 'Signs reset !',
		));

		$this->block = (int)$this->config->get('BlockId'); }

    public function touchHandler($data){
        $target = $data["target"];
        if ($target->getID() === $this->block){
			$username = $data["player"]->username;
			$player = $this->api->player->get($username);
      $sign = getByID("Sign");
      spawnToAll($signs);
			$this->api->chat->sendTo(false, $this->config->get('MsgWhenGiven'), $username);
			}

        
    }

    public function __destruct(){

    }
}
