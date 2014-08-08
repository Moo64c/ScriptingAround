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
  <!-- Rotter news -->
  <div id="rotter-refresh">
    <form action="javascript:rotterRefresh()"><button>Refresh</button></form>
  </div>
  <div class="news-container" id="news-container">
    <?php print get_update(); ?>
  </div>
  <!-- Twitter feed -->
  <a class="twitter-timeline" href="https://twitter.com/moo64c/lists/news" data-widget-id="497527332211421184">Tweets from https://twitter.com/moo64c/lists/news</a>
  <script>!function(d,s,id){var js,fjs=d.getElementsByTagName(s)[0],p=/^http:/.test(d.location)?'http':'https';if(!d.getElementById(id)){js=d.createElement(s);js.id=id;js.src=p+"://platform.twitter.com/widgets.js";fjs.parentNode.insertBefore(js,fjs);}}(document,"script","twitter-wjs");</script>

