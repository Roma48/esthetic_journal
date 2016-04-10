<?php

namespace AppBundle\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ORM\Mapping as ORM;
use Gedmo\Mapping\Annotation as Gedmo;
use Symfony\Component\HttpFoundation\Tests\StringableObject;
use Symfony\Component\Security\Core\Role\RoleInterface;
use Symfony\Component\Security\Core\User\UserInterface;

/**
 * Class User
 * @package AppBundle\Entity
 * @ORM\Entity(repositoryClass="AppBundle\Repository\RoleRepository")
 * @ORM\Table(name="roles")
 */
class Role implements RoleInterface
{
    /**
     * @var Integer
     * @ORM\Column(type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    protected $id;

    /**
     * @var String
     * @ORM\Column(type="string")
     */
    protected $role;

//    /**
//     * @var ArrayCollection
//     * @ORM\OneToMany(targetEntity="AppBundle\Entity\User", mappedBy="roles")
//     */
//    protected $users;
//
//    /**
//     * Role constructor.
//     */
//    public function __construct()
//    {
//        $this->users = new ArrayCollection();
//    }

//    /**
//     * @return ArrayCollection
//     */
//    public function getUsers()
//    {
//        return $this->users;
//    }
//
//    /**
//     * @param User $user
//     * @return $this
//     */
//    public function addUser(User $user)
//    {
//        $this->users->add($user);
//
//        return $this;
//    }
//
//    public function removeUser(User $user)
//    {
//        $this->users->remove($user);
//
//        return $this;
//    }

    /**
     * @return int
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * @param int $id
     */
    public function setId($id)
    {
        $this->id = $id;
    }

    /**
     * @return String
     */
    public function getRole()
    {
        return $this->role;
    }

    /**
     * @param String $role
     */
    public function setRole($role)
    {
        $this->role = $role;
    }
}