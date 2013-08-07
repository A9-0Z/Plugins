<?php

/*
__PocketMine Plugin__
name=PMTouchBlock
description=Tap a specific block to receive PM !
version=1.0
author=A9_0Z
class=PMTouchBlock
apiversion=9
*/

/* 
Small Changelog
===============
1.0: Initial release
*/

class PMTouchBlock implements Plugin{
    private $api;
    public function __construct(ServerAPI $api, $server = false){
        $this->api = $api;
    }
    public function init(){
        $this->api->addHandler("player.block.touch", array($this, "touchHandler"));
		$this->path = $this->api->plugin->configPath($this);
		$this->config = new Config($this->path."config.yml", CONFIG_YAML, array(
			'BlockId' => '246',
			'MsgWhenGiven' => 'You have been awarded 500 PM !',
		));
		$data = array(
			'issuer' => 'PMTouchBlock',
			'username' => 'usrnme',
			'method' => 'grant',
			'amount' => 500);
			
			$this->api->addHandler("player.block.touch", $data);
    }
	
    public function touchHandler($data1){
        $target = $data1["target"];
        if ($target->getID() === $this->block){
			$usernameA = $data1["player"]->usrnme;
			$player = $this->api->player->get($usernameA);
			$this->api->dhandle("player.block.touch", $data)
			}
			$this->api->chat->sendTo(false, $this->config->get('MsgWhenGiven'), $usernameA);
        }
    }
	
    public function __destruct(){
	
    }
}
