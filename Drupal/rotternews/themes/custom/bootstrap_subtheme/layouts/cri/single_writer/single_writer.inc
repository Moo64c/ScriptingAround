<?php

// Plugin definition
$plugin = array(
  'title' => t('Single Writer'),
  'category' => t('cri_single_writer'),
  'icon' => 'single_writer.png',
  'theme' => 'single_writer',
  'regions' => array(
    'top_bar' => t('Top Bar'),
    'writer_card' => t('Writer Card'),
    'writer_related_articles' => t('Writer Related Articles'),
    'footer' => t('Footer'),
  ),
);
