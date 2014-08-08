<?php
/**
 * User: Amir Arbel
 * Date: 8/8/14
 * Time: 11:50 AM
 */
require_once("RotterNews.php");
?>
<html>
<head>
  <title>AmirNews v0.2</title>
  <script type="text/javascript" src="jquery-1.11.1.js"></script>
  <script type="text/javascript" src="RotterNews.js"></script>
  <link rel="stylesheet" type="text/css" href="RotterNews.css">
</head>
<body>
<div class="main-container">
  <div class="rotter-container">
    <!-- Rotter news -->
    <div id="rotter-actions">
      <div id="rotter-refresh" dir="ltr">
        <form action="javascript:rotterRefresh()"><button>F5</button></form>
      </div>
    </div>
    <div id="rotter-actions-placeholder"></div>
    <div class="news-container" id="news-container">
      <?php print get_update(); ?>
    </div>
  </div>
  <div class="twitter-container">
    <!-- Twitter feed -->
    <a class="twitter-timeline" href="https://twitter.com/moo64c/lists/news" data-widget-id="497527332211421184">Tweets from https://twitter.com/moo64c/lists/news</a>
    <script>!function(d,s,id){var js,fjs=d.getElementsByTagName(s)[0],p=/^http:/.test(d.location)?'http':'https';if(!d.getElementById(id)){js=d.createElement(s);js.id=id;js.src=p+"://platform.twitter.com/widgets.js";fjs.parentNode.insertBefore(js,fjs);}}(document,"script","twitter-wjs");</script>
  </div>
</div>
</body>
</html>

