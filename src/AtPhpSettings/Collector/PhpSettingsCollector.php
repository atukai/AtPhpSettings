<?php

namespace AtPhpSettings\Collector;

use Zend\Mvc\MvcEvent;
use ZendDeveloperTools\Collector\AbstractCollector;

class PhpSettingsCollector extends AbstractCollector
{
    /**
     * Collector priority
     */
    const PRIORITY = 500;

    /**
     * Collector Name.
     *
     * @return string
     */
    public function getName()
    {
        return 'at_php_settings';
    }

    /**
     * Collector Priority.
     *
     * @return integer
     */
    public function getPriority()
    {
        return self::PRIORITY;
    }

    /**
     * Collects data.
     *
     * @param MvcEvent $mvcEvent
     */
    public function collect(MvcEvent $mvcEvent)
    {
        $this->collectPhpSettings();
    }


    /**
     * Collect php settings
     *
     * @return void
     */
    private function collectPhpSettings()
    {
        foreach (ini_get_all() as $name => $values) {
            $this->data['php_settings'][$name] = $values['local_value'];
        }
    }

    /**
     * @return mixed
     */
    public function getPhpSettings()
    {
        return $this->data['php_settings'];
    }
}
