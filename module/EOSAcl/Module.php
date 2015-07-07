<?php

namespace EOSAcl;

use Zend\Mvc\MvcEvent;
use Zend\ModuleManager\ModuleManager;//Com esse é possivel pegar o EventManager com todos eventos compartilhados no ZF2

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
            'factories' => array(
                'EOSAcl\Form\Role' => function($sm){
                    $em = $sm->get('Doctrine\ORM\EntityManager');
                    $repo = $em->getRepository('EOSAcl\Entity\Role');
                    $parent = $repo->fetchParent();
                    
                    return new Form\Role('role', $parent);
                },
                'EOSAcl\Form\Privilege' => function($sm){
                    $em = $sm->get('Doctrine\ORM\EntityManager');
                    $repoRoles = $em->getRepository('EOSAcl\Entity\Role');
                    $roles = $repoRoles->fetchParent();
                    
                    $repoResources = $em->getRepository('EOSAcl\Entity\Resource');
                    $resources = $repoResources->fetchPairs();
                    
                    return new Form\Privilege("privilege", $roles, $resources);
                },
                'EOSAcl\Service\Role' => function($sm){
                    return new Service\Role($sm->get('Doctrine\ORM\EntityManager'));
                },
                'EOSAcl\Service\Resource' => function($sm){
                    return new Service\Resource($sm->get('Doctrine\ORM\EntityManager'));
                },
                'EOSAcl\Service\Privilege' => function($sm){
                    return new Service\Privilege($sm->get('Doctrine\ORM\EntityManager'));
                },
                'EOSAcl\Permissions\Acl' => function($sm){
                    $em = $sm->get('Doctrine\ORM\EntityManager');
                    $repoRole = $em->getRepository('EOSAcl\Entity\Role');
                    $roles = $repoRole->findAll();
                    
                    $repoResource = $em->getRepository('EOSAcl\Entity\Resource');
                    $resources = $repoResource->findAll();
                    
                    $repoPrivilege = $em->getRepository('EOSAcl\Entity\Privilege');
                    $privileges = $repoPrivilege->findAll();
                    
                    return new Permissions\Acl($roles, $resources, $privileges);
                },
            )
        );
    }
}
