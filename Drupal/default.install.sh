#!/bin/bash

chmod 777 www/sites/default
rm -rf www/

bash scripts/build

cd www

cp sites/default/default.settings.php sites/default/settings.php
mkdir sites/default/files

drush si -y mothernity --account-pass=admin --db-url=mysql://root@localhost/mothernity -v
drush mi --all --user=1

chmod -R 777 sites/default/files

