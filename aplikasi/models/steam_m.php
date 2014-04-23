<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');
	class Steam_m extends CI_Model {

		const DB_TABLE = 'steam';
		private $user_id;

		public function __construct() {
           parent::__construct();
           $this->set_userid();
       	}

		private function set_userid() {
			$this->user_id = $this->nsession->userdata('USER_ID');
		}

		public function get() {
			$this->db->select('SteamURL, SteamID64, known_as');
			$this->db->from($this::DB_TABLE);
			$this->db->where('user_id', $this->user_id);
			$this->db->order_by('known_as', 'asc');

			$steam = $this->db->get();
			return $steam;
		}

		public function get_count() {
			$this->db->select('SteamID64');
			$this->db->from($this::DB_TABLE);
			$this->db->where('user_id', $this->user_id);

			$steam = $this->db->get();
			return $steam->num_rows();
		}

		public function insert() {
			$steamid64 = $this->getSteamID64($this->input->post('url'));
			$data = array(
				'SteamURL' 	=> 'steamcommunity.com/profiles/' . $steamid64,
				'SteamID64' => $steamid64,
				'known_as' 	=> $this->input->post('known_as'),
				'user_id' 	=> $this->user_id
			);

			$this->db->insert($this::DB_TABLE, $data); 
			return $this->db->affected_rows();
		}


		public function delete($SteamID64) {
			$this->db->delete($this::DB_TABLE, array(
				'SteamID64' => $SteamID64,
				'user_id' => $this->user_id
				)); 
			return $this->db->affected_rows();
		}

		private function getSteamID64($url_input){
			$id_pattern = "/(steamcommunity\.com\/id\/[\w]+)/i";
			$replace_patterns = "/(steamcommunity\.com\/id\/+)/i";
			$profile_pattern = "/(\d+)/i";
			if(preg_match($id_pattern,$url_input,$id_matches)) {
				$steam_id = preg_replace($replace_patterns, '', $id_matches[0]);

				$this->load->library('steamapi',array('key'=> $this->config->item('STEAM_API_KEY')));
				return $this->steamapi->resolveVanityURL($steam_id);
			} else {
				preg_match($profile_pattern, $url_input, $profile_matches);
				return $profile_matches[0];
			}
		}
	}
?>