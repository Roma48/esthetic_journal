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
        $this->doctrine = $doctrine;
    }

    /**
     * @return array
     */
    public function getFunctions()
    {
        return [
            new \Twig_SimpleFunction('popularArticles', [$this, 'popularArticles'])
        ];
    }

    /**
     * @return \Doctrine\ORM\QueryBuilder
     */
    public function popularArticles()
    {
        $popular = $this->doctrine->getManager()->getRepository('AppBundle:Article')->popularArticles();

        return $popular;
    }

    /**
     * @return string
     */
    public function getName()
    {
        return 'app_extension';
    }
}