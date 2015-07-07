<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace EOSUser\Entity;
use Doctrine\ORM\EntityRepository;

/**
 * Description of UserRepository
 *
 * @author ennio
 */
class UserRepository extends EntityRepository
{
    public function findByEmailAndPassword($email, $password) 
    {
        $user = $this->findOneByEmail($email);
        if($user){
            $hashSenha = $user->encryptPassword($password);
            if($hashSenha == $user->getPassword()){
                return $user;
            } else {
                return false;   
            }
        } else {
            return false;
        }
    }
    
    public function findArray(){
        $users = $this->findAll();
        $a = array();
        foreach ($users as $user) {
            $a[$user->getId()]['id'] = $user->getId();
            $a[$user->getId()]['nome'] = $user->getNome();
            $a[$user->getId()]['email'] = $user->getEmail();
        }
        return $a;
    }
}
