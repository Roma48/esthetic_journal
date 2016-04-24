<?php

namespace AppBundle\Twig;

use Symfony\Bridge\Doctrine\RegistryInterface;

/**
 * Class AppExtension
 * @package AppBundle\Twig
 */
class AppExtension extends \Twig_Extension
{
    /**
     * @var RegistryInterface
     */
    protected $doctrine;

    /**
     * AppExtension constructor.
     * @param RegistryInterface $doctrine
     */
    public function __construct(RegistryInterface $doctrine)
    {
        /**
         * @var RegistryInterface
         */
        $this->doctrine = $doctrine;
    }

    /**
     * @return array
     */
    public function getFunctions()
    {
        return [
            new \Twig_SimpleFunction('lastArticles', [$this, 'lastArticles']),
            new \Twig_SimpleFunction('categoryList', [$this, 'categoryList'])
        ];
    }

    /**
     * @param $limit
     * @return mixed
     */
    public function lastArticles($limit)
    {
        $popular = $this->doctrine->getManager()->getRepository('AppBundle:Article')->lastArticles($limit);

        return $popular;
    }

    /**
     * @return mixed
     */
    public function categoryList()
    {
        $categories = $this->doctrine->getManager()->getRepository('AppBundle:Category')->findAll();

        return $categories;
    }

    /**
     * @return string
     */
    public function getName()
    {
        return 'app_extension';
    }
}