<?php

namespace AppBundle\Twig;

use AppBundle\Entity\Article;
use AppBundle\Entity\Category;
use AppBundle\Entity\MenuItem;
use Symfony\Bridge\Doctrine\RegistryInterface;
use Symfony\Component\Routing\Generator\UrlGeneratorInterface;

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
     * @var UrlGeneratorInterface
     */
    private $generator;

    /**
     * AppExtension constructor.
     * @param RegistryInterface $doctrine
     */
    public function __construct(RegistryInterface $doctrine, UrlGeneratorInterface $generator)
    {
        /**
         * @var RegistryInterface
         */
        $this->doctrine = $doctrine;

        /**
         * @var UrlGeneratorInterface
         */
        $this->generator = $generator;
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
            new \Twig_SimpleFunction('renderAdminMenu', [$this, 'renderAdminMenu']),
            new \Twig_SimpleFunction('replaceBodySlider', [$this, 'replaceBodySlider']),
            new \Twig_SimpleFunction('renderCategories', [$this, 'renderCategories'])
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
        $menuItems = $this->doctrine->getManager()->getRepository('AppBundle:MenuItem')->findBy([], ['weight' => 'ASC']);
        $sortedMenu = [];
        foreach ($menuItems as $menuItem){
            if (!$menuItem->getParent()){
                $sortedMenu[] = [
                    'id' => $menuItem->getId(),
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
        $childs = $this->doctrine->getManager()->getRepository('AppBundle:MenuItem')->findBy(
            ['parent' => $menuItem->getId()],
            ['weight' => 'ASC']
        );

        $arr = [];
        if ($childs){
            foreach ($childs as $child){
                $arr[] = [
                    'id' => $child->getId(),
                    'url' => $child->getUrl(),
                    'title' => $child->getTitle(),
                    'childs' => $this->getChilds($child)
                ];
            }
        }

        return $arr;
    }

    /**
     * @return string
     */
    public function renderAdminMenu(){
        $sortedMenu = $this->sortingMenu();
        $output = '<table class="table table-hover">';
        foreach ($sortedMenu as $menuItem){
            $output .= '<tr class="menu-item">';
            $output .= '<td width="60%">';
            $output .= $menuItem['title'];
            $output .= '</td>';
            $output .= '<td>';
            $output .= '<a href="' . $this->generator->generate('admin_menu_edit', array('id' => $menuItem['id'])) . '" class="btn btn-default">Редагувати</a> ';
            $output .= ' <a href="' . $this->generator->generate('admin_menu_delete', array('id' => $menuItem['id'])) . '" class="btn btn-danger">Видалити</a>';
            $output .= '</td>';
            $output .= '</tr>';

            if ($menuItem['childs']){
                $output .= $this->renderAdminChilds($menuItem['childs']);
            }
            $output .= '</tr>';
        }
        $output .= '</table>';

        return $output;
    }

    public function renderAdminChilds($childs)
    {
        $output = '';
        foreach ($childs as $child){
            $output .= '<tr class="child-menu-item">';
            $output .= '<td width="60%">';
            $output .= $child['title'];
            $output .= '</td>';
            $output .= '<td>';
            $output .= '<a href="' . $this->generator->generate('admin_menu_edit', array('id' => $child['id'])) . '" class="btn btn-default">Редагувати</a> ';
            $output .= ' <a href="' . $this->generator->generate('admin_menu_delete', array('id' => $child['id'])) . '" class="btn btn-danger">Видалити</a>';
            $output .= '</td>';
            $output .= '</tr>';

            if ($child['childs']) {
                $output .= $this->renderAdminChilds($child['childs']);
            }
        }

        return $output;
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

    public function renderCategories()
    {
        $categoryItems = $this->sortingCategories();
        $output = '<ul class="categories">';
        foreach ($categoryItems as $categoryItem){
            $output .= '<li class="category-item">';
            $output .= '<a href="' . $this->generator->generate('category', array('slug' => $categoryItem['slug'])) . '">' . $categoryItem['title'] . '</a>';
            if ($categoryItem['childs']){
                $output .= '<ul class="sub-category">';
                foreach ($categoryItem['childs'] as $child){
                    $output .= '<li>';
                    $output .= '-- <a href="' . $this->generator->generate('category', array('slug' => $child['slug'])) . '">' . $child['title'] . '</a>';
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
     * @return array
     */
    public function sortingCategories()
    {
        $categoryItems = $this->doctrine->getManager()->getRepository('AppBundle:Category')->findAll();
        $sortedCategories = [];
        foreach ($categoryItems as $categoryItem){
            if (!$categoryItem->getParent()){
                $sortedCategories[] = [
                    'id' => $categoryItem->getId(),
                    'slug' => $categoryItem->getSlug(),
                    'title' => $categoryItem->getName(),
                    'childs' => $this->getCategoryChilds($categoryItem)
                ];
            }
        }

        return $sortedCategories;
    }

    /**
     * @param Category $categoryItem
     * @return array
     */
    public function getCategoryChilds(Category $categoryItem)
    {
        $childs = $this->doctrine->getManager()->getRepository('AppBundle:Category')->findBy(
            ['parent' => $categoryItem->getId()]
        );

        $arr = [];
        if ($childs){
            foreach ($childs as $child){
                $arr[] = [
                    'id' => $child->getId(),
                    'slug' => $child->getSlug(),
                    'title' => $child->getName(),
                    'childs' => $this->getCategoryChilds($child)
                ];
            }
        }

        return $arr;
    }

    /**
     * @return string
     */
    public function getName()
    {
        return 'app_extension';
    }
}