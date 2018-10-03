#!/usr/bin/env bash

# Install Particle theme
npx phase2/create-particle src/themes/particle

# Install project requirements.
composer clear-cache
COMPOSER_PROCESS_TIMEOUT=2000 COMPOSER_DISCARD_CHANGES=1 composer install

# Install site
drush si --db-url=mysql://admin:admin@db/drupal_octane minimal

# Manually set username and password for the admin user.
# @see https://github.com/acquia/blt/issues/2984.
drush sql:query "UPDATE users_field_data SET name = 'admin' WHERE uid = 1;"
drush user:password admin "admin"
