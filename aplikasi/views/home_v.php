<ul class="nav nav-tabs nav-justified">
  <li class="active"><a href="#steam" data-toggle="tab">Steam</a></li>
  <li><a href="#twitch" data-toggle="tab">Twitch</a></li>
</ul>
<div class="tab-content">
    <div class="tab-pane fade active in" id="steam">
    	<?php
    		$tmpl = array ('table_open' => '<table id="t_steam" class="table table-striped">');
    		$this->table->set_template($tmpl);
    		$this->table->set_empty("&nbsp;");
			$this->table->set_heading('Avatar','Known as','Steam URL','Status','Actions');
			echo $this->table->generate($steam);
			$this->table->clear();
		?>
	</div>

	<div class="tab-pane fade" id="twitch">
		<?php
			$tmpl = array ('table_open' => '<table id="t_twitch" class="table table-striped">');
    		$this->table->set_template($tmpl);
    		$this->table->set_empty("&nbsp;");
			$this->table->set_heading('Avatar','Known as','Twitch URL','Status','Actions');
			echo $this->table->generate($twitch);
			$this->table->clear();
		?>
	</div>
</div>