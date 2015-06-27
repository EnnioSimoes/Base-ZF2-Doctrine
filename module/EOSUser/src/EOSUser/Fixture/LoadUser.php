<?php

namespace EOSUser\Fixture;

use Doctrine\Common\DataFixtures\AbstractFixture;
use Doctrine\Common\Persistence\ObjectManager;
use EOSUser\Entity\User;


class LoadUser extends AbstractFixture
{
    public function load(ObjectManager $manager) 
    {
        $user = new User();
        $user->setNome('Ennio')
                ->setEmail('ennio@simoes.com.br')
                ->setPassword(123456)
                ->setActive(TRUE);
        $manager->persist($user);
        $manager->flush();
    }
}
