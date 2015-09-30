# AtPhpSettings

A ZF2 module for configuring a php settings.

[![Scrutinizer Quality Score](https://scrutinizer-ci.com/g/atukai/AtPhpSettings/badges/quality-score.png?s=08fae8e160eae4fc27ed99d6331c6cba6a24a406)](https://scrutinizer-ci.com/g/atukai/AtPhpSettings/)


## Requirements

* [PHP 5.4+](http://php.net)
* [Zend MVC](https://github.com/zendframework/zend-mvc)
* [Zend EventManager](https://github.com/zendframework/zend-eventmanager)

## Features

* Global, per controller, and per route configuration of php.ini settings
* Zend Developer Tools Collector

## Installation

 1. Add `"atukai/at-php-settings": "dev-master"` to your `composer.json` file and run `php composer.phar update`.
 2. Add `AtPhpSettings` to your `config/application.config.php` file under the `modules` key.

## Configuration

To configure the php settings as you required, add the following to your config/autoload/global.php file:

```PHP
'php_settings' => [
    'display_startup_errors'     => false,
    'display_errors'             => true,
    'max_execution_time'         => 30,
    'date.timezone'              => 'UTC',

    'controllers' => [
        'Application\Controller\Index' => [
            'memory_limit' => '64M',
        ],
    ],

    'routes' => [
        'home' => [
            'memory_limit'       => '32M',
            'max_execution_time' => '60',
        ],
    ],
]
