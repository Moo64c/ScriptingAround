# Rotternews
Rotternews aggregator.

New live example here: http://rotternews.2fh.co/

Moved example host to OpenShift - cron runs update with data every minute. 

## Installation

### Backend - Drupal
See instructions in ``Drupal/README.md`` file.

### Client
1. ``cd`` into directory.
2. ``bower install``
3. ``npm install`` - Might need ``sudo``.
4. Set the correct backed path in ``client/app/scripts/config.js`` file. 
5. ``grunt build`` - Run ``grunt serve`` for development/testing with live reload.
