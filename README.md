# Rotternews
Rotternews aggregator.

Revived the live example: http://rotternews.rf.gd/client/#/live/1

Moved example host to InfinityFree - cron runs update with data every two minutes.

## Installation

### Backend - Drupal
See instructions in ``Drupal/README.md`` file.
To update, run drush command - "drush rud"

### Client
1. ``cd`` into directory.
2. ``bower install``
3. ``npm install`` - Might need ``sudo``.
4. Set the correct backed path in ``client/app/scripts/config.js`` file. 
5. ``grunt build`` - Run ``grunt serve`` for development/testing with live reload.
