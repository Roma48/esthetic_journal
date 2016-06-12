<?php

namespace AppBundle\Controller\Backend;

use AppBundle\Entity\Article;
use AppBundle\Form\ArticleType;
use Doctrine\ORM\EntityManager;
use Mcfedr\JsonFormBundle\Controller\JsonController;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\ParamConverter;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\Request;

/**
 * @Route("/ajax")
 *
 * Class AjaxController
 * @package AppBundle\Controller\Backend
 */
class AjaxController extends JsonController
{
    /**
     * @Route("/article/{id}", name="ajax_new_article", options={"expose" = true})
     * @Method({"POST", "PUT", "GET", "DELETE"})
     *
     * @param $request
     * @param null $id
     *
     * @return JsonResponse
     */
    public function articleAction(Request $request, $id = null)
    {
        /** @var EntityManager $em */
        $em = $this->getDoctrine()->getManager();

        if ($request->getMethod() == "POST"){
            $article = new Article();
            $form = $this->createForm(new ArticleType($em), $article);
            $this->handleJsonForm($form, $request);

            $em->persist($article);
            $em->flush();

            return new JsonResponse([
                "status" => "ok",
                "aid" => $article->getId()
            ]);
        }

        return new JsonResponse(["status" => "fail"]);
    }

    /**
     * @Route("/article/{id}/image/add", name="ajax_article_add_image", options={"expose" = true})
     * @Method({"POST", "PUT", "GET", "DELETE"})
     * @ParamConverter("article", class="AppBundle:Article", options={"id" = "id"})
     * @param $request
     * @param Article $article
     *
     * @return JsonResponse
     */
    public function uploadImageToArticleAction(Request $request, Article $article)
    {
        $file = base64_decode($GLOBALS[ "HTTP_RAW_POST_DATA" ]);

        /** @var EntityManager $em */
        $em = $this->getDoctrine()->getManager();

        $article->setFile();

        if ($request->getMethod() == "POST"){
            $form = $this->createForm(new ArticleType($em), $article);
            $this->handleJsonForm($form, $request);

            $em->persist($article);
            $em->flush();

            return new JsonResponse([
                "status" => "ok",
                "aid" => $article->getId()
            ]);
        }

        return new JsonResponse(["status" => "fail"]);
    }
}