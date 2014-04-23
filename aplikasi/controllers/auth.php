<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');
	class Auth extends CI_Controller {

		public function __construct() {
			parent::__construct();
			$this->output->set_header('Last-Modified:'.gmdate('D, d M Y H:i:s').'GMT');
			$this->output->set_header('Cache-Control: no-store, no-cache, must-revalidate');
			$this->output->set_header('Cache-Control: post-check=0, pre-check=0',false);
			$this->output->set_header('Pragma: no-cache');

			parse_str( $_SERVER['QUERY_STRING'], $_REQUEST );
			$this->load->library('facebook', array(
			    'appId' => $this->config->item('FACEBOOK_APPID'),
			    'secret' => $this->config->item('FACEBOOK_SECRET')));

			
       	}

		public function index() {
			// if($this->session->userdata('LOGIN')=='TRUE'){
			// 	redirect('home');
			// } else {
			// 	$data['title'] = 'Live!'; 
	  		//  $data['link'] = base_url();

			// 	$this->load->view('login_v',$data);
			// }

			
			if($this->nsession->userdata('LOGIN')=='TRUE'){
				redirect('home');
			} else { //userdata('LOGIN')
				$data['title'] = 'Live!'; 
	           	$data['link'] = base_url();

				//BEGIN OF FACEBOOK LOGIN
				//http://www.galalaly.me/index.php/2012/04/using-facebook-php-sdk-3-with-codeigniter-2-1/
				$userId = $this->facebook->getUser();
				// If user is not yet authenticated, the id will be zero
        		if(($userId == 0) && ($this->nsession->userdata('LOGIN')!='TRUE')){
        			$data['facebook_url'] = $this->facebook->getLoginUrl();
            	} else { //$userId == 0
            		if ($this->nsession->userdata('LOGIN')!='TRUE') {
	            		$user_profile = $this->facebook->api('/me','GET');
	            		$session_data = array('LOGIN' => 'TRUE', 'USER_ID' => $userId, 'USERNAME' => $user_profile['name']);
						$this->nsession->set_userdata($session_data);

						$data['message'] = 'Welcome ' . $user_profile['name'];
						$data['location'] = site_url('home');
						$this->load->view('header_v');
				        $this->load->view('notification_v', $data);
				        $this->load->view('footer_v');
				    }
            	} //$userId == 0
            	//END OF FACEBOOK LOGIN

            	//BEGIN OF TWITTER LOGIN
            	//http://johnshipp.com/how-to-add-sign-in-with-twitter-to-your-website-using-php/
            	if (!empty($_GET['oauth_verifier']) && !empty($_SESSION['oauth_token']) && !empty($_SESSION['oauth_token_secret'])) {
            		$this->load->library('TwitterOAuth',array(
					'CONSUMER_KEY' 			=> $this->config->item('TWITTER_KEY'),
					'CONSUMER_SECRET' 		=> $this->config->item('TWITTER_SECRET'),
					'OAUTH_TOKEN' 			=> $_SESSION['oauth_token'],
					'OAUTH_TOKEN_SECRET' 	=> $_SESSION['oauth_token_secret']
					));

            		$access_token = $this->twitteroauth->getAccessToken($_GET['oauth_verifier']);
            		$_SESSION['access_token'] = $access_token;
            		$user_info = $this->twitteroauth->get('account/verify_credentials');

				    $session_data = array('LOGIN' => 'TRUE', 'USER_ID' => $user_info->id, 'USERNAME' => $user_info->name);
					$this->nsession->set_userdata($session_data);

					// echo '<pre>' . print_r($session_data) . '</pre>';
					// exit;

					$data['message'] = 'Welcome ' . $user_info->name;
					$data['location'] = site_url('home');
					$this->load->view('header_v');
			        $this->load->view('notification_v', $data);
			        $this->load->view('footer_v');
            	} else {
	            	$this->load->library('TwitterOAuth',array(
					'CONSUMER_KEY' 			=> $this->config->item('TWITTER_KEY'),
					'CONSUMER_SECRET' 		=> $this->config->item('TWITTER_SECRET'),
					'OAUTH_TOKEN' 			=> NULL,
					'OAUTH_TOKEN_SECRET' 	=> NULL
					));

	            	$request_token = $this->twitteroauth->getRequestToken(site_url('auth'));

	            	$_SESSION['oauth_token'] = $request_token['oauth_token'];
    				$_SESSION['oauth_token_secret'] = $request_token['oauth_token_secret'];

    				if ($this->twitteroauth->http_code == 200) {
				        $url = $this->twitteroauth->getAuthorizeURL($request_token['oauth_token']);
				        //header("Location: " . $url);
				        $data['twitter_url'] = $url;
				    } else { //http_code
				        $data['message'] = 'Oops... something wrong';
						$data['location'] = site_url('auth');
						$this->load->view('header_v');
				        $this->load->view('notification_v', $data);
				        $this->load->view('footer_v');
				    } //http_code
				}
            	//END OF TWITTER LOGIN

            	//forward to login page
            	if ($this->nsession->userdata('LOGIN')!='TRUE') {
            		$this->load->view('login_v', $data);
            	}
            	
			}
		}

		/*
		unused, because we use social media auth
		public function check_login() {
			$this->load->model("user_m");
			$this->user_m->check_user();
		}
		*/

		public function logout(){
			$this->nsession->sess_destroy();
			$_SESSION = array(); //clear session from globals
			redirect('auth');
		}
	}
?>