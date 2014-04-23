<div class="row" style="margin-top:20px">
  <div class="col-xs-12 col-sm-8 col-md-6 col-sm-offset-2 col-md-offset-3">
    <form role="form" action="" method="post">
      <fieldset>
        <h2><?php echo $title; ?></h2>
        <hr class="colorgraph">
        <div class="form-group">
          <input type="text" name="url" id="url" class="form-control input-lg" placeholder="<?php echo $placeholder_url; ?>" disabled>
        </div>
        <div class="form-group">
          <input type="text" name="known_as" id="known_as" class="form-control input-lg" placeholder="<?php echo $placeholder_aka; ?>" disabled>
        </div>
        <hr class="colorgraph">
        <div class="row">
          <div class="col-xs-6 col-sm-6 col-md-6">
            <a href="<?php echo site_url('home'); ?>" id="a_cancel" class="btn btn-lg btn-primary btn-block" role="button">Cancel</a>
          </div>
          <div class="col-xs-6 col-sm-6 col-md-6">
            <a href="<?php echo $action; ?>" id="a_delete" class="btn btn-lg btn-danger btn-block" role="button">Remove</a>
          </div>
        </div>
      </fieldset>
    </form>
  </div>
</div>