<?php
/**
 * @file: RotterUpdate.php
 * Created by Amir Arbel on 8/8/14.
 */ 
require_once("RotterNews.php");
error_reporting(0);

if ($_POST['firstPost'] == 1) {
  print rotternews_get_first_post($_POST['url'], $_POST['id']);
  return;
}

$sorting_method = isset($_POST['sorting_method']) ? $_POST['sorting_method'] : RotterInfo::$default_sort;
print rotternews_get_update($sorting_method);
