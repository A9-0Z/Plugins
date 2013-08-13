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

  private $api, $lang, $groupmanager;
private static $cmds = array(
"lobby",
	);

public function __construct(ServerAPI $api, $server = false){
$this->api = $api;
$this->groupmanager = false;
}
    public function init(){
        $this->api->addHandler("player.block.touch", array($this, "touchHandler"));
$this->path = $this->api->plugin->configPath($this);
$this->api->console->register("lobby", "", array($this, "defaultCommands"));
$this->config = new Config($this->path."config.yml", CONFIG_YAML, array(
'BlockId' => '155',
'BlockId2' => '246',
'MsgWhenGiven' => 'Welcome to Skyblock Arena !',
'MsgWhenGiven2' => 'Welcome to Nether Arena !',));
$this->block = (int)$this->config->get('BlockId');
$this->block = (int)$this->config->get('BlockId2');}

    public function touchHandler($data){
        $target = $data["target"];
        if ($target->getID() === $this->block){
$username = $data["player"]->username;
$player = $this->api->player->get($username);
$this->api->console->run("tp $player w:Skyblock");
$this->api->chat->sendTo(false, $this->config->get('MsgWhenGiven'), $username);
}
$target = $data["target"];
        if ($target->getID() === $this->block){
$username = $data["player"]->username;
$player = $this->api->player->get($username);
$this->api->console->run("tp $player w:Nether");
$this->api->chat->sendTo(false, $this->config->get('MsgWhenGiven2'), $username);
}
        
    }
    

    	public function defaultCommands($cmd, $params, $issuer, $alias){
$output = "";
switch($cmd){
case "lobby":
if(!($issuer instanceof Player)){
$output .= "Please run this command in-game.\n";
break;
}
if($this->data[$issuer->iusername]->exists("lobby")){
$this->api->console->run("tp $issuer w:world");}
  }
    	}
public function __destruct(){

    }
    	}

