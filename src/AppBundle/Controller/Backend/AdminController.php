<?php

namespace AppBundle\Controller\Backend;

use AppBundle\Entity\Article;
use AppBundle\Entity\Category;
use AppBundle\Entity\Comment;
use AppBundle\Entity\Image;
use AppBundle\Entity\Page;
use AppBundle\Entity\User;
use AppBundle\Form\AdminCommentType;
use AppBundle\Form\ArticleType;
use AppBundle\Form\CategoryType;
use AppBundle\Form\CommentType;
use AppBundle\Form\ImageType;
use AppBundle\Form\PageType;
use AppBundle\Form\UserType;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Security;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;

class AdminController extends Controller
{
    /**
     * @Route("/admin", name="admin")
     * @Security("has_role('ROLE_ADMIN')")
     */
    public function indexAction(Request $request)
    {
        $articles = $this->getDoctrine()->getRepository('AppBundle:Article')->getPage();

        return $this->render('admin/index.html.twig', array(
            'base_dir' => realpath($this->container->getParameter('kernel.root_dir').'/..'),
            'title' => 'All Articles',
            'articles' => $articles,
            'pages' => (int) count($articles)/9,
            'current' => 1
        ));
    }

    /**
     * @Route("/admin/articles/{page}", name="admin_articles")
     */
    public function articlesPageAction(Request $request, $page)
    {
        $articles = $this->get('app.pagination')->getArticles($page);

        return $this->render('admin/all_articles.html.twig', array(
            'base_dir' => realpath($this->container->getParameter('kernel.root_dir').'/..'),
            'title' => 'All Articles',
            'articles' => $articles,
            'pages' => (int) count($articles)/9,
            'current' => $page
        ));
    }

    /**
     * @Route("/admin/article/new", name="new_article")
     */
    public function newArticleAction(Request $request)
    {
        $article = new Article();

        $form = $this->createForm(ArticleType::class, $article);

        $buttonName = 'Add Article';

        if ($request->getMethod() == 'POST') {
            $form->handleRequest($request);
            if ($form->isValid()) {
                $em = $this->getDoctrine()->getManager();
                $em->persist($article);
                $em->flush();
                return $this->redirectToRoute('admin_articles', ['page' => 1]);
            }
        }

        return $this->render('admin/new_article.html.twig', array(
            'base_dir' => realpath($this->container->getParameter('kernel.root_dir').'/..'),
            'title' => 'New Article',
            'form' => $form->createView(),
            'button' => $buttonName
        ));
    }

    /**
     * @Route("/admin/article/{id}/edit", name="edit_article")
     */
    public function editArticleAction(Request $request, $id)
    {
        $article = $this->getDoctrine()->getRepository('AppBundle:Article')->findOneBy(['id' => $id]);

        $form = $this->createForm(ArticleType::class, $article);

        $buttonName = 'Edit Article';

        if ($request->getMethod() == 'POST') {
            $form->handleRequest($request);
            if ($form->isValid()) {
                $em = $this->getDoctrine()->getManager();
                $em->persist($article);
                $em->flush();
                return $this->redirectToRoute('admin_articles', ['page' => 1]);
            }
        }

        return $this->render('admin/new_article.html.twig', array(
            'base_dir' => realpath($this->container->getParameter('kernel.root_dir').'/..'),
            'title' => 'Edit Article',
            'form' => $form->createView(),
            'button' => $buttonName
        ));
    }

    /**
     * @param Request $request
     * @return \Symfony\Component\HttpFoundation\RedirectResponse
     * @Route("/admin/image/new", name="new_image")
     */
    public function newImageAction(Request $request)
    {
        $image = new Image();

        $form = $this->createForm(ImageType::class, $image);

        $buttonName = 'Add Image';

        if ($request->getMethod() == 'POST') {
            $form->handleRequest($request);
            if ($form->isValid()) {
                $em = $this->getDoctrine()->getManager();
                $em->persist($image);
                $em->flush();
                return $this->redirectToRoute('admin_images');
            }
        }

        return $this->render('admin/new_article.html.twig', array(
            'base_dir' => realpath($this->container->getParameter('kernel.root_dir').'/..'),
            'title' => 'New Image',
            'form' => $form->createView(),
            'button' => $buttonName
        ));
    }

    /**
     * @param Request $request
     * @return \Symfony\Component\HttpFoundation\RedirectResponse
     * @Route("/admin/image/{id}/edit", name="edit_image")
     */
    public function editImageAction(Request $request, $id)
    {
        $image = $this->getDoctrine()->getRepository('AppBundle:Image')->findOneBy(['id' => $id]);

        $form = $this->createForm(ImageType::class, $image);

        $buttonName = 'Edit Image';

        if ($request->getMethod() == 'POST') {
            $form->handleRequest($request);
            if ($form->isValid()) {
                $em = $this->getDoctrine()->getManager();
                $em->persist($image);
                $em->flush();
                return $this->redirectToRoute('admin_images', ['page' => 1]);
            }
        }

        return $this->render('admin/new_article.html.twig', array(
            'base_dir' => realpath($this->container->getParameter('kernel.root_dir').'/..'),
            'title' => 'New Image',
            'form' => $form->createView(),
            'button' => $buttonName
        ));
    }

    /**
     * @Route("/admin/images/{page}", name="admin_images")
     */
    public function imagesPageAction(Request $request, $page)
    {
        $images = $this->getDoctrine()->getRepository('AppBundle:Image')->getPage($page);

        return $this->render('admin/all_images.html.twig', array(
            'base_dir' => realpath($this->container->getParameter('kernel.root_dir').'/..'),
            'title' => 'All Images',
            'images' => $images,
            'pages' => (int) count($images)/9,
            'current' => $page
        ));
    }

    /**
     * @Route("/admin/user/new", name="new_user")
     */
    public function newUserAction(Request $request)
    {
        $user = new User();

        $form = $this->createForm(UserType::class, $user);

        $buttonName = 'Add User';

        if ($request->getMethod() == 'POST') {
            $form->handleRequest($request);
            if ($form->isValid()) {
                $em = $this->getDoctrine()->getManager();
                $em->persist($user);
                $em->flush();
                return $this->redirectToRoute('admin_users', ['page' => 1]);
            }
        }

        return $this->render('admin/new_article.html.twig', array(
            'base_dir' => realpath($this->container->getParameter('kernel.root_dir').'/..'),
            'title' => 'New User',
            'form' => $form->createView(),
            'button' => $buttonName
        ));
    }

    /**
     * @Route("/admin/user/{id}/edit", name="edit_user")
     */
    public function editUserAction(Request $request, $id)
    {
        $user = $this->getDoctrine()->getRepository('AppBundle:User')->findOneBy(['id' => $id]);

        $form = $this->createForm(UserType::class, $user);

        $buttonName = 'Edit User';

        if ($request->getMethod() == 'POST') {
            $form->handleRequest($request);
            if ($form->isValid()) {
                $em = $this->getDoctrine()->getManager();
                $em->persist($user);
                $em->flush();
                return $this->redirectToRoute('admin_users', ['page' => 1]);
            }
        }

        return $this->render('admin/new_article.html.twig', array(
            'base_dir' => realpath($this->container->getParameter('kernel.root_dir').'/..'),
            'title' => 'Edit User',
            'form' => $form->createView(),
            'button' => $buttonName
        ));
    }

    /**
     * @Route("/admin/users/{page}", name="admin_users")
     */
    public function usersPageAction(Request $request, $page)
    {
        $users = $this->getDoctrine()->getRepository('AppBundle:User')->getPage($page);

        return $this->render('admin/all_users.html.twig', array(
            'base_dir' => realpath($this->container->getParameter('kernel.root_dir').'/..'),
            'title' => 'All Users',
            'users' => $users,
            'pages' => (int) count($users)/9,
            'current' => $page
        ));
    }

    /**
     * @Route("/admin/category/new", name="new_category")
     */
    public function newCategoryAction(Request $request)
    {
        $category = new Category();

        $form = $this->createForm(CategoryType::class, $category);

        $buttonName = 'Add Category';

        if ($request->getMethod() == 'POST') {
            $form->handleRequest($request);
            if ($form->isValid()) {
                $em = $this->getDoctrine()->getManager();
                $em->persist($category);
                $em->flush();
                return $this->redirectToRoute('admin_categories', ['page' => 1]);
            }
        }

        return $this->render('admin/new_article.html.twig', array(
            'base_dir' => realpath($this->container->getParameter('kernel.root_dir').'/..'),
            'title' => 'New Category',
            'form' => $form->createView(),
            'button' => $buttonName
        ));
    }

    /**
     * @Route("/admin/category/{id}/edit", name="edit_category")
     */
    public function editCategoryAction(Request $request, $id)
    {
        $category = $this->getDoctrine()->getRepository('AppBundle:Category')->findOneBy(['id' => $id]);

        $form = $this->createForm(CategoryType::class, $category);

        $buttonName = 'Edit Category';

        if ($request->getMethod() == 'POST') {
            $form->handleRequest($request);
            if ($form->isValid()) {
                $em = $this->getDoctrine()->getManager();
                $em->persist($category);
                $em->flush();
                return $this->redirectToRoute('admin_categories', ['page' => 1]);
            }
        }

        return $this->render('admin/new_article.html.twig', array(
            'base_dir' => realpath($this->container->getParameter('kernel.root_dir').'/..'),
            'title' => 'New Category',
            'form' => $form->createView(),
            'button' => $buttonName
        ));
    }

    /**
     * @Route("/admin/categories/{page}", name="admin_categories")
     */
    public function categoriesPageAction(Request $request, $page)
    {
        $categories = $this->getDoctrine()->getRepository('AppBundle:Category')->findAll();

        return $this->render('admin/all_categories.html.twig', array(
            'base_dir' => realpath($this->container->getParameter('kernel.root_dir').'/..'),
            'title' => 'All Categories',
            'categories' => $categories,
            'pages' => (int) count($categories)/9,
            'current' => $page
        ));
    }

    /**
     * @Route("/admin/comment/new", name="new_comment")
     */
    public function newCommentAction(Request $request)
    {
        $comment = new Comment();

        $form = $this->createForm(AdminCommentType::class, $comment);

        $buttonName = 'Add Comment';

        if ($request->getMethod() == 'POST') {
            $form->handleRequest($request);
            if ($form->isValid()) {
                $em = $this->getDoctrine()->getManager();
                $em->persist($comment);
                $em->flush();
                return $this->redirectToRoute('admin_comments', ['page' => 1]);
            }
        }

        return $this->render('admin/new_article.html.twig', array(
            'base_dir' => realpath($this->container->getParameter('kernel.root_dir').'/..'),
            'title' => 'New Comment',
            'form' => $form->createView(),
            'button' => $buttonName
        ));
    }

    /**
     * @Route("/admin/comment/{id}/edit", name="edit_comment")
     */
    public function editCommentAction(Request $request, $id)
    {
        $comment = $this->getDoctrine()->getRepository('AppBundle:Comment')->findOneBy(['id' => $id]);

        $form = $this->createForm(AdminCommentType::class, $comment);

        $buttonName = 'Edit Comment';

        if ($request->getMethod() == 'POST') {
            $form->handleRequest($request);
            if ($form->isValid()) {
                $em = $this->getDoctrine()->getManager();
                $em->persist($comment);
                $em->flush();
                return $this->redirectToRoute('admin_comments', ['page' => 1]);
            }
        }

        return $this->render('admin/new_article.html.twig', array(
            'base_dir' => realpath($this->container->getParameter('kernel.root_dir').'/..'),
            'title' => 'Edit Comment',
            'form' => $form->createView(),
            'button' => $buttonName
        ));
    }

    /**
     * @Route("/admin/comments/{page}", name="admin_comments")
     */
    public function commentsPageAction(Request $request, $page)
    {
        $comments = $this->getDoctrine()->getRepository('AppBundle:Comment')->getPage($page);

        return $this->render('admin/all_comments.html.twig', array(
            'base_dir' => realpath($this->container->getParameter('kernel.root_dir').'/..'),
            'title' => 'All Comments',
            'comments' => $comments,
            'pages' => (int) count($comments)/9,
            'current' => $page
        ));
    }

    /**
     * @Route("/admin/page/new", name="new_page")
     */
    public function newPageAction(Request $request)
    {
        $category = new Page();

        $form = $this->createForm(PageType::class, $category);

        $buttonName = 'Add Page';

        if ($request->getMethod() == 'POST') {
            $form->handleRequest($request);
            if ($form->isValid()) {
                $em = $this->getDoctrine()->getManager();
                $em->persist($category);
                $em->flush();
                return $this->redirectToRoute('admin_pages', ['page' => 1]);
            }
        }

        return $this->render('admin/new_article.html.twig', array(
            'base_dir' => realpath($this->container->getParameter('kernel.root_dir').'/..'),
            'title' => 'New Page',
            'form' => $form->createView(),
            'button' => $buttonName
        ));
    }

    /**
     * @Route("/admin/page/{id}/edit", name="edit_page")
     */
    public function editPageAction(Request $request, $id)
    {
        $category = $this->getDoctrine()->getRepository('AppBundle:Page')->findOneBy(['id' => $id]);

        $form = $this->createForm(PageType::class, $category);

        $buttonName = 'Edit Page';

        if ($request->getMethod() == 'POST') {
            $form->handleRequest($request);
            if ($form->isValid()) {
                $em = $this->getDoctrine()->getManager();
                $em->persist($category);
                $em->flush();
                return $this->redirectToRoute('admin_pages', ['page' => 1]);
            }
        }

        return $this->render('admin/new_article.html.twig', array(
            'base_dir' => realpath($this->container->getParameter('kernel.root_dir').'/..'),
            'title' => 'Edit Page',
            'form' => $form->createView(),
            'button' => $buttonName
        ));
    }

    /**
     * @Route("/admin/pages/{page}", name="admin_pages")
     */
    public function pagesAction(Request $request, $page)
    {
        $pages = $this->getDoctrine()->getRepository('AppBundle:Page')->getPage($page);

        return $this->render('admin/all_pages.html.twig', array(
            'base_dir' => realpath($this->container->getParameter('kernel.root_dir').'/..'),
            'title' => 'All Pages',
            'pages' => $pages,
            'pagination' => (int) count($pages)/9,
            'current' => $page
        ));
    }
}
