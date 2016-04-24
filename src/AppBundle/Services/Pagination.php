<?php

namespace AppBundle\Services;

use Doctrine\ORM\Tools\Pagination\Paginator;
use Symfony\Bridge\Doctrine\RegistryInterface;

/**
 * Class Pagination
 * @package AppBundle\Services
 */
class Pagination
{
    /**
     * @var RegistryInterface
     */
    protected $doctrine;

    /**
     * Pagination constructor.
     * @param RegistryInterface $doctrine
     */
    public function __construct(RegistryInterface $doctrine)
    {
        $this->doctrine = $doctrine;
    }

    /**
     * @return \Doctrine\ORM\Tools\Pagination\Paginator
     */
    public function getArticles($page)
    {
        $query = $this->doctrine->getRepository('AppBundle:Article')->getPage($page);

        $paginator = new Paginator($query, $fetchJoinCollection = false);
        $paginator->setUseOutputWalkers(false);

        return $paginator;
    }

    /**
     * @param $text
     * @return Paginator
     */
    public function searchArticles($text)
    {
        $query = $this->doctrine->getRepository('AppBundle:Article')->searchArticles($text);

        $paginator = new Paginator($query, $fetchJoinCollection = false);
        $paginator->setUseOutputWalkers(false);

        return $paginator;
    }

    /**
     * @return \Doctrine\ORM\Tools\Pagination\Paginator
     */
    public function getCategory($slug, $page)
    {
        $query = $this->doctrine->getRepository('AppBundle:Article')->findByCategory($slug, $page);

        $paginator = new Paginator($query, $fetchJoinCollection = false);
        $paginator->setUseOutputWalkers(false);

        return $paginator;
    }

}