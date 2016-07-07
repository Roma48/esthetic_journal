<?php

namespace AppBundle\Controller\Frontend;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;

class CategoryController extends Controller
{
    /**
     * @Route("/category/{slug}/{page}", name="category")
     */
    public function categoryPageAction(Request $request, $slug, $page = 1)
    {
        $articles = $this->get('app.pagination')->getCategory($slug, $page);

        $category = $this->getDoctrine()->getRepository('AppBundle:Category')->findOneBy(["slug" => $slug]);

        return $this->render('category/category.html.twig', array(
            'base_dir' => realpath($this->container->getParameter('kernel.root_dir').'/..'),
            'class' => 'homepage',
            'category' => $category,
            'articles' => $articles,
            'current' => 1
        ));
    }
}
