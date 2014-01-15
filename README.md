# AtPhpSettings

[![Bitdeli Badge](https://d2weczhvl823v0.cloudfront.net/atukai/atphpsettings/trend.png)](https://bitdeli.com/free "Bitdeli Badge")[![Scrutinizer Quality Score](https://scrutinizer-ci.com/g/atukai/AtPhpSettings/badges/quality-score.png?s=08fae8e160eae4fc27ed99d6331c6cba6a24a406)](https://scrutinizer-ci.com/g/atukai/AtPhpSettings/)

Version 1.1.0

A ZF2 module for configuring a php settings.

## Requirements

* [Zend Framework 2](https://github.com/zendframework/zf2)

## Features

* Global, per controller, and per route configuration of php.ini settings
* Zend Developer Tools Collector

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

        'controllers' => array(
		    'Application\Controller\Index' => array(
			    'memory_limit' => '64M',
		    ),
	    ),

	   'routes' => array(
		    'home' => array(
			    'memory_limit'       => '32M',
			    'max_execution_time' => '60',
		    ),
	   ),
    )

Add additional configuration keys as needed.