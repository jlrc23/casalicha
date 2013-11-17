<?php
/**
 * @author Crunchify.com
 * Plugin: Foursquare Checkins
 */
?>

    <div class=wrap>

    <form method="post" action="<?php echo $_SERVER["REQUEST_URI"]; ?>">
    <input type="hidden" name="info_update" id="info_update" value="true" />


    <u><h2>FourSquare Integration Options</h2></u>

<div align="left">
<br>
<h3>Follow us on Twitter & Facebook to get latest update:</h3>
	
              <a href="https://twitter.com/Crunchify" class="twitter-follow-button" data-show-count="false"
                 data-size="large">Follow @Crunchify</a>
              <script>!function (d, s, id) {
                  var js, fjs = d.getElementsByTagName(s)[0];
                  if (!d.getElementById(id)) {
                      js = d.createElement(s);
                      js.id = id;
                      js.src = "//platform.twitter.com/widgets.js";
                      fjs.parentNode.insertBefore(js, fjs);
                  }
              }(document, "script", "twitter-wjs");</script>

              <iframe src="//www.facebook.com/plugins/likebox.php?href=http%3A%2F%2Fwww.facebook.com%2FCrunchify&amp;width=292&amp;height=62&amp;show_faces=false&amp;colorscheme=light&amp;stream=false&amp;border_color&amp;header=false&amp;appId=519929141369894"
                      scrolling="no" frameborder="0" style="border:none; overflow:hidden; width:292px; height:62px;"
                      allowTransparency="true"></iframe>

	<div id="poststuff" class="metabox-holder has-right-sidebar">

		<div style="float:left;width:67%;">

                  <br>

                  <?php
                  require_once 'setting-page/4sq-left-column.php';
                  require_once 'setting-page/4sq-right-column.php';
                  require_once 'setting-page/4sq-footer.php';

                  ?>
