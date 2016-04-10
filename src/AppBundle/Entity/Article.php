<?php

namespace AppBundle\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ORM\Mapping as ORM;
use Gedmo\Mapping\Annotation as Gedmo;
use AppBundle\Entity\Image;

/**
 * @ORM\Entity()
 * @ORM\Table(name="articles")
 * @ORM\Entity(repositoryClass="AppBundle\Repository\ArticleRepository")
 */
class Article
{

    /**
     * @ORM\Column(type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    protected $id;

    /**
     * @ORM\Column(type="string")
     *
     */
    protected $title;

    /**
     * @ORM\Column()
     * @Gedmo\Slug(fields={"title"})
     */
    protected $slug;

    /**
     * @var
     * @ORM\Column(type="text")
     */
    protected $description;

    /**
     * @var
     * @ORM\Column(type="text")
     */
    protected $content;

    /**
     * @var
     * @ORM\ManyToOne(targetEntity="Category", inversedBy="articles")
     */
    protected $categories;

    /**
     * @var
     * @ORM\OneToMany(targetEntity="Comment", mappedBy="article")
     */
    protected $comments;

    /**
     * @var
     * @ORM\ManyToOne(targetEntity="User", inversedBy="article")
     */
    protected $users;

    /**
     * @var
     * @ORM\OneToMany(targetEntity="Like", mappedBy="article")
     */
    protected $likes;

    /**
     * @var
     * @ORM\Column(type="integer", nullable=true)
     */
    protected $views;

    /**
     * @var
     * @ORM\ManyToOne(targetEntity="Image", inversedBy="article", cascade={"persist"})
     */
    protected $image;


    public function __construct()
    {
        $this->likes = new ArrayCollection();
        $this->comments = new ArrayCollection();
    }

    /**
     * @return mixed
     */
    public function getUsers()
    {
        return $this->users;
    }

    /**
     * @param mixed $users
     */
    public function setUsers($users)
    {
        $this->users = $users;
    }


    /**
     * @return mixed
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * @param mixed $id
     */
    public function setId($id)
    {
        $this->id = $id;
    }

    /**
     * @return mixed
     */
    public function getTitle()
    {
        return $this->title;
    }

    /**
     * @param mixed $title
     */
    public function setTitle($title)
    {
        $this->title = $title;
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
    public function getDescription()
    {
        return $this->description;
    }

    /**
     * @param mixed $description
     */
    public function setDescription($description)
    {
        $this->description = $description;
    }

    /**
     * @return mixed
     */
    public function getContent()
    {
        return $this->content;
    }

    /**
     * @param mixed $content
     */
    public function setContent($content)
    {
        $this->content = $content;
    }

    /**
     * @return mixed
     */
    public function getCategories()
    {
        return $this->categories;
    }

    /**
     * @param mixed $categories
     */
    public function setCategories($categories)
    {
        $this->categories = $categories;
    }

    /**
     * @return mixed
     */
    public function getComments()
    {
        return $this->comments;
    }

    /**
     * @param Comment $comment
     * @return $this
     */
    public function addComment(Comment $comment)
    {
        $comment->setArticle($this);
        $this->comments->add($comment);
        return $this;
    }

    /**
     * @return mixed
     */
    public function getLikes()
    {
        return $this->likes;
    }

    /**
     * @param Like $likes
     * @return $this
     */
    public function addLike(Like $likes)
    {
        $likes->setArticle($this);
        $this->likes->add($likes);
        return $this;
    }

    /**
     * @param Like $likes
     */
    public function removeLike(Like $likes)
    {
        $this->likes->removeElement($likes);
    }

    /**
     * @return mixed
     */
    public function getViews()
    {
        return $this->views;
    }

    /**
     * @param mixed $views
     */
    public function setViews($views)
    {
        $this->views = $views;
    }

    /**
     * @return String
     */
    public function getImage()
    {
        return $this->image;
    }

    /**
     * @param Image $image
     * @return $this
     */
    public function setImage(Image $image)
    {
        $this->image = $image;
        return $this;
    }

}