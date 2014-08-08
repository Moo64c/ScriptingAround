<?php
/**
 * User: Amir Arbel
 * Date: 8/8/14
 * Time: 12:03 PM
 */ 
require_once("RotterNews.php");

if ($_POST['firstPost'] == 1) {
  print get_first_post($_POST['url'], $_POST['id']);
  return;
}

print get_update();
