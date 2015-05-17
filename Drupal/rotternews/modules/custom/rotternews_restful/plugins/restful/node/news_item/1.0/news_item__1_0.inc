<?php

$plugin = array(
  'label' => t('News Item'),
  'resource' => 'news_item',
  'name' => 'news_item__1_0',
  'entity_type' => 'node',
  'bundle' => 'news_item',
  'description' => t('Export the "news_item" content type.'),
  'class' => 'RotternewsNewsItemResource',
  'authentication_types' => TRUE,
  'authentication_optional' => TRUE,
);
