<?php
/**
 * Created by PhpStorm.
 * User: amir
 * Date: 29/12/14
 * Time: 1:20 PM
 */

// -------------- SORTING FUNCTIONS -----------
function get_content_sorters() {
  return array(
    'time' => "זמן",
    'native' => "רגיל",
    'views' => "צפיות",
    'comments' => "תגובות",
    'comments_to_views' => "תגובות/צפיות",
    'comments_to_time' => "תגובות/זמן",
    'views_to_time' => "צפיות/זמן",
  );
}

function content_sort_views($first_element, $second_element) {
  return $second_element['views'] - $first_element['views'];
}

function content_sort_comments($first_element, $second_element) {
  return $second_element['comments'] - $first_element['comments'];
}

function content_sort_time($first_element, $second_element) {
  return $first_element['time_passed'] - $second_element['time_passed'];
}

function content_sort_comments_to_views($first_element, $second_element) {
  return 1000 * (($second_element['comments'] / $second_element['views']) - ($first_element['comments'] / $first_element['views']));
}

function content_sort_comments_to_time($first_element, $second_element) {
  return 1000 * (($second_element['comments'] / ($second_element['time_passed'])) - ($first_element['comments'] / ($first_element['time_passed'])));
}

function content_sort_views_to_time($first_element, $second_element) {
  return 1000 * (($second_element['views'] / $second_element['time_passed']) - ($first_element['views'] / $first_element['time_passed']));
}
