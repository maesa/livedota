<!DOCTYPE html>
<html>
	<head>
	    <meta charset="utf-8">
	    <title>Live!</title>
	    <meta name="viewport" content="width=device-width, initial-scale=1.0">
	    <!-- Bootstrap -->
	    <link rel="stylesheet" href="//cdn.jsdelivr.net/bootstrap/3.1.1/css/bootstrap.min.css">
	    <link rel="stylesheet" href="<?php echo base_url('css/custom.css'); ?>">
	</head>

	<body>
	    <div class="navbar navbar-default" role="navigation">
	      	<div class="container">
	        	<div class="navbar-header">
	          		<button type="button" class="navbar-toggle" data-toggle="collapse" data-target=".navbar-collapse">
	            		<span class="sr-only">Toggle navigation</span> 
	            		<span class="icon-bar"></span>
	            		<span class="icon-bar"></span>
            			<span class="icon-bar"></span>
	          		</button>
	          		<a class="navbar-brand" href="<?php echo site_url('home'); ?>"><span class="glyphicon glyphicon-home"></span></a>
	        	</div> <!-- navbar-header -->
	        	<div class="navbar-collapse collapse">
	          		<ul class="nav navbar-nav">
						<li class="dropdown">
	          				<a href="#" class="dropdown-toggle" data-toggle="dropdown">Add <b class="caret"></b></a>
		          			<ul class="dropdown-menu">
		            			<!-- <li class="divider"></li> -->
		            			<li><a href="<?php echo site_url('steam'); ?>">Steam</a></li>
		            			<li><a href="<?php echo site_url('twitch'); ?>">Twitch</a></li>
		          			</ul>
		        		</li>
	          		</ul>
	          		<ul class="nav navbar-nav navbar-right">
	          			<li class="dropdown">
	          				<a href="#" class="dropdown-toggle" data-toggle="dropdown"><?php echo $this->nsession->userdata('USERNAME'); ?> <b class="caret"></b></a>
		          			<ul class="dropdown-menu">
	            				<li><a href="<?php echo site_url('auth/logout'); ?>">Logout</span></a></li>
	            			</ul>
	            		</li>
	          		</ul>
	        	</div> <!-- navbar-collapse -->
	      	</div> <!-- container -->
	    </div> <!-- navbar -->

		<div class="container">