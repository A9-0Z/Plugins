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
