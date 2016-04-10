<?php

namespace AppBundle\Controller\Frontend;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;

class UserController extends Controller
{

    /**
     * @Route("/user/{slug}", name="user")
     */
    public function indexAction(Request $request, $slug)
    {
        $user = $this->getDoctrine()->getRepository('AppBundle:User')->findOneBy(["slug" => $slug]);

        return $this->render('user/index.html.twig', array(
            'base_dir' => realpath($this->container->getParameter('kernel.root_dir').'/..'),
            'class' => 'homepage',
            'title' => $user->getFirstName() . $user->getLastName(),
            'user' => $user
        ));
    }
}
