<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');
	class Home extends CI_Controller {

		public function __construct() {
        	parent::__construct();
			$this->output->set_header('Last-Modified:'.gmdate('D, d M Y H:i:s').'GMT');
			$this->output->set_header('Cache-Control: no-store, no-cache, must-revalidate');
			$this->output->set_header('Cache-Control: post-check=0, pre-check=0',false);
			$this->output->set_header('Pragma: no-cache');
       	}

		public function index() {
			if($this->nsession->userdata('LOGIN')=='TRUE'){
				$this->load->view('header_v');

				$this->load->library('table');
				$this->load->library('steamapi',array('key'=> $this->config->item('STEAM_API_KEY')));
				$this->load->library('twitchapi',array('key'=> $this->config->item('TWITCH_API_KEY')));
				$this->load->model(array('Steam_m','Twitch_m'));

				$t_steam = array();
				$m_steam = $this->Steam_m->get();
				foreach ($m_steam->result() as $row) {
					$steam = $this->steamapi->getPlayerSummary($row->SteamID64);
					if ('Steam Offline' != $steam['status']) {
						$avatar = '<img src="' . $steam['avatar'] . '" alt="' . $steam['username'] . '" class="img-thumbnail avatar-table">';
						$detail = anchor('steam/detail/' . $row->SteamID64, 'Detail','class="btn btn-info"');
					} else {
						$avatar = '<img src="' . base_url('img/steam-icon.png') . '" alt="Steam Offline" class="img-thumbnail avatar-table">';
						$detail = '<button type="button" class="btn btn-info">' . $steam['status'] . '</button>';
					}
					
					$t_steam[] = array(
						$avatar,
						$row->known_as,
						$row->SteamURL,
						$steam['status'],
						$detail
						. ' | ' .
						anchor('steam/remove/' . $row->SteamID64 . '/' . rawurlencode($row->known_as), 'Remove', array(
							'id=' => $row->known_as,
							'class' => 'btn btn-danger'
						)));
				}

				$t_twitch = array();
				$m_twitch = $this->Twitch_m->get();
				foreach ($m_twitch->result() as $row) {
					$twitch = $this->twitchapi->getStream($row->channel);
					if ('Online' == $twitch['online']) {
						$avatar = '<img src="' . $twitch['logo'] . '" alt="' . $twitch['display_name'] . '" class="img-thumbnail avatar-table">';
						$online = $twitch['online'] . ' - ' . $twitch['game'];
					} else {
						$avatar = '<img src="' . base_url('img/twitch-logo-purple.png') . '" alt="Offline" class="img-thumbnail avatar-table">';
						$online = $twitch['online'];
					}
					$t_twitch[] = array(
						$avatar,
						$row->known_as,
						$row->TwitchURL,
						$online,
						anchor('twitch/detail/' . $row->channel, 'Detail','class="btn btn-info"') 
						. ' | ' .
						anchor('twitch/remove/' . $row->channel . '/' . rawurlencode($row->known_as), 'Remove', array(
							'id=' => $row->known_as,
							'class' => 'btn btn-danger'
						)));
				}

				$this->load->view('home_v',array(
					'steam' => $t_steam,
					'twitch' => $t_twitch
				));

		        $this->load->view('footer_v');
	    	} else { //login
	    		redirect('auth');
	    	}
		}
	}
?>