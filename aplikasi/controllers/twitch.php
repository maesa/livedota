<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');
	class Twitch extends CI_Controller {

		public function __construct() {
			parent::__construct();
			$this->output->set_header('Last-Modified:'.gmdate('D, d M Y H:i:s').'GMT');
			$this->output->set_header('Cache-Control: no-store, no-cache, must-revalidate');
			$this->output->set_header('Cache-Control: post-check=0, pre-check=0',false);
			$this->output->set_header('Pragma: no-cache');
			$this->load->model('Twitch_m');
       	}

       	public function detail($channel) {
       		$this->load->library('twitchapi',array('key'=> $this->config->item('TWITCH_API_KEY')));
       		$online = $this->twitchapi->getStream($channel);
       		$data['channel'] = $channel;
       		$data['title'] = $online['online'] == 'Online'?$online['display_name'] . ' - ' . $online['status'] : $online['online'];
			$this->load->view('header_v');
       		$this->load->view('twitch_v', $data);
       		$this->load->view('footer_v');
       	}

       	private function addurl_view() {
       		$data['title'] = 'Add Twitch Channel'; 
	    	$data['action'] = site_url('twitch/insert');
	    	$data['placeholder_url'] = 'twitch.tv/sing_sing';
	    	$data['placeholder_aka'] = 'C9.SingSing';
	    	$this->load->view('header_v');
			$this->load->view('addurl_v', $data);
			$this->load->view('footer_v');
       	}

		public function index() {
			if($this->nsession->userdata('LOGIN')=='TRUE'){
				$this->addurl_view();
			} else {
				redirect('auth');
			}
		}

		public function insert() {
			$this->load->helper("form");
			$this->form_validation->set_rules(array(
				array(
					'field' => 'url',
					'label' => 'Twitch URL',
					'rules' => 'required|callback_twitch_url_validation'
				),
				array(
					'field' => 'known_as',
					'label' => 'Nickname',
					'rules' => 'required'
				)
			));

			if(!$this->form_validation->run()) {
				$this->addurl_view();
			} else {
				//check if success
				if ($this->Twitch_m->insert() > 0) {
					$data['message'] = 'New Twitch Channel has been added successfully';
				} else {
					$data['message'] = 'Unable to add Twitch Channel';
				}
				$data['location'] = site_url('home');
				//notify then redirect
				$this->load->view('header_v');
		        $this->load->view('notification_v', $data);
		        $this->load->view('footer_v');
			}

		}

		public function remove($channel) {
			$known_as = $this->uri->segment(4);

			$data['title'] = 'Remove Twitch Channel'; 
   			$data['action'] = site_url('twitch/delete/' . $channel);
   			$data['placeholder_url'] = 'twitch.tv/' . $channel;
   			$data['placeholder_aka'] = rawurldecode($known_as);
   			$this->load->view('header_v');
	        $this->load->view('delurl_v', $data);
	        $this->load->view('footer_v');
		}

		public function delete($channel) {
			//confirmation
			//check if success
			if ($this->Twitch_m->delete($channel) > 0) {
				$data['message'] = 'Twitch Channel has been removed successfully';
			} else {
				$data['message'] = 'Unable to remove Twitch Channel';
			}
			$data['location'] = site_url('home');
			//notify then redirect
			$this->load->view('header_v');
	        $this->load->view('notification_v', $data);
	        $this->load->view('footer_v');
		}

		public function twitch_url_validation($input) {
			$url_pattern = "/((https?:\/{2}|www\.)?twitch\.tv\/[\w-]+\/?)/i";
			if (!preg_match($url_pattern, $input, $matches)) {
				$this->form_validation->set_message('twitch_url_validation', 'Invalid Twitch URL.');
				return FALSE;
			}
			return TRUE;
		}
	}
?>