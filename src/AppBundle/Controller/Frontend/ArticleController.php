<?php

namespace AppBundle\Controller\Frontend;

use AppBundle\Form\CommentType;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use AppBundle\Entity\Comment;

class ArticleController extends Controller
{
    /**
     * @Route("/blog/page/{number}", name="blog")
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

        $comment = new Comment();

        $form = $this->createForm(CommentType::class, $comment);

        $comments = $this->getDoctrine()->getRepository('AppBundle:Comment')->findBy(["article" => $article]);

        if ($request->getMethod() == 'POST') {
            $form->handleRequest($request);
            if ($form->isValid()) {
                $em = $this->getDoctrine()->getManager();

                $comment->setUser($this->getUser());
                $comment->setArticle($article);

                $em->persist($comment);
                $em->flush();
                return $this->redirectToRoute('article', ['slug' => $slug]);
            }
        }

        return $this->render('article/index.html.twig', array(
                'base_dir' => realpath($this->container->getParameter('kernel.root_dir').'/..'),
                'class' => 'article',
                'title' => 'Article',
                'article' => $article,
                'form' => $form->createView(),
                'comments' => $comments
            )
        );
    }
}
