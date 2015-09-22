<?php

$plugin = array(
  'label' => t('News Item'),
  'resource' => 'news_item',
  'name' => 'news_item__1_1',
  'entity_type' => 'node',
  'bundle' => 'news_item',
  'description' => t('Export the "news_item" content type.'),
  'class' => 'RotternewsNewsItemResource',
  'authentication_optional' => TRUE,
  'minor_version' => 1,
  'rate_limit' => array(
    // The 'request' event is the basic event. You can declare your own events.
    'request' => array(
      'event' => 'request',
      // Rate limit is cleared every day.
      'period' => new \DateInterval('PT5M'),
      'limits' => array(
        'authenticated user' => 30,
        'anonymous user' => 5,
        'administrator' => \RestfulRateLimitManager::UNLIMITED_RATE_LIMIT,
      ),
    ),
  ),
);
