<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');
	class User_m extends CI_Model {

		const DB_TABLE = 't_user';

		public function check_user() {
			$username = $this->input->post('username');
			$password = $this->input->post('password');

			$this->db->select('user_id, username');
			$this->db->from($this::DB_TABLE);
			$this->db->where('username', $username);
			$this->db->where('pwd', $password);
			$this->db->where('is_active', 1);

			$user = $this->db->get();

			if ($user->num_rows() > 0) {
				$row = $user->row();
				$data = array('LOGIN' => TRUE, 'USER_ID' => $row->user_id, 'USERNAME' => $row->username, 'LOGOUT_URL' => site_url('auth/logout'));
				$this->session->set_userdata($data);
				//redirect('home');
				echo 'TRUE';
			} else {
				//redirect('login');
				echo 'FALSE';
			}
		}
	}
?>