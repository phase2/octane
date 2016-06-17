This is a Composer-based installer for the [Octane](https://www.drupal.org/project/octane) Drupal 8 distribution. 
It is a base distribution intended to "fuel" your Drupal 8 projects.

## Get Started
You will need to install the following:

* [Composer](https://getcomposer.org)
* [Node](https://nodejs.org)

Then, either clone this repo and run `composer install` followed by `composer drupal-scaffold`  This will create a build/html directory containing the Drupal 8 docroot.
Finally, run the Drupal installer as normal.

Currently this distribution is based on the [Lightning](https://www.drupal.org/project/lightning) from Acquia.

## Customizing
The composer.json file is currently configured to build your drupal docroot within a build/html directory.  
If you clone this repo for your own use you might need to change this directory.  
Removing `build/html/` from the "installer-paths" will build the Drupal docroot into the current directory.

NOTE: The directory containing the composer.json will need to be accessible to your web server since the generated autoload.php will point to the vendor directory that is created.
