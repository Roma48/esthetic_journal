<?php

namespace AppBundle\Controller\Frontend;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;

class DefaultController extends Controller
{
    /**
     * @Route("/", name="homepage")
     */
    public function indexAction(Request $request)
    {
        $slides = $this->getDoctrine()->getRepository('AppBundle:Article')->getSlides();

        $articles = $this->get('app.pagination')->getArticles(1);

        return $this->render('default/index.html.twig', array(
            'base_dir' => realpath($this->container->getParameter('kernel.root_dir').'/..'),
            'class' => 'homepage',
            'title' => 'Home page',
            'articles' => $articles,
            'slides' => $slides,
            'current' => 1
        ));
    }

    /**
     * @Route("/page/{number}", name="pagination")
     */
    public function pageAction(Request $request, $number)
    {
        $slides = $this->getDoctrine()->getRepository('AppBundle:Article')->getSlides();

        $articles = $this->get('app.pagination')->getArticles($number);

        return $this->render('default/index.html.twig', array(
            'base_dir' => realpath($this->container->getParameter('kernel.root_dir').'/..'),
            'class' => 'homepage',
            'title' => 'Home page',
            'articles' => $articles,
            'slides' => $slides,
            'current' => $number
        ));
    }
}
