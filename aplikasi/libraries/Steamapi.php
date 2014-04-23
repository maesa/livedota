<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
	
	class SteamAPI {

		public function __construct($params){
			$this->baseURL = 'http://api.steampowered.com/';
			$this->key = $params['key'];
	    }

	    public function getPlayerSummary($steamid){
	    	
	    	$url = $this->baseURL."ISteamUser/GetPlayerSummaries/v0002/?key=".$this->key."&steamids=".$steamid;

	    	try {
	    		$steamresponse = json_decode(file_get_contents($url));
	    	
		    	if (3 == $steamresponse->response->players[0]->communityvisibilitystate) {//1-private 3-public
			    	switch ($steamresponse->response->players[0]->personastate) {
		        		case 0: //0 - Offline
			                $status = "Offline";
			                break;
		                case 1: //1 - Online
			                $status = "Online";
			                break;
		                case 2: //2 - Busy
			                $status = "Busy";
			                break;
		                case 3: //3 - Away
			                $status = "Away";
			                break;
		                case 4: //4 - Snooze
			                $status = "Snooze";
			                break;
		                case 5: //5 - Looking to trade
			                $status = "Looking to trade";
			                break;
		                case 6: //6 - Looking to play
			                $status = "Looking to play";
			                break;
		                default: 
			                $status = "Unknown";
			                break;
		            } //switch
	        	} else {
	        		$status = 'Private';
	        	}

		    	$result = array(
		    		'avatar' => $steamresponse->response->players[0]->avatar,
		    		'avatarfull' => $steamresponse->response->players[0]->avatarfull,
		    		'username' => htmlentities($steamresponse->response->players[0]->personaname, ENT_QUOTES),
		    		'privacy' => $steamresponse->response->players[0]->communityvisibilitystate,
		    		'status' => $status,
		    		'steamurl' => $steamresponse->response->players[0]->profileurl
		    		);
	    	} catch (Exception $e) {
	    		$result = array(
		    		'avatar' => '',
		    		'avatarfull' => '',
		    		'username' => '',
		    		'privacy' => '',
		    		'status' => 'Steam Offline',
		    		'steamurl' => ''
	    		);
	    	}

	    	return $result;
	    } //getPlayerSummary

	    public function resolveVanityURL($steam_customprofile) {
	    	$steamresponse = json_decode(file_get_contents($this->baseURL."ISteamUser/ResolveVanityURL/v0001/?key=".$this->key."&vanityurl=".$steam_customprofile));

	    	if (1 == $steamresponse->response->success) {
	    		return $steamresponse->response->steamid;
	    	}

	    	return NULL;
	    }
	}
?>