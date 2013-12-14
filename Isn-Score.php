<?php
/*
__PocketMine Plugin__
name=IsnCTF
description=Capture the Flag plugin !
version=1.0
author=A9_0Z
class=IsnCTF
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
class IsnCTF implements Plugin{
    private $api, $this, $path, $server, $config;
    public $level;
    private $nr = 0;
    private $timer = 0;
    private $interval;

    public function __construct(ServerAPI $api, $server = false){
        $this->api = $api;
    }

    public function init(){
$this->api->addHandler("player.death", array($this, "eventHandler"));
$this->path = $this->api->plugin->configPath($this);
$this->score = new Config($this->path . "scores.yml", CONFIG_YAML, array("Blue" => 0, "Red" => 0));
$this->score = $this->api->plugin->readYAML($this->path . "scores.yml");
}

public function player.death(){
                            global $Red,$Blue,$BlueCount,$RedCount;
                            $GLOBALS['username']= $this->player->username;
                            
                        $searchB = array_search($username,$Blue);
                        if ($searchB !== FALSE){ $bsc = $this->score->get("Blue"); $this->score->set("Blue", $bsc + 1);
                            $this->api->chat->broadcast("[ISN] " . 'Red Team Score = ' . $GLOBALS['RedSCount']);
                            $this->api->chat->broadcast("[ISN] " . 'Blue Team Score = ' . $GLOBALS['BlueSCount']);}
                            
                        $searchR = array_search($username,$Red);
                        if ($searchR !== FALSE){ $rsc = $this->score->get("Red"); $this->score->set("Red", $rsc + 1);
                            $this->api->chat->broadcast("[ISN] " . 'Red Team Score = ' . $GLOBALS['RedSCount']);
                            $this->api->chat->broadcast("[ISN] " . 'Blue Team Score = ' . $GLOBALS['BlueSCount']);}
                        break;
}
public function __destruct(){
    }
 }
