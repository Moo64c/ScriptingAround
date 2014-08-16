<?php
/**
 * @file: RotterUpdate.php
 * Created by Amir Arbel on 8/8/14.
 */ 
require_once("RotterNews.php");

if ($_POST['firstPost'] == 1) {
  print get_first_post($_POST['url'], $_POST['id']);
  return;
}

print get_update();
