<?php
/**
 * Created by Amir Arbel on 8/8/14.
 */
require_once("RotterNews.php");
error_reporting(0);
header('Content-type: text/html; charset=UTF-8');
?>
<!DOCTYPE html>
<html>
<head profile="http://www.w3.org/2005/10/profile">
  <link rel="icon" type="image/png" href="style/images/favicon.ico">
  <title>RotterNews v0.3</title>
  <script type="text/javascript" src="lib/jquery-1.11.1.js"></script>
  <script type="text/javascript" src="lib/shadowbox/shadowbox.js"></script>
  <script type="text/javascript" src="lib/jquery.timeago.custom.js"></script>
  <script type="text/javascript" src="lib/jquery.timeago.he.custom.js"></script>
  <script type="text/javascript" src="RotterNews.js"></script>
  <link rel="stylesheet" type="text/css" href="style/RotterNews.css">
  <link rel="stylesheet" type="text/css" href="lib/shadowbox/shadowbox.css">
  <!-- Bootstrap -->
  <link href="lib/bootstrap-3.2.0-dist/css/bootstrap.min.css" rel="stylesheet">
  <meta name="viewport" content="width=device-width, initial-scale=1">
</head>
<body>
<div class="main-container container-fluid">
  <div class="row">
    <!-- Rotter news -->
    <div id="rotter-action" class="col-md-1 float-right">
      <div id="rotter-refresh">
        <form action="javascript:rotterRefresh()">
          <button>F5</button>
          <select id="sorting-options" onchange="rotterRefresh()">
            <?php foreach(get_content_sorters() as $option => $name): ?>
              <option value="<?php print $option; ?>"><?php print $name; ?></option>
            <?php endforeach; ?>
          </select>
          <label>
            <input id="show-time" type="checkbox" checked="checked" /> זמנים
          </label>
        </form>
      </div>
      <div>
        <a href="https://github.com/Moo64c/ScriptingAround/tree/master/RotterNews">Github project</a>
      </div>
    </div>
    <div class="rotter-container col-md-6 float-right">
      <div class="news-container float-right" id="news-container">
      </div>
    </div>
    <div class="twitter-container col-md-5  float-right">
      <!-- Twitter feed -->
      <a class="twitter-timeline" href="https://twitter.com/moo64c/lists/news" data-widget-id="497527332211421184">Tweets from https://twitter.com/moo64c/lists/news</a>
      <script>!function(d,s,id){var js,fjs=d.getElementsByTagName(s)[0],p=/^http:/.test(d.location)?'http':'https';if(!d.getElementById(id)){js=d.createElement(s);js.id=id;js.src=p+"://platform.twitter.com/widgets.js";fjs.parentNode.insertBefore(js,fjs);}}(document,"script","twitter-wjs");</script>
    </div>
  </div>
</div>
<script type="text/javascript" src="lib/bootstrap-3.2.0-dist/js/bootstrap.js"></script>
</body>
</html>
