<?php
/**
 * @file
 * rotternews.features.inc
 */

/**
 * Implements hook_ctools_plugin_api().
 */
function rotternews_ctools_plugin_api() {
  list($module, $api) = func_get_args();
  if ($module == "strongarm" && $api == "strongarm") {
    return array("version" => "1");
  }
}

/**
 * Implements hook_node_info().
 */
function rotternews_node_info() {
  $items = array(
    'news_item' => array(
      'name' => t('News item'),
      'base' => 'node_content',
      'description' => t('Rotter news item.'),
      'has_title' => '1',
      'title_label' => t('Title'),
      'help' => '',
    ),
  );
  return $items;
}
