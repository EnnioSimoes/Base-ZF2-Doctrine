<?php

namespace EOSAcl;

use Zend\Mvc\MvcEvent;
use Zend\ModuleManager\ModuleManager;//Com esse é possivel pegar o EventManager com todos eventos compartilhados no ZF2

use Zend\ModuleManager\Feature\ViewHelperProviderInterface;
use Zend\ModuleManager\Feature\AutoloaderProviderInterface;
use Zend\ModuleManager\Feature\ConfigProviderInterface;
/**
 * Description of Module
 *
 * @author ennio
 */
class Module implements AutoloaderProviderInterface, ConfigProviderInterface
{
        
    public function getConfig()
    {
        return include __DIR__ . '/config/module.config.php';
    }    
    
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
    
    public function getServiceConfig()
    {
        return array(
        );
        
    }
}
