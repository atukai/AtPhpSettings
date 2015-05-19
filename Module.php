<?php

namespace AtPhpSettings;

use Zend\EventManager\EventManager;
use Zend\Mvc\MvcEvent;

class Module
{
    /**
     * @return array
     */
    public function getAutoloaderConfig()
    {
        return array(
            'Zend\Loader\StandardAutoloader' => [
                'namespaces' => [
                    __NAMESPACE__ => __DIR__ . '/src/' . __NAMESPACE__,
                ],
            ],
        );
    }

    /**
     * Configure PHP ini settings
     *
     * @param \Zend\Mvc\MvcEvent $e
     */
    public function onBootstrap(MvcEvent $e)
    {
        $application = $e->getParam('application');
        $config      = $application->getConfig();
        $phpSettings = $config['php_settings'];

        if ($phpSettings) {
            /** @var EventManager $events */
            $events = $application->getEventManager();
            $events->attach(MvcEvent::EVENT_ROUTE, [$this, 'applyPhpSettings']);
        }
    }

    /**
     * @param MvcEvent $e
     */
    public function applyPhpSettings(MvcEvent $e)
    {
        $application = $e->getApplication();
        $config = $application->getConfig();
        $matches = $e->getRouteMatch();

        $phpSettings = $config['php_settings'];

        // Check for controller-specific php settings
        if (isset($phpSettings['controllers']) && is_array($phpSettings['controllers']) && !empty($phpSettings['controllers'])) {
            $controller = $matches->getParam('controller');
            $controllerSettings = $phpSettings['controllers'];

            if (isset($controllerSettings[$controller]) && is_array($controllerSettings[$controller])) {
                $phpSettings = array_merge($phpSettings, $controllerSettings[$controller]);
            }
        }

        // Check for route-specific php settings
        if (isset($phpSettings['routes']) && is_array($phpSettings['routes']) && !empty($phpSettings['routes'])) {
            $route = $matches->getMatchedRouteName();
            $routeSettings = $phpSettings['routes'];

            if (isset($routeSettings[$route]) && is_array($routeSettings[$route])) {
                $phpSettings = array_merge($phpSettings, $routeSettings[$route]);
            }
        }

        foreach ($phpSettings as $key => $value) {
            if (!is_array($value)) {
                ini_set($key, $value);
            }
        }
    }

    /**
     * @see http://www.php.net/manual/en/ini.list.php
     * @return array
     */
    public function getConfig()
    {
        return [
            'service_manager' => [
                'invokables' => [
                    'AtPhpSettings\Collector\PhpSettingsCollector' => 'AtPhpSettings\Collector\PhpSettingsCollector',
                ],
            ],

            'view_manager' => [
                'template_map' => [
                    'zend-developer-tools/toolbar/at-php-settings' => __DIR__ . '/view/zend-developer-tools/toolbar/at-php-settings.phtml'
                ]
            ],

            'zenddevelopertools' => [
                'profiler' => [
                    'collectors' => [
                        'at_php_settings' => 'AtPhpSettings\Collector\PhpSettingsCollector',
                    ],
                ],
                'toolbar' => [
                    'entries' => [
                        'at_php_settings' => 'zend-developer-tools/toolbar/at-php-settings',
                    ],
                ],
            ],

            'php_settings' => [
                // Global php settings
                'display_startup_errors' => false,
                'display_errors'         => false,
                'max_execution_time'     => 30,
                'date.timezone'          => 'UTC',

                // Controller-specific php settings
                'controllers' => [],

                // Route-specific php settings
                'routes' => [],
            ],
        ];
    }
}