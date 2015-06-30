<?php

namespace EOSUser\Entity;

use Doctrine\ORM\Mapping as ORM;
use Zend\Math\Rand;
use Zend\Crypt\Key\Derivation\Pbkdf2;
use Zend\Stdlib\Hydrator;


/**
 * EosuserUsers
 *
 * @ORM\Table(name="eosuser_users")
 * @ORM\Entity
 * @ORM\HasLifecycleCallbacks
 * @ORM\Entity(repositoryClass="EOSUser\Entity\UserRepository")
 */
class User
{
    /**
     * @var integer
     *
     * @ORM\Column(name="id", type="integer", nullable=false)
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="IDENTITY")
     */
    private $id;

    /**
     * @var string
     *
     * @ORM\Column(name="nome", type="string", length=255, nullable=true)
     */
    private $nome;

    /**
     * @var string
     *
     * @ORM\Column(name="email", type="string", length=255, nullable=true)
     */
    private $email;

    /**
     * @var string
     *
     * @ORM\Column(name="password", type="string", length=255, nullable=true)
     */
    private $password;

    /**
     * @var string
     *
     * @ORM\Column(name="salt", type="string", length=255, nullable=true)
     */
    private $salt;

    /**
     * @var boolean
     *
     * @ORM\Column(name="active", type="boolean", nullable=true)
     */
    private $active;

    /**
     * @var string
     *
     * @ORM\Column(name="activation_key", type="string", length=255, nullable=true)
     */
    private $activationKey;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="update_at", type="datetime", nullable=true)
     */
    private $updateAt;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="created_at", type="datetime", nullable=true)
     */
    private $createdAt;

    public function __construct(array $options = array()) 
    {
        /*
        $hydrator = new Hydrator\ClassMethods();
        $hydrator->hydrate($options, $this);
        */
        (new Hydrator\ClassMethods)->hydrate($options, $this);
        
        $this->createdAt = new \DateTime("now");
        $this->updateAt = new \DateTime("now");
        
        $this->salt = base64_encode(Rand::getBytes(8, TRUE));
        $this->activationKey = md5($this->email.$this->salt);
    }
    
    function getId() {
        return $this->id;
    }

    function getNome() {
        return $this->nome;
    }

    function getEmail() {
        return $this->email;
    }

    function getPassword() {
        return $this->password;
    }

    function getSalt() {
        return $this->salt;
    }

    function getActive() {
        return $this->active;
    }

    function getActivationKey() {
        return $this->activationKey;
    }

    function getUpdateAt() {
        return $this->updateAt;
    }

    function getCreatedAt() {
        return $this->createdAt;
    }

    function setId($id) {
        $this->id = $id;
        return $this;
    }

    function setNome($nome) {
        $this->nome = $nome;
        return $this;
    }

    function setEmail($email) {
        $this->email = $email;
        return $this;
    }

    function setPassword($password) {
        $this->password = $this->encryptPassword($password);
        return $this;
    }

    function encryptPassword($password) 
    {
        return base64_encode(Pbkdf2::calc('sha256', $password, $this->salt, 10000, strlen($password*2)));
    }

    function setSalt($salt) {
        $this->salt = $salt;
        return $this;
    }

    function setActive($active) {
        $this->active = $active;
        return $this;
    }

    function setActivationKey($activationKey) {
        $this->activationKey = $activationKey;
        return $this;
    }

    /*
     * @ORM\prePersist
     */
    function setUpdateAt() {
        $this->updateAt = new \DateTime("now");
    }

    function setCreatedAt() {
        $this->createdAt = new \DateTime("now");
    }

    public function toArray()
    {
        return (new Hydrator\ClassMethods())->extract($this);
    }

}

