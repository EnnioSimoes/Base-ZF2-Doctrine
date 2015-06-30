<?php

namespace EOSUser;

use Zend\Mvc\MvcEvent;
use Zend\Mail\Transport\Smtp as SmtpTransport;
use Zend\Mail\Transport\SmtpOptions;
use EOSUser\Auth\Adapter as AuthAdapter;
use Zend\Authentication\AuthenticationService;
use Zend\Authentication\Storage\Session as SessionStorage;

use Zend\ModuleManager\ModuleManager;//Com esse é possivel pegar o EventManager com todos eventos compartilhados no ZF2

use Zend\ModuleManager\Feature\ViewHelperProviderInterface;
use Zend\ModuleManager\Feature\AutoloaderProviderInterface;
use Zend\ModuleManager\Feature\ConfigProviderInterface;
/**
 * Description of Module
 *
 * @author ennio
 */
class Module implements ViewHelperProviderInterface, AutoloaderProviderInterface, ConfigProviderInterface
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
    
    public function init(ModuleManager $moduleManager) 
    {
        $sharedEvents = $moduleManager->getEventManager()->getSharedManager();
        $sharedEvents->attach("Zend\Mvc\Controller\AbstractActionController",
                MvcEvent::EVENT_DISPATCH,
                array($this, 'validaAuth'),100);
    }
    
    public function validaAuth($e)
    {
        $auth = new AuthenticationService;
        $auth->setStorage(new SessionStorage("EOSUser"));
        
        $controller = $e->getTarget();
        $matchedRoute = $controller->getEvent()->getRouteMatch()->getMatchedRouteName();
        
        if(!$auth->hasIdentity() and ($matchedRoute == "eosuser-admin" OR $matchedRoute == "eosuser-admin/paginator")){
            return $controller->redirect()->toRoute("eosuser-auth");
        }
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
                'EOSUser\Auth\Adapter' => function($sm){
                    return new AuthAdapter($sm->get('Doctrine\ORM\EntityManager'));
                },   
            )
        );
        
    }

    public function getViewHelperConfig() {
        return array(   
//            'invokables' => array(
//                'UserIdentity' => new View\Helper\UserIdentity()
//            ),
            'factories' => array(
                'UserIdentity' => function($sm) {
                    $helper = new View\Helper\UserIdentity;
                    return $helper;
                }
            )
        );        
    }
}
