# TYPO3 CloudFoundry Skeleton

Delivers a foundation for TYPO3 CMS on any cloudfoundry deployment.

## Primer

This skeleton is based on

- https://github.com/TYPO3/TYPO3.CMS.BaseDistribution/tree/10.x
- https://github.com/cedricziel/typo3-cloudfoundry-skeleton/

## Setup

- Get an account on any cloud service based on CloudFoundry
- Create a new app instance and a MySQL database on the cloud service
- Login using `cf login`
- Push all local files using `cf push` - This will return the URI of the app
  - Since the database is empty yet, the app frontend will show an error message
- Database setup
  - Option A: Autogenerate a new site
    - Prepare local files
      ```bash
      touch web/typo3conf/ENABLE_INSTALL_TOOL`
      touch web/FIRST_INSTALL`
      rm web/typo3conf/LocalConfiguration.php`
      cf push
      ```
    - Run site generation on instance
      ```bash
      cf enable-ssh <app-name>
      cf ssh # this will SSH into the instance
      php vendor/bin/typo3cms install:setup
      ```
      or use the webview of the app (redirects to the installation process)
    - Copy generated settings back to your Git repository
      ```bash
      cf files <app-name> web/typo3conf/LocalConfiguration.php > web/typo3conf/LocalConfiguration.php
      rm web/typo3conf/ENABLE_INSTALL_TOOL
      rm web/FIRST_INSTALL
      cf push
      ```
  - Option B: Import an existing site
    - Save a database dump into the root directory
    - Push dump to instance
      ```bash
      cf push
      ```
    - Import site on instance
      ```bash
      cf enable-ssh <app-name>
      cf ssh # this will SSH into the instance
      cat database.sql | php vendor/bin/typo3cms database:import
      ```

## Configuration

- CloudStack PHP Buildpack (webserver and installed PHP extensions) see [.bp-config/options.json]().
  - See [CloudFoundry PHP Buildpack Options](https://docs.cloudfoundry.org/buildpacks/php/gsg-php-config.html).
- CloudStack PHP Settings see [.bp-config/php/php.ini.d/settings.ini]()
- TYPO3 Settings see [web/typo3conf/LocalConfiguration.php]()

### Environment variables

Either use `cf set-env <app-name> <env variable name> <env variable value>`
or edit the env block of the manifest file.

On local development machines you may also copy the `.env.template` to `.env`
and set all desired values like database credentials or application context.

### Persistent File Storage

CloudFoundry runs instances which use
[a new disk image for each start](https://docs.cloudfoundry.org/devguide/deploy-apps/prepare-to-deploy.html#filesystem).
This means that the local file system storage is short-lived and can not be used
to persist editorial files stored in TYPO3's »fileadmin«.

TYPO3 supports
[different drivers for the file storage](https://docs.typo3.org/m/typo3/reference-coreapi/master/en-us/ApiOverview/Fal/Administration/Storages.html)
besides the default »local file system«. These drivers are provided by 
[third party extensions](https://extensions.typo3.org/?L=0&id=1&tx_solr%5Bq%5D=fal+driver)
and connect instances to AWS S3, Dropbox, Google Drive, or any fileserver
supporting SFTP.

Note that temporary files are no problem here. CloudFoundry recreates most of 
them during `composer install` while the instance is spinning up.
TYPO3 recreates cache files whenever they are missing.

## License

GNU General Public License version 2 or later

The GNU General Public License can be found at http://www.gnu.org/copyleft/gpl.html.

## Author

Dan Untenzu (<untenzu@webit.de> / [@pixelbrackets](https://github.com/pixelbrackets))
for webit! Gesellschaft für neue Medien mbH (http://www.webit.de/)

The skeleton is based on a [prototype](https://github.com/cedricziel/typo3-cloudfoundry-skeleton/)
by [Cedric Ziel](https://github.com/cedricziel).

## Contribution

> TYPO3 - inspiring people to share!

This package is Open Source, so please use, patch, extend or fork it.
