<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
	
	class TwitchAPI {

		public function __construct($params){
			$this->baseURL = 'https://api.twitch.tv/kraken/';
			$this->key = $params['key'];
	    }

	    public function getStream($channel) {
	    	
	    	$url = $this->baseURL.'streams/'.$channel.'?client_id='.$this->key;
	    	$result = array();

	    	try {
	    		$twitchresponse = json_decode(file_get_contents($url));	

		    	if ($twitchresponse->stream != NULL) {
		    		$result = array(
			    		'online' => 'Online',
			    		'game' => $twitchresponse->stream->channel->game,
			    		'status' => $twitchresponse->stream->channel->status,
			    		'display_name' => $twitchresponse->stream->channel->display_name,
			    		'logo' => $twitchresponse->stream->channel->logo
		    		);
		    	} else {
		    		$result = array(
			    		'online' => 'Offline',
			    		'game' => '',
			    		'status' => '',
			    		'display_name' => '',
			    		'logo' => ''
		    		);
		    	}

	    	} catch (Exception $e) {
	    		$result = array(
		    		'online' => 'Offline',
		    		'game' => '',
		    		'status' => '',
		    		'display_name' => '',
		    		'logo' => ''
	    		);
	    	}
	    	
	    	return $result;
	    }
	}
?>