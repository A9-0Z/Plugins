<?php

/*
__PocketMine Plugin__
name=Essentials
description=Essentials
version=1.0.2
author=KsyMC
class=Essentials
apiversion=9
*/

/*
Small Changelog
===============

1.0:
- Release

*/

class Essentials implements Plugin{
  private $api, $lang, $groupmanager;
	private static $cmds = array(
		"home",
		"sethome",
		"delhome",
		"mute",
		"back",
		"tree",
		"setspawn",
		"burn",
		"kickall",
		"killall",
		"heal",
		"clearinventory",
		"gamemode",
		"tp",
		"spawn",
		"tell", // Ãß°¡ ½ÃÀÛ ÇÊ¿ä
		"me",
		"say",
		"give",
		"banip",
		"ban",
		"kick",
		"whitelist",
		"op",
		"deop",
		"ping",
		"sudo",
		"difficulty",
		"defaultgamemode",
		"help",
		"list",
		"time", // end
		"login",
		"logout",
		"register",
		"unregister",
		"changepassword",
	);
	
	public function __construct(ServerAPI $api, $server = false){
		$this->api = $api;
		$this->groupmanager = false;
	}
	
	public function init(){
		$this->api->event("server.close", array($this, "handler"));
		$this->api->addHandler("player.join", array($this, "handler"), 5);
		$this->api->addHandler("player.quit", array($this, "handler"), 5);
		$this->api->addHandler("player.chat", array($this, "handler"), 5);
		$this->api->addHandler("player.teleport", array($this, "handler"), 5);
		$this->api->addHandler("player.spawn", array($this, "initPlayer"), 5);
		$this->api->addHandler("player.respawn", array($this, "handler"), 5);
		$this->api->addHandler("player.block.break", array($this, "handler"), 5);
		$this->api->addHandler("console.check", array($this, "permissionsCheck"), 5);
		$this->api->addHandler("groupmanager.permission.check", array($this, "permissionsCheck"), 1);
		
		$this->api->console->register("home", "", array($this, "defaultCommands"));
		$this->api->console->register("sethome", "", array($this, "defaultCommands"));
		$this->api->console->register("delhome", "", array($this, "defaultCommands"));
		$this->api->console->register("mute", "<player>", array($this, "defaultCommands"));
		$this->api->console->register("back", "", array($this, "defaultCommands"));
		$this->api->console->register("tree", "<tree|brich|redwood>", array($this, "defaultCommands"));
		$this->api->console->register("setspawn", "", array($this, "defaultCommands"));
		$this->api->console->register("burn", "<player> <seconds>", array($this, "defaultCommands"));
		$this->api->console->register("kickall", "[reason]", array($this, "defaultCommands"));
		$this->api->console->register("killall", "[reason]", array($this, "defaultCommands"));
		$this->api->console->register("heal", "[player]", array($this, "defaultCommands"));
		$this->api->console->register("clearinventory", "[player] [item]", array($this, "defaultCommands"));
		$this->api->console->register("gamemode", "<mode> [player]", array($this, "defaultCommands"));
		$this->api->console->register("tp", "[target player] <destination player|w:world> OR /tp [target player] <x> <y> <z>", array($this, "defaultCommands"));
		$this->api->console->register("spawn", "[player]", array($this, "defaultCommands"));
		if(file_exists(DATA_PATH."/plugins/GroupManager.php")){
			$this->groupmanager = true;
		}
		$this->readConfig();
	}
	
	public function __destruct(){
	}
	
	public function readConfig(){
		$this->path = $this->api->plugin->createConfig($this, array(
			"login" => array(
				"allow-non-loggedIn" => array(
					"chat" => false,
					"commands" => array(),
					"moving" => true,
					"damage" => false,
				),
				"kick-on-wrong-password" => array(
					"enable" => false,
					"count" => 5,
				),
			),
			"chat-format" => "<{DISPLAYNAME}> {MESSAGE}",
			"blacklist" => array(
				"placement" => '',
				"usage" => '',
				"break" => '',
			),
			"kits" => array(),
			"newbies" => array(
				"kit" => "",
				"message" => "Welcome {DISPLAYNAME} to the server!",
			),
			"creative-item" => array(
				"op" => array(),
				"default" => array(),
			),
			"player-commands" => array(),
		));
		if(!file_exists($this->path."messages.yml")){
			console("[ERROR] \"messages.yml\" file not found!");
		}else{
			$this->lang = new Config($this->path."messages.yml", CONFIG_YAML);
		}
		if(is_dir("./plugins/Essentials/userdata/") === false){
			mkdir("./plugins/Essentials/userdata/");
		}
		$this->config = $this->api->plugin->readYAML($this->path."config.yml");
	}
	
	public function permissionsCheck($data, $event){
		switch($event){
			case "groupmanager.permission.check": // GroupManager
				if(in_array(substr($data["permission"], 11), $this->config["player-commands"])){
					return true;
				}
				return false;
			case "console.check":
				if($this->groupmanager === true and !in_array($data["cmd"], self::$cmds)){
					break;
				}
				return $this->isAuthorized($data["issuer"], $data["cmd"]);
		}
	}
	
	public function initPlayer($data, $event){
		if($this->data[$data->iusername]->get("newbie")){
			switch($data->gamemode){
				case SURVIVAL:
					if(!array_key_exists($this->config["newbies"]["kit"], $this->config["kits"])){
						break;
					}
					$kits = $this->config["kits"][$this->config["newbies"]["kit"]];
					foreach($kits as $kit){
						$kit = explode(" ", $kit);
						$item = BlockAPI::fromString(array_shift($kit));
						$count = $kit[0];
						$data->addItem($item->getID(), $item->getMetadata(), $count);
					}
					break;
				case CREATIVE:
					break;
			}
			$data->sendChat(str_replace(array("{DISPLAYNAME}", "{WORLDNAME}"), array($data->username, $data->level->getName()), $this->config["newbies"]["message"]));
			$this->data[$data->iusername]->set("newbie", false);
		}
		if($data->gamemode === CREATIVE){
			$type = $this->api->ban->isOp($data->iusername) ? "op" : "default";
			$creative = $this->config["creative-item"][$type];
			foreach($creative as $item){
				$item = explode(" ", $item);
				$data->setSlot($item[0], BlockAPI::fromString($item[1]));
			}
		}
	}
	
	public function isAuthorized($issuer, $cmd, $permission = ""){
		if($this->api->dhandle("groupmanager.permission.check", array("issuer" => $issuer, "permission" => "essentials.$cmd".($permission != "" ? ".$permission" : ""))) === true){
			return true;
		}
		return false;
	}
	
	public function handler(&$data, $event){
		switch($event){
			case "player.join":
					$spawn = $data->level->getSpawn();
					$this->data[$data->iusername] = new Config(DATA_PATH."/plugins/Essentials/userdata/".$data->iusername.".yml", CONFIG_YAML, array(
						"ipAddress" => $data->ip,
						"mute" => false,
						"newbie" => true,
					));
				break;
			case "player.quit":
				if($this->data[$data->iusername] instanceof Config){
					$this->data[$data->iusername]->save();
				}
				break;
			case "player.chat":
				$data = array("player" => $data["player"], "message" => str_replace(array("{DISPLAYNAME}", "{MESSAGE}", "{WORLDNAME}"), array($data["player"]->username, $data["message"], $data["player"]->level->getName()), $this->config["chat-format"]));
				if($this->api->handle("essentials.".$event, $data) !== false){
					$this->api->chat->broadcast($data["message"]);
				}
				return false;
			case "player.respawn":
				$data->sendChat($this->getMessage("backAfterDeath"));
				break;
			case "player.teleport":
				$this->data[$data["player"]->iusername]->set("lastlocation", array(
					"world" => $data["player"]->level->getName(),
					"x" => $data["player"]->entity->x,
					"y" => $data["player"]->entity->y,
					"z" => $data["player"]->entity->z,
				));
				break;
			case "player.block.break":
				if($data["target"]->getID() === SIGN_POST or $data["target"]->getID() === WALL_SIGN){
					$t = $this->api->tile->get($data["target"]);
					$this->api->tile->remove($t->id);
				}
				break;
		}
	}
	
	public function defaultCommands($cmd, $params, $issuer, $alias){
		$output = "";
		switch($cmd){
			case "home":
				if(!($issuer instanceof Player)){
					$output .= "Please run this command in-game.\n";
					break;
				}
				if($this->data[$issuer->iusername]->exists("home")){
					$home = $this->data[$issuer->iusername]->get("home");
					$name = $issuer->iusername;
					if($home["world"] !== $issuer->level->getName()){
						$this->api->player->teleport($name, "w:".$home["world"]);
					}
					$this->api->player->tppos($name, $home["x"], $home["y"], $home["z"]);
				}else{
					$output .= "You do not have a home.\n";
				}
				break;
			case "sethome":
				if(!($issuer instanceof Player)){
					$output .= "Please run this command in-game.\n";
					break;
				}
				$this->data[$issuer->iusername]->set("home", array(
					"world" => $issuer->level->getName(),
					"x" => $issuer->entity->x,
					"y" => $issuer->entity->y,
					"z" => $issuer->entity->z,
				));
				$output .= "Your home has been saved.\n";
				break;
			case "delhome":
				if(!($issuer instanceof Player)){
					$output .= "Please run this command in-game.\n";
					break;
				}
				$spawn = $issuer->level->getSpawn();
				$this->data[$issuer->iusername]->remove("home");
				$output .= "Your home has been deleted.\n";
				break;
			case "back":
				if(!($issuer instanceof Player)){
					$output .= "Please run this command in-game.\n";
					break;
				}
				if($this->data[$issuer->iusername]->exists("lastlocation")){
					$backpos = $this->data[$issuer->iusername]->get("lastlocation");
					$name = $issuer->iusername;
					if($backpos["world"] !== $issuer->level->getName()){
						$this->api->player->teleport($name, "w:".$backpos["world"]);
					}
					$this->api->player->tppos($name, $backpos["x"], $backpos["y"], $backpos["z"]);
					$output .= $this->getMessage("backUsageMsg");
				}
				break;
			case "tree":
				if(!($issuer instanceof Player)){
					$output .= "Please run this command in-game.\n";
					break;
				}
				switch(strtolower($params[0])){
					case "redwood":
						$meta = 1;
						break;
					case "brich":
						$meta = 2;
						break;
					case "tree":
						$meta = 0;
						break;
					default:
						$output .= "Usage: /$cmd <tree|brich|redwood>\n";
						break 2;
				}
				TreeObject::growTree($issuer->level, new Vector3 (((int)$issuer->entity->x), ((int)$issuer->entity->y), ((int)$issuer->entity->z)), new Random(), $meta);
				$output .= $this->getMessage("treeSpawned");
				break;
			case "setspawn":
				if(!($issuer instanceof Player)){
					$output .= "Please run this command in-game.\n";
					break;
				}
				$pos = new Vector3(((int)$issuer->entity->x + 0.5), ((int)$issuer->entity->y), ((int)$issuer->entity->z + 0.5));
				$output .= "Spawn location set.\n";
				$issuer->level->setSpawn($pos);
				break;
			case "mute":
				if($params[0] == ""){
					$output .= "Usage: /$cmd <player>\n";
					break;
				}
				$target = $this->api->player->get($params[0]);
				if($target === false){
					$output .= $this->getMessage("playerNotFound");
					break;
				}
				if($this->data[$target->iusername]->get("mute") === false){
					$output .= "Player ".$target->username." muted.\n";
					$target->sendChat($this->getMessage("playerMuted"));
					$this->data[$target->iusername]->set("mute", true);
				}else{
					$output .= "Player ".$target->username." unmuted.\n";
					$target->sendChat($this->getMessage("playerUnmuted"));
					$this->data[$target->iusername]->set("mute", false);
				}
				break;
			case "burn":
				if($params[0] == "" or $params[1] == ""){
					$output .= "Usage: /$cmd <player> <seconds>\n";
					break;
				}
				$seconds = (int)$params[1];
				$player = $this->api->player->get($params[0]);
				if($player === false){
					$output .= $this->getMessage("playerNotFound");
					break;
				}
				$player->entity->fire = $seconds * 20;
				$player->entity->updateMetadata();
				$output .= $this->getMessage("burnMsg", array($player->username, $seconds));
				break;
			case "kickall":
				$reason = "";
				if($params[0] != ""){
					$reason = $params[0];
				}
				foreach($this->api->player->online() as $username){
					$this->api->ban->kick($username, $reason);
				}
				break;
			case "killall":
				$reason = "";
				if($params[0] != ""){
					$reason = $params[0];
				}
				foreach($this->api->player->online() as $username){
					$target = $this->api->player->get($username);
					$this->api->entity->harm($target->eid, 3000, $reason);
				}
				break;
			case "heal":
				if(!($issuer instanceof Player) and $params[0] == ""){
					$output .= "Usage: /$cmd <player>\n";
					break;
				}
				if($this->isAuthorized($issuer, $cmd, "others") !== false){
					if($params[0] != ""){
						$issuer = $this->api->player->get($params[0]);
						if($issuer === false){
							$output .= $this->getMessage("playerNotFound");
							break;
						}
					}
				}
				$this->api->entity->heal($issuer->eid, 20);
				break;
			case "clearinventory":
				if(!($issuer instanceof Player) and $params[0] == ""){
					$output .= "Usage: /$cmd <player> [item]\n";
					break;
				}
				if($this->isAuthorized($issuer, $cmd, "others") !== false){
					if($params[0] != ""){
						$issuer = $this->api->player->get($params[0]);
						if($issuer === false){
							$output .= $this->getMessage("playerNotFound");
							break;
						}
					}
				}
				if($issuer->gamemode === CREATIVE){
					$output .= "Player is in creative mode.\n";
					break;
				}
				if($params[1] != ""){
					$item = BlockAPI::fromString($params[1]);
				}
				foreach($issuer->inventory as $slot => $data){
					if(isset($item) and $item->getID() !== $data->getID()){
						continue;
					}
					$issuer->setSlot($slot, BlockAPI::getItem(AIR, 0, 0));
				}
				$output .= $params[0] == "" ? $this->getMessage("inventoryCleared") : $this->getMessage("inventoryClearedOthers", array($issuer->username));
				break;
			case "gamemode":
				if($this->isAuthorized($issuer, $cmd, "others") === false){
					if($params[1] != ""){
						unset($params[1]);
					}
				}
				$output .= $this->api->player->commandHandler($cmd, $params, $issuer, $alias);
				break;
			case "tp":
				if($this->isAuthorized($issuer, $cmd, "others") === false){
					if($params[1] != ""){
						$output .= "You don't have permission to use this command.\n";
						break;
					}
				}
				if($issuer instanceof Player and $params[0] != "" and strpos($params[0], "w:") !== false){
					if($this->isAuthorized($issuer, $cmd, "worlds.".substr($params[0], 2)) === false){
						$output .= "You don't have permission to use this command.\n";
						break;
					}
				}
				$output .= $this->api->player->commandHandler($cmd, $params, $issuer, $alias);
				break;
			case "spawn":
				if($this->isAuthorized($issuer, $cmd, "others") !== false){
					if($params[0] != ""){
						$issuer = $this->api->player->get($params[0]);
						if($issuer === false){
							$output .= $this->getMessage("playerNotFound");
							break;
						}
					}
				}
				$output .= $this->api->player->commandHandler($cmd, $params, $issuer, $alias);
				break;
		}
		return $output;
	}
	

}
