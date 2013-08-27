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
         $this->config = new Config($this->path."config.yml", CONFIG_YAML, array(
         'Blue' =>
         ,'Red'  =>
         } ?>
