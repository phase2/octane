# Drupal Octane

A distribution of Drupal 8 maintained by Phase2.

Built using Drupal Lightning.

# Installing

* Create an empty project directory.
* Unpack this Octane repository into the `profiles/octane` directory.
* Move the `composer.json` file to the top-level of your project directory.
* Run `composer install` to download all the dependencies.
* Run `composer drupal-scaffold` to install the rest of Drupal core files.
* In your browser, go to your `http://sitename/install.php` and install the Octane profile.

# File cleanup

The following files were added to allow drupal.org to build an empty distribution.  They are not needed and can be deleted:

* `drupal-org.make`
* `drupal-org-core.make`
* `build-octane.make`