<?php
/**
 * @file
 * rotternews_base.features.inc
 */

/**
 * Implements hook_ctools_plugin_api().
 */
function rotternews_base_ctools_plugin_api($module = NULL, $api = NULL) {
  if ($module == "page_manager" && $api == "pages_default") {
    return array("version" => "1");
  }
  if ($module == "strongarm" && $api == "strongarm") {
    return array("version" => "1");
  }
}

/**
 * Implements hook_node_info().
 */
function rotternews_base_node_info() {
  $items = array(
    'reporter' => array(
      'name' => t('Reporter'),
      'base' => 'node_content',
      'description' => '',
      'has_title' => '1',
      'title_label' => t('Title'),
      'help' => '',
    ),
  );
  drupal_alter('node_info', $items);
  return $items;
}
