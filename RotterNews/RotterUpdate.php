<?php
/**
 * User: Amir Arbel
 * Date: 8/8/14
 * Time: 12:03 PM
 */ 
require_once("RotterNews.php");

if ($_GET['firstPost'] == 1) {
  print get_first_post($_GET['url']);
  return;
}

print getUpdate();
