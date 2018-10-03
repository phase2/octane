# Octane
This is a composer project used to spin up a starting instance of Drupal 8 Octane.
Octane is a Drupal 8 project scaffold that provides the following features:
* Uses the Acquia/Lightning distribution.
* Uses Particle for the Pattern-Lab based theme.
* Adds common modules needed by most large Drupal 8 sites.
* Provides starting configuration for Docksal.
* Provides starting configuration for Outrigger.
* (TODO) Provides starting configuration for CI on GitLabs.

## Installation
To create a Drupal Octane project, use:
```$xslt
composer create-project phase2/octane projectname
```
This will create a sub-directory called ``projectname`` and will download
the files needed to build your Drupal project using the Octane templates.
The ``projectname`` should be all lowercase and will become the hostname of
your local Drupal site.

## Using Outrigger

If you are using [Outrigger](http://docs.outrigger.sh/) for local development, perform the initial site setup using:
```$xslt
rig project init
```
This will create the docker containers, create a database, and install Drupal.
Your site will be available at ``www.projectname.vm``

## Using Docksal
If you are using [Docksal](https://docksal.io/) for local development, perform the initial site setup using:
```$xslt
fin init
```
This will create the docker containers, create a database, and install Drupal.
Your site will be available at ``projectname.docksal``

## Custom Project Scripts
Custom scripts for your project should be created in the ``/bin`` folder and
then referenced from either Outrigger or Docksal.

For Docksal, create a file within ``.docksal/commands`` that performs any
specific Docksal setup and then calls the script in ``/bin``.  See the ``init``
command for an example.

For Outrigger, edit the ``.outrigger.yml`` file and add a custom script with any
specific Outrigger setup and then call the script in ``/bin``. See the
``rig project init`` script for an example.

This will create the docker containers, create a database, and install Drupal.

### Common Commands

Each of these commands are available as either a ``fin COMMAND`` or 
``rig project COMMAND``.

* ``rebuild`` - Used after a git-pull to run composer, run update hooks, import config, compile theme, clear cache.
* ``theme`` - Used to compile the theme and then run browserstack to watch for sass, js, twig changes.

## Docker Containers
Outrigger uses the full ``docker-composer.yml`` (and ``docker-compose.override.yml`` locally)
to define the docker containers, whereas Docksal defines a default stack and
allows you to override the configuration in ``.docksal/docksal.yml`` which uses
the same docker-compose syntax but only needs to contain the local overrides.

Default environment variables for Outrigger are defined in the ``.env`` file
while Docksal uses the ``.docksal/docksal.env`` file.

The following containers will be created and used for your site:

* ``web`` - The Apache web container.
* ``db`` - The MySQL (Docksal) or MariaDB (Outrigger) database container.
Default user is ``admin`` and pass ``admin`` can be changed in the environment
variables or db container configuration.

### Build/CLI Container
One of the main priciples of Octane is to minimize the number of tools installed
on your local computer (only Composer) and instead perform most tasks within a 
docker "build" container that contains all the tools.

In Outrigger, this Build container is defined in the ``build.yml`` docker-compose
file. Various application specific containers are build on the "base" container
for ``drush``, ``composer``, and generic ``cli`` commands. To run a script
within the build container, use the command syntax:
```$xslt
docker-compose -f build.yml run --rm cli /var/www/bin/SCRIPTNAME.sh
```
Typically you will create a ``rig project SCRIPTNAME`` alias for this in the 
``.outrigger.yml`` file or create a local alias in your own ``.bashrc`` file.
For example:
```$xslt
ddrush='docker-compose -f build.yml run --rm drush'
```
for running drush within the build container.

To open a bash shell into the Outrigger Build container, use
```$xslt
rig project bash
```

In DockSal, the Build container is called ``cli`` and is defined within the
default services stack, much like ``web`` or ``db`` and can be overridden
using the ``docksal.yml`` file.  Docksal provides its own set of aliases for
common applications such as ``fin drush``, ``fin composer``, etc.  To
run a script within the build container, use the command syntax:
```$xslt
fin exec /var/www/bin/SCRIPTNAME.sh
```

To open a bash shell into the Docksal Build/CLI container, use
```$xslt
fin bash
```

When creating a custom command for Docksal in the ``.docksal/commands``
directory, you can add the comment
```$xslt
#: exec_target = cli
```
to the top of your script command file to cause it to be executed within the
Build/CLI container instead of running locally.
