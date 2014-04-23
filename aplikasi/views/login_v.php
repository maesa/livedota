<!DOCTYPE html>
<html>
	<head>
	    <meta charset="utf-8">
	    <title>Live!</title>
	    <meta name="viewport" content="width=device-width, initial-scale=1.0">
	    <!-- Bootstrap -->
	    <link rel="stylesheet" href="//cdn.jsdelivr.net/bootstrap/3.1.1/css/bootstrap.min.css">
	    <link rel="stylesheet" href="<?php echo base_url('css/login.css'); ?>">
	    <link rel="stylesheet" href="<?php echo base_url('css/bootstrap-social.css'); ?>">
	    <script src="//cdn.jsdelivr.net/jquery/2.1.0/jquery.min.js"></script>
	    <script type="application/javascript">
			$(document).ready(function() {
				// prevents the overlay from closing if user clicks inside the popup overlay
			    $('.overlay-bg').click(function(){
			        return false;
			    });

			    // prevents the overlay from closing if user clicks inside the popup overlay
			    $('.spinner').click(function(){
			        return false;
			    });

				$('#btn_submit').click(function(e) {
					e.preventDefault();

					var shaObj = new jsSHA($('#password').val(), "TEXT");
					var hashedpwd = shaObj.getHash("SHA-512", "HEX");
					var form_data = {
						username : $('#username').val(),
						password : hashedpwd
					};

					$.ajax({
						url: "<?php echo site_url('auth/check_login'); ?>",
						type: 'POST',
						async : false,
						data: form_data,
						beforeSend:function() {
					        $('.overlay-bg').fadeIn();
						},
						success: function(result) {
							if('TRUE' == result) {
								window.location.href='home';
							} else {
								$('#output').show();
								$('#output').append('<div class="alert alert-danger alert-dismissable">Invalid user or password.<button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button></div>');
								$('.overlay-bg').fadeOut();
							}
						}
					});

					return false;
				});
			});
	   	</script>
	</head>

	<body>
	<!-- 		
		loading spin
		<div class="overlay-bg">
			<div class="spinner">
				<div class="bar1"></div>
				<div class="bar2"></div>
				<div class="bar3"></div>
				<div class="bar4"></div>
				<div class="bar5"></div>
				<div class="bar6"></div>
				<div class="bar7"></div>
				<div class="bar8"></div>
				<div class="bar9"></div>
				<div class="bar10"></div>
				<div class="bar11"></div>
				<div class="bar12"></div>
			</div>
		</div> 
	-->

		<div class="container">
			<header class="row">
				<a href="<?php echo $link; ?>"><h1><?php echo $title; ?></h1></a>
			</header>
			<div id="output">
			</div>

			<!-- "login form layered" by riliwanrabo -->
			<div class="login-container">
	            <div class="form-box">
	               <!--  <form action="<?php //echo site_url('auth/check_login'); ?>" method="post">
						                   
						<input name="username" id="username" type="text" placeholder="username" autocomplete="off">
	                    <input name="password" id="password" type="password" placeholder="password">
	                    <button id="btn_submit" class="btn btn-info btn-block login" type="submit">Login</button>
	                    
	                </form> -->

                	<!-- <a href="#" class="btn btn-block btn-social btn-facebook"> -->
                	<a href="<?php echo $facebook_url; ?>" class="btn btn-block btn-social btn-facebook">
			            <i class="fa fa-facebook"></i> Sign in with Facebook
					</a>
                	<!-- <a href="#" class="btn btn-block btn-social btn-twitter"> -->
                	<a href="<?php echo $twitter_url; ?>" class="btn btn-block btn-social btn-twitter">
						<i class="fa fa-twitter"></i> Sign in with Twitter
					</a>

	            </div>
	        </div>

			<footer class="row">
				<p>Powered by 
					<a href="http://steampowered.com">Steam</a>,
					<a href="http://twitch.tv">Twitch</a>,
					<a href="http://www.jsdelivr.com">jsDelivr</a>,
					<a href="http://getbootstrap.com">Twitter's Bootstrap</a>.
					"Live!" is either affiliated with <a href="http://valvesoftware.com">Valve Corporation</a> nor <a href="http://twitch.tv">Twitch</a>.
				</p>
		    </footer>
		</div><!--container-->

		<!-- javascript -->
		<script src="<?php echo base_url('js/sha512.js'); ?>"></script>
	    <script src="//cdn.jsdelivr.net/g/bootstrap@3.1.1,respond@1.4.2"></script>
	</body>
</html>