<?php

namespace EOSAcl\Fixture;

use Doctrine\Common\DataFixtures\AbstractFixture;
use Doctrine\Common\Persistence\ObjectManager;
use EOSAcl\Entity\Resource;

use Doctrine\Common\DataFixtures\OrderedFixtureInterface;

class LoadResource extends AbstractFixture implements OrderedFixtureInterface
{
    public function load(ObjectManager $manager) 
    {
        $resource = new Resource;
        $resource->setNome('Posts');
        
        $manager->persist($resource);
        
        $resource = new Resource;
        $resource->setNome('Páginas');
        
        $manager->persist($resource);
        
        $manager->flush();
    }

    public function getOrder() {
        return 2;
    }

}
