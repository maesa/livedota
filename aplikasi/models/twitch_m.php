<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');
	class Twitch_m extends CI_Model {

		const DB_TABLE = 'twitch';
		private $user_id;

		public function __construct() {
           parent::__construct();
           $this->set_userid();
       	}

		private function set_userid() {
			$this->user_id = $this->nsession->userdata('USER_ID');
		}

		public function get() {
			$this->db->select('TwitchURL, channel, known_as');
			$this->db->from($this::DB_TABLE);
			$this->db->where('user_id', $this->user_id);
			$this->db->order_by('TwitchURL', 'asc');

			$twitch = $this->db->get();
			return $twitch;
		}

		public function get_count() {
			$this->db->select('channel');
			$this->db->from($this::DB_TABLE);
			$this->db->where('user_id', $this->user_id);

			$twitch = $this->db->get();
			return $twitch->num_rows();
		}

		public function insert() {
			$regex_pattern = "/(twitch\.tv\/[\w-]+)/i";
			preg_match($regex_pattern, $this->input->post('url'), $matches);
			$data = array(
				'TwitchURL' => $matches[0],
				'channel' 	=> str_replace('twitch.tv/', '', $matches[0]),
				'known_as' 	=> $this->input->post('known_as'),
				'user_id' 	=> $this->user_id
			);

			$this->db->insert($this::DB_TABLE, $data); 
			return $this->db->affected_rows();
		}

		public function delete($channel) {
			$this->db->delete($this::DB_TABLE, array(
				'channel' => $channel,
				'user_id' => $this->user_id
				)); 
			return $this->db->affected_rows();
		}
	}
?>