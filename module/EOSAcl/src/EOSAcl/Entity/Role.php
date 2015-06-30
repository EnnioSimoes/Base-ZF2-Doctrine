<?php

namespace EOSAcl\Entity;

use Doctrine\ORM\Mapping as ORM;
use Zend\Stdlib\Hydrator;


/**
 * @ORM\Entity
 * @ORM\HasLifecycleCallbacks
 * @ORM\Table(name="eosacl_roles")
 * @ORM\Entity(repositoryClass="EOSAcl\Entity\RoleRepository")
 */
class Role
{
    /**
     * @ORM\Id
     * @ORM\Column(type="integer")
     * @ORM\GeneratedValue)
     */    
    protected $id;
    /**
     * @ORM\OneToOne(targetEntity="EOSAcl\Entity\Role")
     * @ORM\JoinColumn(name="parent_id", referenceColumnName="id")
     */    
    protected $parent;
    /**
     * @ORM\Column(type="text")
     * @var string
     */      
    protected $nome;
    /**
     * @ORM\Column(type="boolean" name="is_admin")
     * @var boolean
     */      
    protected $isAdmin;
    /**
     * @ORM\Column(type="datetime", name="created_at")
     */          
    protected $createdAt;
    /**
     * @ORM\Column(type="datetime", name="updated_at")
     */
    protected $updatedAt;

    public function __construct($options = array())
    {
        (new Hydrator\ClassMethods)->hydrate($options, $this);
        $this->createdAt = new \DateTime('now');
        $this->updatedAt = new \DateTime('now');
    }
    
    function getId() {
        return $this->id;
    }

    function getParent() {
        return $this->parent;
    }

    function getNome() {
        return $this->nome;
    }

    function getIsAdmin() {
        return $this->isAdmin;
    }

    function getCreatedAt() {
        return $this->createdAt;
    }

    function getUpdatedAt() {
        return $this->updatedAt;
    }

    function setId($id) {
        $this->id = $id;
        return $this;
    }

    function setParent($parent) {
        $this->parent = $parent;
        return $this;
    }

    function setNome($nome) {
        $this->nome = $nome;
        return $this;
    }

    function setIsAdmin($isAdmin) {
        $this->isAdmin = $isAdmin;
        return $this;
    }

    function setCreatedAt() {
        $this->createdAt = new \DateTime('now');
        return $this;
    }
    /**
     * @ORM\PrePersist
     */
    function setUpdatedAt() {
        $this->updatedAt = new \DateTime('now');
        return $this;
    }

    public function toArray()
    {
        if(isset($this->parent)){
            $parent = $this->parent->getId();
        }else{
            $parent = false;
        }
        return array(
            'id' => $this->id,
            'nome' => $this->nome,
            'isAdmin'=> $this->isAdmin,
            'parent'=> $parent
        );
        
    }

}

