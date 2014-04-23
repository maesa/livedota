<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
	$this->output->set_header('Refresh:5; url=' . $location, TRUE, 302);
  	echo '<div id="detail">' . $message . ' and You\'ll be redirected in about 5 secs. If not, click <a href="' . site_url('home') . '">here</a>.</div>';
?>
