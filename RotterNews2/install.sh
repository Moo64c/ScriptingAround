#!/bin/bash

# Modify the MySQL settings below so they will match your own.
MYSQL_USERNAME="root"
MYSQL_PASSWORD="root"
MYSQL_HOST="localhost"
MYSQL_DB_NAME="hiro"

# Modify the URL below to match your hiro base domain URL.
BASE_DOMAIN_URL="http://localhost/HiroDashboard/www"

# Modify the login details below to be the desired login details for the Administrator account.
ADMIN_USERNAME="admin"
ADMIN_PASSWORD="admin"
ADMIN_EMAIL="admin@example.com"

chmod 777 www/sites/default
rm -rf www/
mkdir www

bash scripts/build

cd www

drush si -y hirodash --account-name=$ADMIN_USERNAME --account-pass=$ADMIN_PASSWORD --account-mail=$ADMIN_EMAIL --db-url=mysql://$MYSQL_USERNAME:$MYSQL_PASSWORD@$MYSQL_HOST/$MYSQL_DB_NAME --uri=$BASE_DOMAIN_URL --yes

# This command does the login for you when the build script is done. It will open a new tab in your default browser and login to your project as the Administrator. Comment out this line if you do not want the login to happen automatically.
drush uli --uri=$BASE_DOMAIN_URL
