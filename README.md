# Mautic Sentry Bundle


Empty Mautic plugin bundle (zero functionality). Tested on **Mautic 4**. Go ahead use this boilerplate and provide more custom functionality to Mautic - Open source Marketing Automation Tool.

## Getting Started

### Prerequisites

* Composer
* Mautic 5
* [Sentry](https://docs.sentry.io/platforms/php/guides/symfony/integrations/monolog/)


### Installing

Install sentry package.

```
composer require sentry/sentry-symfony
```

Copy monolog extension configuration from prod/dev app config in app/config folder to config/config_local.php.

And then extend monolog config with this configuration for Sentry:

```
'handlers' => [

        /*
         * Other handlers....
         */
    'sentry' => [
        'type'     => 'service',
        'id'       => 'mzagmajster.sentry.handler.sentry',            
        'channels' => ['!event'],
    ],
],
```

Add variables to .env.local:

```
SENTRY_DSN=<dsn>

# These are passed to Sentry Monolog Handler
MAUTIC_SENTRY_MONOLOG_LEVEL=error
MAUTIC_SENTRY_MONOLOG_BUBBLE=true
MAUTIC_SENTRY_MONOLOG_FILL_EXTRA_CONTEXT=false
```

Use hooks from .githooks folder on project by executing:

```
./bin/init.sh
```

**Initial install** described below.

```
cd <mautic-root-folder>
rm -rf var/cache/dev/* var/cache/prod/*
cd plugins
git clone <repo-url> MZagmajsterSentryBundle
cd <mautic-root-folder>
composer install  # You only need this druing development.
php bin/console mautic:plugins:install --dev  # You should get a message saying one or more plugins have been installed in terminal.
```


Typical **update** of plugin source code described below.

* Make sure plugin root folder is clean from git´s point of view.

```
cd <mautic-root-folder>
rm -rf var/cache/dev/* var/cache/prod/*
cd plugins/MZagmajsterSentryBundle
git pull origin <branch>
php bin/console mautic:plugins:reload --dev  # You should get a message saying one or more plugins have been installed in terminal.
```

## Running the tests

[No tests yet.]

### Coding style

Please use style fixer from Mautic core.

## Deployment

* You do not have to install any composer packages inside plugin folder since we only use it during development.
* When you are deploying the plugin make sure you call ```php bin/console``` command without --dev switch.

## Changelog

[No changelog yet.]

## Documentation

[No documentation yet.]

## Built With

* [Mautic](https://github.com/mautic/) - Open Source Marketing Automation Tool
* [Composer](https://getcomposer.org/) - Dependency Management

## Contributing

Please read ```CONTRIBUTING.md``` for details on our code of conduct, and the process for submitting pull requests to us.

## Versioning

We use [SemVer](http://semver.org/) for versioning. For the versions available, see the tags on this repository. 

## Authors

Content in this project was provided by [Matic Zagmajster](http://maticzagmajster.ddns.net/). For more information please see ```AUTHORS``` file.


