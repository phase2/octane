# Octane
This is a composer project used to spin up a starting instance of Drupal 8 Octane.
Octane is a Drupal 8 project scaffold that provides the following features:
* Uses the Acquia/Lightning distribution.
* Uses Particle for the Pattern-Lab based theme.
* Adds common modules needed by most large Drupal 8 sites.
* Provides starting configuration for Docksal.
* Provides starting configuration for Outrigger.
* Provides starting configuration for CI on GitLabs.

## Installation
To create a Drupal Octane project, use:
```$xslt
composer create-project phase2/octane ProjectName
```

## Using Outrigger

## Using Docksal
If you are using Docksal for local development, perform the initial site setup using:
```$xslt
fin init
```
This will create the docker containers, create a database, and install Drupal.

For daily development, the following custom commands are defined within ``.docksal/commands``:
* ``fin rebuild`` - Used after a git-pull to run composer, run update hooks, import config, compile theme, clear cache.
* ``fin theme`` - Used to compile the theme and then run browserstack to watch for sass, js, twig changes.
