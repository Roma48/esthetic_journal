<?php

namespace AppBundle\Twig;

use AppBundle\Entity\Article;
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
            new \Twig_SimpleFunction('categoryList', [$this, 'categoryList']),
            new \Twig_SimpleFunction('replaceBodySlider', [$this, 'replaceBodySlider'])
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
     * @param $article
     * @return mixed
     */
    public function replaceBodySlider(Article $article)
    {
        $body = $article->getContent();

        $slider = '<div class="gallery slider" data-autoplay="false" data-autoheight="true">';
        $slider .= '<figure>';

        foreach ($article->getSlides() as $slide){
            $slider .= '<div><img src="' . $slide->getPath() . '" alt="' . $slide->getTitle() . '"></div>';
        }

        $slider .= '</figure>';
        $slider .= '</div>';

        $body = str_replace('[slider]', $slider, $body);

        return $body;
    }

    /**
     * @return string
     */
    public function getName()
    {
        return 'app_extension';
    }
}