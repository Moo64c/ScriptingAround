<?php

/**
 * @file
 * template.php
 */

/**
 * Preprocess page.
 */
function bootstrap_subtheme_preprocess_page(&$variables) {
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
}
