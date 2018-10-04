#!/usr/bin/env bash
#
# Rebuild the site and theme.  Used after doing "git pull" as part of
# daily workflow.

CURRENT_DIR=${PWD}

# Uncomment the following command if you want to continue building if patches
# fail to apply.
# COMPOSER_DISCARD_CHANGES=1 composer install
#
# Uncomment the following command if you want to ABORT building if patches
# fail to apply.
composer install

# Clear cache before running updates and importing config to recognize code changes.
drush cr

# Run any core or module update hooks.
drush updb -y

# Import configuration. This will overwrite any local changes in your DB.
drush config-import -y

# Need a clear-cache here in case new configuration is needed in theme.
drush cr

# Build the theme
cd src/themes/particle && npm run build:drupal

cd ${CURRENT_DIR}
# final cache clear
drush cr
