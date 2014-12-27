<?php

/**
 * @file
 * template.php
 */

/**
 * Preprocess page.
 */
function bootstrap_subtheme_preprocess_page(&$variables) {
  $vocabulary_menu = taxonomy_vocabulary_machine_name_load('categories');
  $terms_menu = taxonomy_get_tree($vocabulary_menu->vid, 0, 1, $load_entities = TRUE);
  $variables['menu'] = cri_categories_main_menu($terms_menu, $variables);
  $variables['base_url'] = url('', array(
    'absolute' => TRUE,
  ));

  $variables['page_title'] = drupal_get_title();
  drupal_add_js(libraries_get_path('cri') . '/js/scripts.js');
}

/**
 * Node preprocess.
 */
function bootstrap_subtheme_preprocess_node(&$variables) {
  $node = $variables['node'];
  $view_mode = $variables['view_mode'];

  // Generic tpl for node--bundle--view-mode.
  $variables['theme_hook_suggestions'][] = "node__{$node->type}__{$view_mode}";

  $preprocess_function = "bootstrap_subtheme_preprocess_node__{$node->type}";
  if (function_exists($preprocess_function)) {
    $preprocess_function($variables);
  }

  $preprocess_function = "bootstrap_subtheme_preprocess_node__{$node->type}__{$view_mode}";
  if (function_exists($preprocess_function)) {
    $preprocess_function($variables);
  }

}

/**
 * Preprocess for article bundle.
 */
function bootstrap_subtheme_preprocess_node__article(&$variables) {
  $node = $variables['node'];
  // Need to reload node because for some reason node title is an empty string.
  $node = node_load($node->nid);

  $wrapper = entity_metadata_wrapper('node', $node);
  foreach ($wrapper->field_images_reference as $sub_wrapper) {
    // Get only the first image from the referenced images.
    if (!$value = $sub_wrapper->field_images->value()) {
      continue;
    }

    // Get the first image.
    $info = reset($value);
    $variables['image'] = theme('image_style', array(
      'path' => $info['uri'],
      'attributes' => array('class' => array('img-responsive', 'teaser-image', 'small-image')),
      'style_name' => 'related_article'
      ));
    break;
  }

  if ($wrapper->field_main_category->value()) {
    $variables['label_class'] = $wrapper->field_main_category->field_color->value();
    $variables['label'] = $wrapper->field_main_category->name->value();
  }

  $summary = $wrapper->body->value() ? $wrapper->body->summary->value() : '';
  $variables['description'] = str_replace(array('<p>','</p>'), '', $summary);
  $link_options = array(
    'attributes' => array('class' => array('balloon')),
    'html' => TRUE,
  );
  $variables['popup_link'] = l($node->title, 'node/' . $node->nid, $link_options);
  $variables['popup_image'] = $variables['image'] ? l($variables['image'], 'node/' . $node->nid, array('html' => TRUE)) : NULL;
}

/**
 * Preprocess for article bundle.
 */
function bootstrap_subtheme_preprocess_node__article__images(&$variables) {
  $node = $variables['node'];

  // Need to reload node because for some reason node title is an empty string.
  $node = node_load($node->nid);
  // Need to put title in variables after reloading node.
  $variables['title'] = $node->title;

  // Link to the node for facebook widgets.
  $variables['node_link'] = url('node/' . $node->nid, array('absolute' => TRUE));

  $wrapper = entity_metadata_wrapper('node', $node);
  $variables['text'] = $wrapper->body->summary->value() ? $wrapper->body->summary->value() : '';

  // Loading all article's images.
  $images = array();
  foreach ($wrapper->field_images_reference as $sub_wrapper) {
    if (!$value = $sub_wrapper->field_images->value()) {
      // There is no image for the reference.
      continue;
    }
    $info = reset($value);
    $image_params = array(
      'attributes' => array('class' => array('img-responsive', 'teaser-image', 'small-image')),
      'path' => $info['uri'],
    );
    $link_options = array(
      'html' => TRUE,
      'query' => array('article_id' => $node->nid),
    );
    $images[] = l(theme('image', $image_params), 'popup/node/image/' . $sub_wrapper->nid->value(), $link_options);
  }
  $variables['images'] = theme('item_list', array('items' => $images, 'attributes' => array('class' => 'images_list')));

  // Load the same articles we have in the Images page.
  $query = new EntityFieldQuery();
  $query
    ->entityCondition('entity_type', 'node')
    ->propertyCondition('status', NODE_PUBLISHED)
    ->propertyCondition('type', 'article');

  if (!empty($_GET['tid'])) {
    $query->addMetaData('tid', $_GET['tid']);
    $query->addTag('term_conditions');
  }

  // If we also have search text from the search form - add this text condition
  // to the title, body and summary fields.
  if (!empty($_GET['search_api_views_fulltext'])) {
    $query->addMetaData('search_text', $_GET['search_api_views_fulltext']);
    $query->addTag('search_conditions');
  }

  $result = $query
    ->fieldCondition('field_article_type', 'value', 'Image')
    ->fieldCondition('field_view_mode', 'value', 'banner', '<>')
    ->fieldOrderBy('field_date', 'value', 'desc')
    ->execute();

  if (!empty($result['node'])) {
    $articles = node_load_multiple(array_keys($result['node']));
  }

  // Getting previous and next article nids using keys of the articles array,
  // that are actually node ids.
  $keys = array_keys($articles);
  foreach(array_keys($keys) as $key ){
    $current_value = $keys[$key];
    // Key is not a current node's nid.
    if ($current_value != $node->nid) {
      continue;
    }
    $nid_next = !empty($keys[$key+1]) ? $keys[$key+1] : 0;
    $nid_prev = !empty($keys[$key-1]) ? $keys[$key-1] : 0;
  }

  // Creating links to the next and to the previous article.
  $link_query = !empty($_GET['tid']) && intval($_GET['tid']) ? array('tid' => $_GET['tid']) : array();
  $link_query += !empty($_GET['search_api_views_fulltext']) ?  array ('search_api_views_fulltext' => $_GET['search_api_views_fulltext']) : array();
  $prev_url = $nid_prev ?  'popup/node/' . $nid_prev : '';
  $next_url = $nid_next ? 'popup/node/' . $nid_next  : '';
  $link_options = array(
    'html' => TRUE,
    'query' => $link_query,
    'attributes' => array(
      'class' => array('previous', 'fa fa-angle-right'),
    ),
  );
  $variables['prev'] = $prev_url ? l('', $prev_url, $link_options) : '';
  $link_options['attributes'] = array('class' => array('next', 'fa fa-angle-left'));
  $variables['next'] = $next_url ? l('', $next_url, $link_options) : '';
}

/**
 * Preprocess for article bundle.
 */
function bootstrap_subtheme_preprocess_node__article__video(&$variables) {
  $node = $variables['node'];

  // Need to reload node because for some reason node title is an empty string.
  $node = node_load($node->nid);
  // Need to put title in variables after reloading node.
  $variables['title'] = $node->title;

  // Link to the node for facebook widgets.
  $variables['node_link'] = url('node/' . $node->nid, array('absolute' => TRUE));

  $wrapper = entity_metadata_wrapper('node', $node);
  $variables['text'] = $wrapper->body->summary->value() ? $wrapper->body->summary->value() : '';
  $variables['video'] = $wrapper->field_video_link->value();

  // Load the same articles we have in the Videos page.
  $query = new EntityFieldQuery();
  $query
    ->entityCondition('entity_type', 'node')
    ->propertyCondition('status', NODE_PUBLISHED)
    ->propertyCondition('type', 'article');

  if (!empty($_GET['tid'])) {
    $query->addMetaData('tid', $_GET['tid']);
    $query->addTag('term_conditions');
  }

  // If we also have search text from the search form - add this text condition
  // to the title, body and summary fields.
  if (!empty($_GET['search_api_views_fulltext'])) {
    $query->addMetaData('search_text', $_GET['search_api_views_fulltext']);
    $query->addTag('search_conditions');
  }

  $result = $query
    ->fieldCondition('field_article_type', 'value', 'video')
    ->fieldCondition('field_view_mode', 'value', 'banner', '<>')
    ->fieldOrderBy('field_date', 'value', 'desc')
    ->execute();

  if (!empty($result['node'])) {
    $articles = node_load_multiple(array_keys($result['node']));
  }

  // Getting previous and next article nids using keys of the articles array,
  // that are actually node ids.
  $keys = array_keys($articles);
  foreach(array_keys($keys) as $key ){
    $current_value = $keys[$key];
    // Key is not a current node's nid.
    if ($current_value != $node->nid) {
      continue;
    }
    $nid_next = !empty($keys[$key+1]) ? $keys[$key+1] : 0;
    $nid_prev = !empty($keys[$key-1]) ? $keys[$key-1] : 0;
  }

  // Creating links to the next and to the previous article.
  $link_query = !empty($_GET['tid']) && intval($_GET['tid']) ? array('tid' => $_GET['tid']) : array();
  $link_query += !empty($_GET['search_api_views_fulltext']) ?  array ('search_api_views_fulltext' => $_GET['search_api_views_fulltext']) : array();
  $prev_url = $nid_prev ?  'popup/node/video/' . $nid_prev : '';
  $next_url = $nid_next ? 'popup/node/video/' . $nid_next  : '';
  $link_options = array(
    'html' => TRUE,
    'query' => $link_query,
    'attributes' => array(
      'class' => array('previous'),
    ),
  );
  $variables['prev'] = $prev_url ? l('', $prev_url, $link_options) : '';
  $link_options['attributes'] = array('class' => array('next'));
  $variables['next'] = $next_url ? l('', $next_url, $link_options) : '';
}

/**
 * Preprocess for image bundle.
 */
function bootstrap_subtheme_preprocess_node__image__popup_image(&$variables) {
  $node = $variables['node'];
  // Need to reload node because for some reason node title is an empty string.
  $node = node_load($node->nid);
  // Need to put title in variables after reloading node.
  $variables['title'] = $node->title;

  $wrapper = entity_metadata_wrapper('node', $node);
  if (!$value = $wrapper->field_images->value()) {
    return;
  }

  $info = reset($value);
  $image_params = array(
    'attributes' => array('class' => array('img-responsive', 'teaser-image', 'small-image')),
    'path' => $info['uri'],
  );
  $variables['image'] = theme('image', $image_params);

  if (!empty($_GET['article_id']) && intval($_GET['article_id'])) {
    $article = node_load($_GET['article_id']);
    $wrapper = entity_metadata_wrapper('node', $article);

    $images = array();
    foreach ($wrapper->field_images_reference as $sub_wrapper) {
      if (!$value = $sub_wrapper->field_images->value()) {
        // There is no image for the reference.
        continue;
      }
      $images[] = $sub_wrapper->nid->value();
    }

    foreach($images as $key => $image_id) {
      $current_value = $image_id;
      // Key is not a current node's nid.
      if ($current_value != $node->nid) {
        continue;
      }
      $current_number = $key+1;
      $nid_next = !empty($images[$key+1]) ? $images[$key+1] : 0;
      $nid_prev = !empty($images[$key-1]) ? $images[$key-1] : 0;
    }
    $params = array(
      '@results' => count($wrapper->field_images_reference),
      '@current_number' => $current_number,
      '@title' => $node->title,
    );
    $variables['popup_title'] = t('@title - @current_number/@results', $params);

    // Creating links to the next and to the previous image.
    $link_query = !empty($_GET['article_id']) && intval($_GET['article_id']) ? array('article_id' => $_GET['article_id']) : array();
    $prev_url = $nid_prev ?  'popup/node/image/' . $nid_prev : '';
    $next_url = $nid_next ? 'popup/node/image/' . $nid_next  : '';
    $link_options = array(
      'html' => TRUE,
      'query' => $link_query,
      'attributes' => array(
        'class' => array('previous', 'fa fa-chevron-right img-prv'),
      ),
    );
    $variables['prev'] = $prev_url ? l('', $prev_url, $link_options) : '';
    $link_options['attributes'] = array('class' => array('next', 'fa fa-chevron-left', 'img-next'));
    $variables['next'] = $next_url ? l('', $next_url, $link_options) : '';
  }
}

/**
 * Preprocess article page.
 */
function bootstrap_subtheme_preprocess_article(&$variables) {
  $node = reset($variables['display']->context)->data;
  if($node->type == 'article') {
    $wrapper = entity_metadata_wrapper('node', $node);

    // Build a social_links block.
    $social_links = cri_article_share_social_networks($node);
    $variables["social_links"] = $social_links;

    // Add the node body.
    $variables["body"] = cri_article_body_field($wrapper);

    // Tell us about the problem.
    $variables["report_link"] = l(t('טעות בכתבה?'), 'contact',
      array(
        'query' =>
        array(
          'subject_node' => $node->nid
        )
      )
    );

    // Add the related tags to the article.
    $tags = cri_general_tags($node);
    $variables["tags"] = $tags;
    $variables["map_link"] = url() . "map";
  }
}

/**
 * User profile preprocess.
 */
function bootstrap_subtheme_preprocess_user_profile(&$variables) {
  $view_mode = $variables['elements']['#view_mode'];

  $variables['theme_hook_suggestions'][] = 'user_profile__' . $variables['elements']['#view_mode'];

  // Generic tpl for node--bundle--view-mode.
  $preprocess_function = "bootstrap_subtheme_preprocess_user_profile__{$view_mode}";
  if (function_exists($preprocess_function)) {
    $preprocess_function($variables);
  }

  $user = $variables['elements']['#account'];
  $wrapper = entity_metadata_wrapper('user', $user);

  $variables['photo'] = '';
  if ($wrapper->field_user_photo->__isset('field_images')) {
    $images = $wrapper->field_user_photo->field_images->value();
    $image = reset($images);
    $uri = $image['uri'];
    $image_params = array(
      'attributes' => array('class' => array('img-responsive', 'teaser-image', 'small-image')),
      'path' => $uri,
    );
    $variables['photo'] = l(theme('image', $image_params), 'users/' . $user->name, array('html' => TRUE));
  }

  $variables['name'] = $wrapper->field_first_name->value() . $wrapper->field_last_name->value() ? $wrapper->field_first_name->value() . ' ' . $wrapper->field_last_name->value() : $wrapper->name->value();

  $variables['facebook'] = $wrapper->field_facebook->value();

  $variables['information'] = $wrapper->field_user_information->value() ? $wrapper->field_user_information->value() : t('אין מידע על המשתמש הזה.');

}
