<?php

// Plugin definition
$plugin = array(
  'title' => t('Homepage'),
  'category' => t('cri_homepage'),
  'icon' => 'homepage.png',
  'theme' => 'homepage',
  'regions' => array(
    'media_blocks' => t('Media Blocks'),
    'promoted_articles' => t('Promoted Articles'),
    'news_articles' => t('News Articles'),
    'footer' => t('Footer'),
  ),
);
