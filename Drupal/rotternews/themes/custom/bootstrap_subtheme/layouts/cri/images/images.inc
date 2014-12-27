<?php

// Plugin definition
$plugin = array(
  'title' => t('Images'),
  'category' => t('cri_images'),
  'icon' => 'images.png',
  'theme' => 'images',
  'regions' => array(
    'search_bar' => t('Search Bar'), // This will be in page.tpl.php.
    'image_categories' => t('Image Categories'),
    'map' => t('Map'),
    'articles' => t('Articles'),
    'footer' => t('Footer'),
  ),
);
