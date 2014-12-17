<?php
/**
 * @file
 * rotternews profile.
 */

/**
 * Implements hook_form_FORM_ID_alter().
 *
 * Allows the profile to alter the site configuration form.
 */
function rotternews_form_install_configure_form_alter(&$form, $form_state) {
  // Pre-populate the site name with the server name.
  $form['site_information']['site_name']['#default_value'] = 'rotternewsboard';
}

/**
 * Implements hook_install_tasks().
 */
function rotternews_install_tasks() {
  $tasks = array();

  $tasks['rotternews_create_roles'] = array(
    'display_name' => st('Create user roles'),
    'display' => FALSE,
  );

  $tasks['rotternews_set_permissions'] = array(
    'display_name' => st('Set Permissions'),
    'display' => FALSE,
  );

  $tasks['rotternews_set_variables'] = array(
    'display_name' => st('Set Variables'),
    'display' => FALSE,
  );

  $tasks['rotternews_setup_blocks'] = array(
    'display_name' => st('Setup Blocks'),
    'display' => FALSE,
  );

  $tasks['rotternews_set_text_formats'] = array(
    'display_name' => st('Set text formats'),
    'display' => FALSE,
  );

  $tasks['rotternews_menus_setup'] = array(
    'display_name' => st('Setup menus'),
    'display' => FALSE,
  );

  return $tasks;
}


/**
 * Task callback; Setup blocks.
 */
function rotternews_setup_blocks() {
}

/**
 * Task callback; Create user roles.
 */
function rotternews_create_roles() {
  // Create a default role for site administrators, with all available
  // permissions assigned.
  $role = new stdClass();
  $role->name = 'administrator';
  $role->weight = 2;
  user_role_save($role);
  user_role_grant_permissions($role->rid, array_keys(module_invoke_all('permission')));
  // Set this as the administrator role.
  variable_set('user_admin_role', $role->rid);
  // Assign user 1 the "administrator" role.
  db_insert('users_roles')
    ->fields(array('uid' => 1, 'rid' => $role->rid))
    ->execute();
}

/**
 * Task callback; Set permissions.
 */
function rotternews_set_permissions() {
  $permissions = array(
    'create messages',
  );

  user_role_grant_permissions(DRUPAL_AUTHENTICATED_RID, $permissions);
}

/**
 * Task callback; Set variables.
 */
function rotternews_set_variables() {
  $variables = array(
    // Set the default theme.
    'theme_default' => 'bartik',
    'admin_theme' => 'seven',
    // Date/Time settings.
    'date_default_timezone' => 'Asia/Jerusalem',
    'date_first_day' => 1,
    'date_format_medium' => 'D, Y-m-d H:i',
    'date_format_medium_no_time' => 'D, Y-m-d',
    'date_format_short' => 'Y-m-d',
    // Enable user picture support and set the default to a square thumbnail option.
    'user_email_verification' => FALSE,
    'user_pictures' => '1',
    'user_picture_dimensions' => '1024x1024',
    'user_picture_file_size' => '800',
    'user_picture_style' => 'thumbnail',
    'user_register' => USER_REGISTER_ADMINISTRATORS_ONLY,

    // Update the menu router information.
    'menu_rebuild_needed' => TRUE,
    'jquery_update_jquery_version' => '1.8',
    'site_name' => 'rotternews',
    'site_frontpage' => '',

    // Page manager.
    'page_manager_node_view_disabled' => FALSE,
  );

  foreach ($variables as $key => $value) {
    variable_set($key, $value);
  }
}

/**
 * Task callback; Set text formats.
 */
function rotternews_set_text_formats() {
  // Add text formats.
  $filtered_html_format = (object)array(
    'format' => 'filtered_html',
    'name' => 'Filtered HTML',
    'weight' => 0,
    'filters' => array(
      // URL filter.
      'filter_url' => array(
        'weight' => 0,
        'status' => 1,
      ),
      // HTML filter.
      'filter_html' => array(
        'weight' => 1,
        'status' => 1,
      ),
      // Line break filter.
      'filter_autop' => array(
        'weight' => 2,
        'status' => 1,
      ),
      // HTML corrector filter.
      'filter_htmlcorrector' => array(
        'weight' => 10,
        'status' => 1,
      ),
    ),
  );
  filter_format_save($filtered_html_format);

  $full_html_format = (object)array(
    'format' => 'full_html',
    'name' => 'Full HTML',
    'weight' => 1,
    'filters' => array(
      // URL filter.
      'filter_url' => array(
        'weight' => 0,
        'status' => 1,
      ),
      // Line break filter.
      'filter_autop' => array(
        'weight' => 1,
        'status' => 1,
      ),
      // HTML corrector filter.
      'filter_htmlcorrector' => array(
        'weight' => 10,
        'status' => 1,
      ),
    ),
  );
  filter_format_save($full_html_format);
}

/**
 * Profile task; create menu links.
 */
function rotternews_menus_setup() {
  // Add links to user menu.
  $item = array(
    'link_title' => 'Login',
    'link_path' => 'user/login',
    'menu_name' => 'user-menu',
  );
  menu_link_save($item);

  $item = array(
    'link_title' => 'Register',
    'link_path' => 'user/register',
    'menu_name' => 'user-menu',
  );
  menu_link_save($item);
}
