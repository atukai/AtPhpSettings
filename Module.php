<?php

namespace AtPhpSettings;

use Zend\Mvc\MvcEvent;

class Module
{
    /**
     * Configure PHP ini settings
     *
     * @param \Zend\Mvc\MvcEvent $e
     */
    public function onBootstrap(MvcEvent $e)
    {
        $app         = $e->getParam('application');
        $config      = $app->getConfig();
        $phpSettings = $config['php_settings'];

        if ($phpSettings) {
            foreach ($phpSettings as $key => $value) {
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
            'php_settings' => array(
                'display_startup_errors' => false,
                'display_errors'         => false,
                'max_execution_time'     => 30,
                'date.timezone'          => 'UTC'
            ),
        );
    }
}