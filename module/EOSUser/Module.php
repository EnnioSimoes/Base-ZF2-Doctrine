<?php

namespace EOSUser;

use Zend\Mvc\MvcEvent;
use Zend\Mail\Transport\Smtp as SmtpTransport;
use Zend\Mail\Transport\SmtpOptions;
/**
 * Description of Module
 *
 * @author ennio
 */
class Module 
{
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
    
    public function getConfig()
    {
        return include __DIR__ . '/config/module.config.php';
    }    
    
    public function getServiceConfig()
    {
        return array(
            'factories' => array(
                'EOSUser\Mail\Transport' => function($sm){
                    $config = $sm->get('Config');
                    
                    $transport = new SmtpTransport;
                    $options = new SmtpOptions($config['mail']);
                    $transport->setOptions($options);
                    
                    return $transport;
                },   
                'EOSUser\Service\User' => function($sm){
                    $view = $sm->get('View');
                    return new Service\User($sm->get('Doctrine\ORM\EntityManager'),
                                            $sm->get('EOSUser\Mail\Transport'),
                                            $sm->get('View')
                                            );
                },   
            )
        );
        
    }    
}
