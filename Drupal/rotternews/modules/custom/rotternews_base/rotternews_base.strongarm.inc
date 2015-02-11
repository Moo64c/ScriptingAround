<?php
/**
 * @file
 * rotternews_base.strongarm.inc
 */

/**
 * Implements hook_strongarm().
 */
function rotternews_base_strongarm() {
  $export = array();

  $strongarm = new stdClass();
  $strongarm->disabled = FALSE; /* Edit this to true to make a default strongarm disabled initially */
  $strongarm->api_version = 1;
  $strongarm->name = 'language_content_type_reporter';
  $strongarm->value = '0';
  $export['language_content_type_reporter'] = $strongarm;

  $strongarm = new stdClass();
  $strongarm->disabled = FALSE; /* Edit this to true to make a default strongarm disabled initially */
  $strongarm->api_version = 1;
  $strongarm->name = 'menu_options_reporter';
  $strongarm->value = array(
    0 => 'main-menu',
  );
  $export['menu_options_reporter'] = $strongarm;

  $strongarm = new stdClass();
  $strongarm->disabled = FALSE; /* Edit this to true to make a default strongarm disabled initially */
  $strongarm->api_version = 1;
  $strongarm->name = 'menu_parent_reporter';
  $strongarm->value = 'main-menu:0';
  $export['menu_parent_reporter'] = $strongarm;

  $strongarm = new stdClass();
  $strongarm->disabled = FALSE; /* Edit this to true to make a default strongarm disabled initially */
  $strongarm->api_version = 1;
  $strongarm->name = 'node_options_reporter';
  $strongarm->value = array(
    0 => 'status',
    1 => 'promote',
  );
  $export['node_options_reporter'] = $strongarm;

  $strongarm = new stdClass();
  $strongarm->disabled = FALSE; /* Edit this to true to make a default strongarm disabled initially */
  $strongarm->api_version = 1;
  $strongarm->name = 'node_preview_reporter';
  $strongarm->value = '1';
  $export['node_preview_reporter'] = $strongarm;

  $strongarm = new stdClass();
  $strongarm->disabled = FALSE; /* Edit this to true to make a default strongarm disabled initially */
  $strongarm->api_version = 1;
  $strongarm->name = 'node_submitted_reporter';
  $strongarm->value = 1;
  $export['node_submitted_reporter'] = $strongarm;

  return $export;
}
