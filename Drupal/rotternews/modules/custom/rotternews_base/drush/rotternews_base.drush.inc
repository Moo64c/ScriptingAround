<?php
/**
 * @file
 * Drush integration of HV notify.
 *
 */

/**
 * Implement hook_drush_help().
 */
function rotternews_base_drush_help($section) {
  switch ($section) {
    case 'drush:rotternews_update_data':
      return dt('Update Rotter news.');
  }
}

/**
 * Implement hook_drush_command().
 */
function rotternews_base_drush_command() {
  $items = array();

  $items['rotternews_base_update_data'] = array(
    'callback' => 'rotternews_base_drush_update_data',
    'drupal dependencies' => array('rotternews_base'),
    'description' => 'Update rotter news.',
    'options' => array(
      'get_content' => 'Get and process the data in each of the topics.',
    ),
    'bootstrap' => DRUSH_BOOTSTRAP_DRUPAL_CONFIGURATION,
    'aliases' => array('rud'),
    'examples' => array(
      'drush rud',
    ),
  );

  return $items;
}

/**
 * Callback function for starting the data processing.
 */
function rotternews_base_drush_update_data() {
  rotternews_get_update();
}
