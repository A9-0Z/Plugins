<?php
/*
__PocketMine Plugin__
name=IsnTimer
description=Capture the Flag plugin !
version=1.0
author=A9_0Z
class=IsnTimer
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
class IsnTimer implements Plugin{
    private $api, $this, $path, $server, $config;
    public $level;
    private $nr = 0;
    private $timer = 0;
    private $interval;

    public function __construct(ServerAPI $api, $server = false){
        $this->api = $api;
    }

    public function init(){
        $this->score = plugins->Isn-Score->readYAML(plugins->Isn-Score . "scores.yml");
        
       $this->configSC = new Config($this->api->plugin->configPath($this) . "configSC.yml", CONFIG_YAML, array('interval' => 1, 'messages' => array("Example message")));
            $this->interval = $this->configSC->get("interval");
            $this->api->schedule(20 * 60 * $this->interval, array($this, "msg"), array(), false);
               
        $this->configST = new Config($this->api->plugin->configPath($this) . "configST.yml", CONFIG_YAML, array('interval' => 1.3, 'messages' => array("Example message")));
            $this->intervalSt = $this->configSC->get("interval");
            $this->api->schedule(20 * 60 * $this->intervalSt, array($this, "gameTime"), array(), true);}
            
     public function msg() {
        global $BlueSC,$RedSC,$BlueSCount,$RedSCount;
            $GLOBALS['BlueSCount']= $this->score['Blue'];
            $GLOBALS['RedSCount']= $this->score['Red'];
            $messagesArray = $this->configSC->get("messages");
                $message = $messagesArray[$this->nr];
                $this->api->chat->broadcast("[ISN] " . 'Red Team Score = ' . $GLOBALS['RedSCount']);
                $this->api->chat->broadcast("[ISN] " . 'Blue Team Score = ' . $GLOBALS['BlueSCount']);
                    if ($this->nr < count($messagesArray)-1) {
                        $this->nr++;
                    }
               $this->api->schedule(20 * 60 * $this->interval, array($this, "msg"), array(), false);
        }

    public function gameTime() {
        $messagesArray = $this->configSC->get("messages");
        switch($this->timer) {
            case 0:
                global $BlueSC,$RedSC,$BlueSCount,$RedSCount;
                    $GLOBALS['BlueSCount']= $this->score['Blue'];
                    $GLOBALS['RedSCount']= $this->score['Red'];
                    $message = $messagesArray[$this->nr];
                    $this->api->chat->broadcast("[ISN] " . 'There are 10 minutes remaining!');
                    if($this->nr < count($messagesArray)-1) {$this->nr++;}
                    $this->timer++;
                break;
            case 1:
                global $BlueSC,$RedSC,$BlueSCount,$RedSCount;
                    $GLOBALS['BlueSCount']= $this->score['Blue'];
                    $GLOBALS['RedSCount']= $this->score['Red'];
                    $message = $messagesArray[$this->nr];
                    $this->api->chat->broadcast("[ISN] " . 'There are 8 minutes remaining!');
                    if($this->nr < count($messagesArray)-1) {$this->nr++;}
                    $this->timer++;
                break;
            case 2:
                global $BlueSC,$RedSC,$BlueSCount,$RedSCount;
                    $GLOBALS['BlueSCount']= $this->score['Blue'];
                    $GLOBALS['RedSCount']= $this->score['Red'];
                    $message = $messagesArray[$this->nr];
                    $this->api->chat->broadcast("[ISN] " . 'There are 6 minutes remaining!');
                    if($this->nr < count($messagesArray)-1) {$this->nr++;}
                    $this->timer++;
                break;
            case 3:
                global $BlueSC,$RedSC,$BlueSCount,$RedSCount;
                    $GLOBALS['BlueSCount']= $this->score['Blue'];
                    $GLOBALS['RedSCount']= $this->score['Red'];
                    $message = $messagesArray[$this->nr];
                    $this->api->chat->broadcast("[ISN] " . 'There are 4 minutes remaining!');
                    if($this->nr < count($messagesArray)-1) {$this->nr++;}
                    $this->timer++;
                break;
            case 4:
                global $BlueSC,$RedSC,$BlueSCount,$RedSCount;
                    $GLOBALS['BlueSCount']= $this->score['Blue'];
                    $GLOBALS['RedSCount']= $this->score['Red'];
                    $message = $messagesArray[$this->nr];
                    $this->api->chat->broadcast("[ISN] " . 'There are 2 minutes remaining!');
                    if($this->nr < count($messagesArray)-1) {$this->nr++;}
                    $this->timer++;
                break;
            case 5:
                global $BlueSC,$RedSC,$BlueSCount,$RedSCount;
                    $GLOBALS['BlueSCount']= $this->score['Blue'];
                    $GLOBALS['RedSCount']= $this->score['Red'];
                    $message = $messagesArray[$this->nr];
                    $this->api->chat->broadcast("[ISN] " . 'There is 1 minute remaining!');
                    if($this->nr < count($messagesArray)-1) {$this->nr++;}
                    $this->timer++;
                break;
            case 6:
                global $BlueSC,$RedSC,$BlueSCount,$RedSCount;
                    $GLOBALS['BlueSCount']= $this->score['Blue'];
                    $GLOBALS['RedSCount']= $this->score['Red'];
                        if($GLOBALS['RedSCount'] > $GLOBALS['BlueSCount']){$winners = 'The Red Team have won !!';}
                        if($GLOBALS['RedSCount'] < $GLOBALS['BlueSCount']){$winners = 'The Blue Team have won !!';}
                        if($GLOBALS['RedSCount'] === $GLOBALS['BlueSCount']){$winners = 'Ah Really Guys, a DRAW ?!!';}
                            $message = $messagesArray[$this->nr];
                            $this->api->chat->broadcast("[ISN] " . $winners );
                            $this->api->chat->broadcast("[ISN] " . 'Match Finished Thanks for Playing!');
                            if($this->nr < count($messagesArray)-1) {$this->nr++;}
                            
                            /*$this->api->console->run("stop");*/
                }
            }
    
    
    
    public function __destruct(){
    }
 }
