<div class="row" id="detail">
  <h4><?php echo $title; ?></h4>
  <object type="application/x-shockwave-flash" 
          height="432" 
          width="768" 
          id="live_embed_player_flash" 
          data="http://www.twitch.tv/widgets/live_embed_player.swf?channel=<?php echo $channel; ?>" 
          bgcolor="#000000">
    <param  name="allowFullScreen" 
            value="true" />
    <param  name="allowScriptAccess" 
            value="always" />
    <param  name="allowNetworking" 
            value="all" />
    <param  name="movie" 
            value="http://www.twitch.tv/widgets/live_embed_player.swf" />
    <param  name="flashvars" 
            value="hostname=www.twitch.tv&channel=<?php echo $channel; ?>&auto_play=true&start_volume=50" />
  </object>
</div>