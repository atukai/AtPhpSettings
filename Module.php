<?php

namespace AtPhpSettings;

use Zend\Mvc\MvcEvent;

class Module
{
    /**
     * Configure PHP ini settings on the bootstrap event
     *
     * @param \Zend\Mvc\MvcEvent $e
     */
    public function onBootstrap(MvcEvent $e)
    {
        $app         = $e->getParam('application');
        $config      = $app->getConfig();
        $phpSettings = $config['phpsettings'];

        if ($phpSettings) {
            foreach($phpSettings as $key => $value) {
                ini_set($key, $value);
            }
        }
    }
}