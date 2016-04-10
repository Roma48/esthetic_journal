<?php

namespace AppBundle\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ORM\Mapping as ORM;
use Gedmo\Mapping\Annotation as Gedmo;
use Symfony\Component\HttpFoundation\Tests\StringableObject;
use Symfony\Component\Security\Core\User\UserInterface;

/**
 * Class User
 * @package AppBundle\Entity
 * @ORM\Entity(repositoryClass="AppBundle\Repository\UserRepository")
 * @ORM\Table(name="users")
 */
class User implements UserInterface, \Serializable
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
     * @ORM\Column(type="string", length=25, unique=true)
     */
    protected $username;

    /**
     * @var String
     * @ORM\Column(type="string")
     */
    protected $roles;

    /**
     * @var String
     * @ORM\Column(type="string", length=64)
     *
     */
    protected $password;

    /**
     *
     *
     */
    private $plainPassword;

    /**
     * @var String
     * @ORM\Column(type="string")
     */
    protected $salt;

    /**
     * @ORM\Column()
     * @Gedmo\Slug(fields={"firstName", "lastName"})
     */
    protected $slug;

    /**
     * @var String
     * @ORM\Column(type="string")
     */
    protected $firstName;

    /**
     * @var String
     * @ORM\Column(type="string")
     */
    protected $lastName;

    /**
     * @var
     * @ORM\Column(type="integer", nullable=true)
     */
    protected $age;

//    /**
//     * @var
//     * @ORM\Column(type="datetime", nullable=true)
//     */
//    protected $birthDay;

    /**
     * @var
     * @ORM\OneToMany(targetEntity="Article", mappedBy="users")
     */
    protected $article;

    /**
     * @var
     * @ORM\OneToMany(targetEntity="AppBundle\Entity\Like", mappedBy="user")
     */
    protected $like;

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
    public function getFirstName()
    {
        return $this->firstName;
    }

    /**
     * @param String $firstName
     */
    public function setFirstName($firstName)
    {
        $this->firstName = $firstName;
    }

    /**
     * @return String
     */
    public function getLastName()
    {
        return $this->lastName;
    }

    /**
     * @param String $lastName
     */
    public function setLastName($lastName)
    {
        $this->lastName = $lastName;
    }

    /**
     * @return mixed
     */
    public function getSlug()
    {
        return $this->slug;
    }

    /**
     * @param mixed $slug
     */
    public function setSlug($slug)
    {
        $this->slug = $slug;
    }

    /**
     * @return mixed
     */
    public function getAge()
    {
        return $this->age;
    }

    /**
     * @param mixed $age
     */
    public function setAge($age)
    {
        $this->age = $age;
    }

//    /**
//     * @return mixed
//     */
//    public function getBirthDay()
//    {
//        return $this->birthDay;
//    }
//
//    /**
//     * @param mixed $birthDay
//     */
//    public function setBirthDay($birthDay)
//    {
//        $this->birthDay = $birthDay;
//    }

    /**
     * @return mixed
     */
    public function getArticle()
    {
        return $this->article;
    }

    /**
     * @param mixed $article
     */
    public function setArticle($article)
    {
        $this->article = $article;
    }

    /**
     * @return mixed
     */
    public function getLike()
    {
        return $this->like;
    }

    /**
     * @param mixed $like
     */
    public function setLike($like)
    {
        $this->like = $like;
    }

    /**
     * @return String
     */
    public function getUsername()
    {
        return $this->username;
    }

    /**
     * @param String $username
     */
    public function setUsername($username)
    {
        $this->username = $username;
    }

    /**
     * @return String
     */
    public function getRoles()
    {
        return [$this->roles];
    }

    /**
     * @param String $roles
     */
    public function setRoles($roles)
    {
        $this->roles = $roles;
    }

    /**
     * @return String
     */
    public function getPassword()
    {
        return $this->password;
    }

    /**
     * @param String $password
     */
    public function setPassword($password)
    {
        $this->password = $password;
    }

    /**
     * @return String
     */
    public function getSalt()
    {
        return $this->salt;
    }

    /**
     * @param String $salt
     */
    public function setSalt($salt)
    {
        $this->salt = $salt;
    }

    public function eraseCredentials()
    {

    }

    /**
     * @return mixed
     */
    public function getPlainPassword()
    {
        return $this->plainPassword;
    }

    /**
     * @param mixed $plainPassword
     */
    public function setPlainPassword($plainPassword)
    {
        $this->plainPassword = $plainPassword;
    }



    /** @see \Serializable::serialize() */
    public function serialize()
    {
        return serialize(array(
            $this->id,
            $this->username,
            $this->password,
            // see section on salt below
            // $this->salt,
        ));
    }

    /** @see \Serializable::unserialize() */
    public function unserialize($serialized)
    {
        list (
            $this->id,
            $this->username,
            $this->password,
            // see section on salt below
            // $this->salt
            ) = unserialize($serialized);
    }


}