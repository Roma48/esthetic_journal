<?php

namespace AppBundle\Twig;

use AppBundle\Entity\Article;
use AppBundle\Entity\MenuItem;
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
            new \Twig_SimpleFunction('renderMenu', [$this, 'renderMenu']),
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
     * @return array
     */
    public function sortingMenu()
    {
        $menuItems = $this->doctrine->getManager()->getRepository('AppBundle:MenuItem')->findAll();
        $sortedMenu = [];
        foreach ($menuItems as $menuItem){
            if (!$menuItem->getParent()){
                $sortedMenu[] = [
                    'url' => $menuItem->getUrl(),
                    'title' => $menuItem->getTitle(),
                    'childs' => $this->getChilds($menuItem)
                ];
            }
        }

        return $sortedMenu;
    }

    /**
     * @param MenuItem $menuItem
     * @return array
     */
    public function getChilds(MenuItem $menuItem)
    {
        $childs = $menuItem->getChilds();
        $arr = [];
        if ($childs){
            foreach ($childs as $child){
                $arr[] = [
                    'url' => $menuItem->getUrl(),
                    'title' => $menuItem->getTitle()
                ];
            }
        }

        return $arr;
    }

    public function renderMenu(){
        $sortedMenu = $this->sortingMenu();
        $output = '<ul class="reset" role="navigation">';
        foreach ($sortedMenu as $menuItem){
            $output .= '<li class="menu-item">';
            $output .= '<a href="' . $menuItem['url'] . '">' . $menuItem['title'] . '</a>';
            if ($menuItem['childs']){
                $output .= '<ul class="sub-menu">';
                foreach ($menuItem['childs'] as $child){
                    $output .= '<li>';
                    $output .= '<a href="' . $child['url'] . '">' . $child['title'] . '</a>';
                    $output .= '</li>';
                }
                $output .= '</ul>';
            }
            $output .= '</li>';
        }
        $output .= '</ul>';

        return $output;
    }

    /**
     * @return string
     */
    public function getName()
    {
        return 'app_extension';
    }
}