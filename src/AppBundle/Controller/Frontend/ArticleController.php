<?php

namespace AppBundle\Controller\Frontend;

use AppBundle\Form\CommentType;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;

class ArticleController extends Controller
{
    /**
     * @Route("/blog/{number}", name="blog")
     */
    public function blogAction(Request $request, $number)
    {
        $articles = $this->get('app.pagination')->getArticles($number);

        return $this->render('article/blog.html.twig', array(
            'base_dir' => realpath($this->container->getParameter('kernel.root_dir').'/..'),
            'class' => 'homepage',
            'title' => 'Blog',
            'articles' => $articles,
            'current' => $number
        ));
    }

    /**
     * @Route("/article/{slug}", name="article")
     */
    public function indexAction(Request $request, $slug)
    {
        $article = $this->getDoctrine()->getRepository('AppBundle:Article')->findOneBy(array('slug' => $slug));

        return $this->render('article/index.html.twig', array(
                'base_dir' => realpath($this->container->getParameter('kernel.root_dir').'/..'),
                'class' => 'article',
                'title' => 'Article',
                'article' => $article
            )
        );
    }


    /**
     * @Route("/search", name="search")
     */
    public function searchAction(Request $request)
    {
        $text = $request->get('text');

        $articles = $this->get('app.pagination')->searchArticles($text);
//        $articles = $this->getDoctrine()->getRepository('AppBundle:Article')->searchArticles($text);

        return $this->render('article/search.html.twig', array(
            'base_dir' => realpath($this->container->getParameter('kernel.root_dir').'/..'),
            'class' => 'search',
            'title' => 'Search',
            'articles' => $articles
        ));
    }
}
