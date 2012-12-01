# AtPhpSettings

Version 1.0.0

A ZF2 module for configuring a php settings.

## Requirements

* [Zend Framework 2](https://github.com/zendframework/zf2)


## Installation

 1. Add `"atukai/at-php-settings": "dev-master"` to your `composer.json` file and run `php composer.phar update`.
 2. Add `AtPhpSettings` to your `config/application.config.php` file under the `modules` key.

## Configuration

To configure the php settings as you required, add the following to your config/autoload/global.php file:

    'php_settings' => array(
        'display_startup_errors'     => false,
        'display_errors'             => true,
        'max_execution_time'         => 30,
        'date.timezone'              => 'UTC',
    )

Add additional configuration keys as needed.