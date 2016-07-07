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
     * @ORM\Column(type="string", nullable=true)
     */
    protected $childs;

    /**
     * @var String
     * @Assert\NotBlank(message="Поле обовязкове")
     * @ORM\Column(type="string", nullable=false)
     */
    protected $url;

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
     * @return mixed
     */
    public function getChilds()
    {
        $childs = json_decode($this->childs);

        return $childs;
    }

    /**
     * @param MenuItem $childs
     */
    public function setChilds(MenuItem $childs)
    {
        $existsChilds = $this->getChilds();

        $childItem = [
            'id' => $childs->getId(),
            'url' => $childs->getUrl(),
            'title' => $childs->getTitle()
        ];

        $existsChilds[] = $childItem;

        $this->childs = json_encode($existsChilds);
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
}