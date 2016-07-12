<?php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * Class MenuItem
 * @package AppBundle\Entity
 * @ORM\Entity(repositoryClass="AppBundle\Repository\MenuItemRepository")
 * @ORM\Table(name="menu_items")
 */
class MenuItem
{
    use CreateUpdateTrait;

    /**
     * @var String
     * @ORM\Column(type="string")
     */
    protected $title;

    /**
     * @ORM\Column(type="integer", options={"default":0}, nullable=true)
     */
    protected $parent;

    /**
     * @var String
     * @Assert\NotBlank(message="Поле обовязкове")
     * @ORM\Column(type="string", nullable=false)
     */
    protected $url;

    /**
     * @var integer
     * @ORM\Column(type="integer", options={"default":0}, nullable=true)
     */
    protected $weight;

    /**
     * @return String
     */
    public function getTitle()
    {
        return $this->title;
    }

    /**
     * @param String $title
     */
    public function setTitle($title)
    {
        $this->title = $title;
    }

    /**
     * @return mixed
     */
    public function getParent()
    {
        return $this->parent;
    }

    /**
     * @param mixed $parent
     */
    public function setParent($parent)
    {
        $this->parent = $parent;
    }

    /**
     * @return String
     */
    public function getUrl()
    {
        return $this->url;
    }

    /**
     * @param String $url
     */
    public function setUrl($url)
    {
        $this->url = $url;
    }

    /**
     * @return int
     */
    public function getWeight()
    {
        return $this->weight;
    }

    /**
     * @param int $weight
     */
    public function setWeight($weight)
    {
        $this->weight = $weight;
    }
}