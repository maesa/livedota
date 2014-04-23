<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');
	class Steam extends CI_Controller {

		public function __construct() {
			parent::__construct();
			$this->output->set_header('Last-Modified:'.gmdate('D, d M Y H:i:s').'GMT');
			$this->output->set_header('Cache-Control: no-store, no-cache, must-revalidate');
			$this->output->set_header('Cache-Control: post-check=0, pre-check=0',false);
			$this->output->set_header('Pragma: no-cache');
			$this->load->model('Steam_m');
       	}

       	public function detail($steamid64) {
       		//masih bisa dikembangkan lagi agar lebih detail
       		$this->load->library('steamapi',array('key'=> $this->config->item('STEAM_API_KEY')));
       		$summary = $this->steamapi->getPlayerSummary($steamid64);
       		$data['avatar'] = $summary['avatarfull'];
       		$data['status'] = $summary['username'] . ' is ' . $summary['status'];
       		$data['steam_url'] = $summary['steamurl'];
       		$this->load->view('header_v');
       		$this->load->view('steam_v', $data);
       		$this->load->view('footer_v');
       	}

       	private function addurl_view() {
       		$data['title'] = 'Add Steam'; 
   			$data['action'] = site_url('steam/insert');
   			$data['placeholder_url'] = 'steamcommunity.com/profiles/76561198048850805';
   			$data['placeholder_aka'] = 'iG.Ferrari_430';
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
					'label' => 'Steam URL',
					'rules' => 'required|callback_steam_url_validation',
				),
				array(
					'field' => 'known_as',
					'label' => 'Nickname',
					'rules' => 'required',
				)
			));

			if(!$this->form_validation->run()) {
				$this->addurl_view();
			} else {
				//check if success
				if ($this->Steam_m->insert() > 0) {
					$data['message'] = 'New Steam has been added successfully';
				} else {
					$data['message'] = 'Unable to add Steam';
				}
				$data['location'] = site_url('home');
				//notify then redirect
				$this->load->view('header_v');
		        $this->load->view('notification_v', $data);
		        $this->load->view('footer_v');
			}
		}

		public function remove($steamid64) {
			$known_as = $this->uri->segment(4);
			
			$data['title'] = 'Remove Steam'; 
   			$data['action'] = site_url('steam/delete/' . $steamid64);
   			$data['placeholder_url'] = 'steamcommunity.com/profiles/' . $steamid64;
   			$data['placeholder_aka'] = rawurldecode($known_as);
   			$this->load->view('header_v');
	        $this->load->view('delurl_v', $data);
	        $this->load->view('footer_v');
		}

		public function delete($steamid64) {
			//check if success
			if ($this->Steam_m->delete($steamid64) > 0) {
				$data['message'] = 'Steam has been removed successfully';
			} else {
				$data['message'] = 'Unable to remove Steam';
			}
			$data['location'] = site_url('home');
			//notify then redirect
			$this->load->view('header_v');
	        $this->load->view('notification_v', $data);
	        $this->load->view('footer_v');
		}

	    public function steam_url_validation($input) {
			$url_pattern = "/((https?:\/{2}|www\.)?steamcommunity\.com\/((id\/[\w-]+)|(profiles\/\d{17})))\/?/i";
			if (!preg_match($url_pattern, $input, $matches)) {
				$this->form_validation->set_message('steam_url_validation', 'Invalid Steam URL.');
				return FALSE;
			}
			return TRUE;
		}
	}
?>