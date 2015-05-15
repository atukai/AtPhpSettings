<?php

namespace AtPhpSettings;

use Zend\Mvc\MvcEvent;

class Module
{
    /**
     * @return array
     */
    public function getAutoloaderConfig()
    {
        return array(
            'Zend\Loader\StandardAutoloader' => array(
                'namespaces' => array(
                    __NAMESPACE__ => __DIR__ . '/src/' . __NAMESPACE__,
                ),
            ),
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
            $events = $application->getEventManager();
            $events->attach(MvcEvent::EVENT_ROUTE, array($this, 'applyPhpSettings'));
        }
    }

    public function applyPhpSettings(MvcEvent $e)
    {
        $application = $e->getApplication();
        $config = $application->getConfig();
        $matches = $e->getRouteMatch();

        $phpSettings = $config['php_settings'];

        // Check for controller-specific php settings
        if (isset($phpSettings['controllers']) && is_array($phpSettings['controllers'])) {
            $controller = $matches->getParam('controller');
            $controllerPhpSettings = $phpSettings['controllers'];


            if (isset($controllerPhpSettings[$controller]) && is_array($controllerPhpSettings[$controller])) {
                $phpSettings = array_merge($phpSettings, $controllerPhpSettings[$controller]);
            }
        }

        // Check for route-specific php settings
        if (isset($phpSettings['routes']) && is_array($phpSettings['routes'])) {
            $route = $matches->getMatchedRouteName();
            $routePhpSettings = $phpSettings['routes'];

            if (isset($routePhpSettings[$route]) && is_array($routePhpSettings[$route])) {
                $phpSettings = array_merge($phpSettings, $routePhpSettings[$route]);
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
        return array(
            'service_manager' => array(
                'invokables' => array(
                    'AtPhpSettings\Collector\PhpSettingsCollector' => 'AtPhpSettings\Collector\PhpSettingsCollector',
                ),
            ),

            'view_manager' => array(
                'template_map' => array(
                    'zend-developer-tools/toolbar/at-php-settings' => __DIR__ . '/view/zend-developer-tools/toolbar/at-php-settings.phtml'
                )
            ),

            'zenddevelopertools' => array(
                'profiler' => array(
                    'collectors' => array(
                        'at_php_settings' => 'AtPhpSettings\Collector\PhpSettingsCollector',
                    ),
                ),
                'toolbar' => array(
                    'entries' => array(
                        'at_php_settings' => 'zend-developer-tools/toolbar/at-php-settings',
                    ),
                ),
            ),

            'php_settings' => array(
                // Global php settings
                'display_startup_errors' => false,
                'display_errors'         => false,
                'max_execution_time'     => 30,
                'date.timezone'          => 'UTC',

                // Controller-specific php settings
                'controllers' => array(),

                // Route-specific php settings
                'routes' => array(),
            ),
        );
    }
}
