<div class="row" style="margin-top:20px">
	<div class="col-xs-12 col-sm-8 col-md-6 col-sm-offset-2 col-md-offset-3">
		<form role="form" action="<?php echo $action; ?>" method="post">
			<fieldset>
				<h2><?php echo $title; ?></h2>
				<hr class="colorgraph">
				<div class="form-group">
					<input type="text" name="url" id="url" class="form-control input-lg" placeholder="<?php echo $placeholder_url; ?>" autocomplete="off">
				</div>
				<div class="form-group">
					<input type="text" name="known_as" id="known_as" class="form-control input-lg" placeholder="<?php echo $placeholder_aka; ?>" autocomplete="off">
				</div>
				<span>
					<?php echo validation_errors('<div class="alert alert-danger alert-dismissable"><button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>','</div>'); ?>
				</span>
				<hr class="colorgraph">
				<div class="row">
					<div class="col-xs-6 col-sm-6 col-md-6">
					</div>
					<div class="col-xs-6 col-sm-6 col-md-6">
						<button id="btn_save" class="btn btn-lg btn-primary btn-block" type="submit">Save</button>
					</div>
				</div>
			</fieldset>
		</form>
	</div>
</div>