<?php
/**
 * @file
 * Rotternews profile.
 */

/**
 * Implements hook_form_FORM_ID_alter().
 *
 * Allows the profile to alter the site configuration form.
 */
function rotternews_form_install_configure_form_alter(&$form, $form_state) {
  // Pre-populate the site name with the server name.
  $form['site_information']['site_name']['#default_value'] = $_SERVER['SERVER_NAME'];
}

/**
 * Implements hook_install_tasks().
 */
function rotternews_install_tasks() {
  $tasks = array();
  $tasks['rotternews_set_variables'] = array(
    'display_name' => st('Set Variables'),
    'display' => FALSE,
  );

  return $tasks;
}

/**
 * Task callback; Set variables.
 */
function rotternews_set_variables() {
  $variables = array(
    // Mime-mail
    'site_name' => 'rotternews',
    // Mime-mail
    'mimemail_format' => 'full_html',
    'mimemail_sitestyle' => FALSE,
    // JQuery.
    'jquery_update_jquery_version' => 1.8,
    'jquery_update_jquery_admin_version' => 1.5,
    // Images path.
    'rotternews_images_path' => drupal_get_path('theme', 'bootstrap_subtheme') . '/images',
    // Define the page path.
    'site_frontpage' => 'home',
    'page_manager_user_view_disabled' => FALSE,
    'geolocation_googlemaps_api_key' => 'AIzaSyCOsPCjlqo1YpFLAZi16tQeU2n1swNSWWk',
  );

  foreach ($variables as $key => $value) {
    variable_set($key, $value);
  }
}
