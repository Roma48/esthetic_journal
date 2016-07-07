<?php

namespace AppBundle\Controller\Backend;

use AppBundle\Entity\Article;
use AppBundle\Entity\Category;
use AppBundle\Entity\Comment;
use AppBundle\Entity\Image;
use AppBundle\Entity\MenuItem;
use AppBundle\Entity\Page;
use AppBundle\Entity\User;
use AppBundle\Form\AdminCommentType;
use AppBundle\Form\ArticleType;
use AppBundle\Form\CategoryType;
use AppBundle\Form\CommentType;
use AppBundle\Form\ImageType;
use AppBundle\Form\MenuItemType;
use AppBundle\Form\PageType;
use AppBundle\Form\UserType;
use Doctrine\ORM\EntityManager;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\ParamConverter;
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
            'title' => 'Всі новини',
            'articles' => $articles,
            'pages' => (int) count($articles)/9,
            'current' => 1
        ));
    }

    /**
     * @Route("/admin/articles/{page}", name="admin_articles")
     */
    public function articlesPageAction(Request $request, $page = 1)
    {
        $articles = $this->get('app.pagination')->getArticles($page);

        return $this->render('admin/all_articles.html.twig', array(
            'base_dir' => realpath($this->container->getParameter('kernel.root_dir').'/..'),
            'title' => 'Всі новини',
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
        $em = $this->getDoctrine()->getManager();

        $article = new Article();

        $form = $this->createForm(new ArticleType($em), $article);

        $buttonName = 'Додати новину';

        if ($request->getMethod() == 'POST') {
            $form->handleRequest($request);
            if ($form->isValid()) {
                $article->setUsers($this->getUser());
                foreach ($article->getSlides() as $slide){
                    $article->addSlide($slide);
                }
                $em->persist($article);
                $em->flush();
                return $this->redirectToRoute('admin_articles', ['page' => 1]);
            }
        }

        return $this->render('admin/new_article.html.twig', array(
            'base_dir' => realpath($this->container->getParameter('kernel.root_dir').'/..'),
            'title' => 'Додати новину',
            'form' => $form->createView(),
            'button' => $buttonName
        ));
    }

    /**
     * @Route("/admin/article/{id}/edit", name="edit_article")
     * @ParamConverter("article", class="AppBundle:Article", options={"id" = "id"})
     */
    public function editArticleAction(Request $request, Article $article)
    {
        $em = $this->getDoctrine()->getManager();

        $form = $this->createForm(new ArticleType($em), $article);

        $buttonName = 'Зберегти';

        if ($request->getMethod() == 'POST') {
            $form->handleRequest($request);
            if ($form->isValid()) {
                foreach ($article->getSlides() as $slide){
                    $article->addSlide($slide);
                }
                $em->persist($article);
                $em->flush();
                return $this->redirectToRoute('admin_articles', ['page' => 1]);
            }
        }

        return $this->render('admin/new_article.html.twig', array(
            'base_dir' => realpath($this->container->getParameter('kernel.root_dir').'/..'),
            'title' => 'Редагувати новину',
            'form' => $form->createView(),
            'button' => $buttonName
        ));
    }

    /**
     * @Route("/admin/article/{id}/delete", name="delete_article")
     * @ParamConverter("article", class="AppBundle:Article", options={"id" = "id"})
     */
    public function deleteArticleAction(Request $request, Article $article)
    {
        /** @var EntityManager $em */
        $em = $this->getDoctrine()->getManager();

        $em->remove($article);
        $em->flush();

        return $this->redirectToRoute("admin_articles");
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

        $buttonName = 'Додати картинку';

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
            'title' => 'Нова картинка',
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

        $buttonName = 'Редагувати картинку';

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
            'title' => 'Нова картинка',
            'form' => $form->createView(),
            'button' => $buttonName
        ));
    }

    /**
     * @Route("/admin/images/{page}", name="admin_images")
     */
    public function imagesPageAction(Request $request, $page = 1)
    {
        $images = $this->getDoctrine()->getRepository('AppBundle:Image')->getPage($page);

        return $this->render('admin/all_images.html.twig', array(
            'base_dir' => realpath($this->container->getParameter('kernel.root_dir').'/..'),
            'title' => 'Всі картинки',
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

        $buttonName = 'Додати користувача';

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
            'title' => 'Новий користувач',
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

        $buttonName = 'Зберегти';

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
            'title' => 'Редагувати користувача',
            'form' => $form->createView(),
            'button' => $buttonName
        ));
    }

    /**
     * @Route("/admin/users/{page}", name="admin_users")
     */
    public function usersPageAction(Request $request, $page = 1)
    {
        $users = $this->getDoctrine()->getRepository('AppBundle:User')->getPage($page);

        return $this->render('admin/all_users.html.twig', array(
            'base_dir' => realpath($this->container->getParameter('kernel.root_dir').'/..'),
            'title' => 'Всі користувачі',
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

        $buttonName = 'Додати категорію';

        if ($request->getMethod() == 'POST') {
            $form->handleRequest($request);
            if ($form->isValid()) {
                $em = $this->getDoctrine()->getManager();
                $em->persist($category);
                $em->flush();
                return $this->redirectToRoute('admin_categories', ['page' => 1]);
            }
        }

        return $this->render('admin/new_entity.html.twig', array(
            'base_dir' => realpath($this->container->getParameter('kernel.root_dir').'/..'),
            'title' => 'Нова категорія',
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

        $buttonName = 'Зберегти';

        if ($request->getMethod() == 'POST') {
            $form->handleRequest($request);
            if ($form->isValid()) {
                $em = $this->getDoctrine()->getManager();
                $em->persist($category);
                $em->flush();
                return $this->redirectToRoute('admin_categories', ['page' => 1]);
            }
        }

        return $this->render('admin/new_entity.html.twig', array(
            'base_dir' => realpath($this->container->getParameter('kernel.root_dir').'/..'),
            'title' => 'Редагувати категорію',
            'form' => $form->createView(),
            'button' => $buttonName
        ));
    }

    /**
     * @Route("/admin/category/{id}/delete", name="delete_category")
     * @ParamConverter("category", class="AppBundle:Category", options={"id" = "id"})
     */
    public function deleteCategoryAction(Request $request, Category $category)
    {
        /** @var EntityManager $em */
        $em = $this->getDoctrine()->getManager();

        $em->remove($category);
        $em->flush();

        return $this->redirectToRoute("admin_categories");
    }

    /**
     * @Route("/admin/categories/{page}", name="admin_categories")
     */
    public function categoriesPageAction(Request $request, $page = 1)
    {
        $categories = $this->getDoctrine()->getRepository('AppBundle:Category')->findAll();

        return $this->render('admin/all_categories.html.twig', array(
            'base_dir' => realpath($this->container->getParameter('kernel.root_dir').'/..'),
            'title' => 'Всі категорії',
            'categories' => $categories,
            'pages' => (int) count($categories)/9,
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

        $buttonName = 'Додати сторінку';

        if ($request->getMethod() == 'POST') {
            $form->handleRequest($request);
            if ($form->isValid()) {
                $em = $this->getDoctrine()->getManager();
                $em->persist($category);
                $em->flush();
                return $this->redirectToRoute('admin_pages', ['page' => 1]);
            }
        }

        return $this->render('admin/new_entity.html.twig', array(
            'base_dir' => realpath($this->container->getParameter('kernel.root_dir').'/..'),
            'title' => 'Нова сторінка',
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

        $buttonName = 'Зберегти';

        if ($request->getMethod() == 'POST') {
            $form->handleRequest($request);
            if ($form->isValid()) {
                $em = $this->getDoctrine()->getManager();
                $em->persist($category);
                $em->flush();
                return $this->redirectToRoute('admin_pages', ['page' => 1]);
            }
        }

        return $this->render('admin/new_entity.html.twig', array(
            'base_dir' => realpath($this->container->getParameter('kernel.root_dir').'/..'),
            'title' => 'Редагувати сторінку',
            'form' => $form->createView(),
            'button' => $buttonName
        ));
    }

    /**
     * @Route("/admin/page/{id}/delete", name="delete_page")
     * @ParamConverter("page", class="AppBundle:Page", options={"id" = "id"})
     */
    public function deletePageAction(Request $request, Page $page)
    {
        /** @var EntityManager $em */
        $em = $this->getDoctrine()->getManager();

        $em->remove($page);
        $em->flush();

        return $this->redirectToRoute("admin_pages");
    }

    /**
     * @Route("/admin/pages/{page}", name="admin_pages")
     */
    public function pagesAction(Request $request, $page = 1)
    {
        $pages = $this->getDoctrine()->getRepository('AppBundle:Page')->getPage($page);

        return $this->render('admin/all_pages.html.twig', array(
            'base_dir' => realpath($this->container->getParameter('kernel.root_dir').'/..'),
            'title' => 'Всі стоірнки',
            'pages' => $pages,
            'pagination' => (int) count($pages)/9,
            'current' => $page
        ));
    }

    /**
     * @Route("/admin/menu", name="admin_menu")
     */
    public function newMenuAction(Request $request)
    {
        $menuItem = new MenuItem();

        $form = $this->createForm(new MenuItemType(), $menuItem);

        if ($request->getMethod() == 'POST') {
            $form->handleRequest($request);
            if ($form->isValid()) {
                $em = $this->getDoctrine()->getManager();
                if ($menuItem->getParent()){
                    $menuItem->setParent($menuItem->getParent()->getId());
                    $em->persist($menuItem);
                    $em->flush();
                    $parent = $this->getDoctrine()->getRepository('AppBundle:MenuItem')->findOneBy(['id' => $menuItem->getParent()]);
                    $parent->setChilds($menuItem);
                    $em->persist($parent);
                }
                $em->persist($menuItem);
                $em->flush();
                return $this->redirectToRoute('admin_menu');
            }
        }

        return $this->render('admin/menu.html.twig', array(
            'base_dir' => realpath($this->container->getParameter('kernel.root_dir').'/..'),
            'title' => 'Меню',
            'form' => $form->createView()
        ));
    }

    /**
     * @Route("/admin/menu/{id}/edit", name="admin_menu_edit")
     * @ParamConverter("menuItem", class="AppBundle:MenuItem", options={"id" = "id"})
     */
    public function editMenuAction(Request $request, $menuItem)
    {
        $form = $this->createForm(new MenuItemType(), $menuItem);

        if ($request->getMethod() == 'POST') {
            $form->handleRequest($request);
            if ($form->isValid()) {
                $em = $this->getDoctrine()->getManager();
                if ($menuItem->getParent()){
                    $menuItem->setParent($menuItem->getParent());
                    echo "<pre>";
                    var_dump($menuItem);
                    echo "</pre>";
                    exit;
                    $parent = $this->getDoctrine()->getRepository('AppBundle:MenuItem')->findOneBy(['id' => $menuItem->getParent()]);
                    $parent->setChilds($menuItem);
                    $em->persist($parent);
                }
                $em->persist($menuItem);
                $em->flush();
                return $this->redirectToRoute('admin_menu');
            }
        }

        return $this->render('admin/new_menu_item.html.twig', array(
            'base_dir' => realpath($this->container->getParameter('kernel.root_dir').'/..'),
            'title' => 'Редагувати пункт меню',
            'form' => $form->createView()
        ));
    }

    /**
     * @Route("/admin/menu/{id}/delete", name="admin_menu_delete")
     * @ParamConverter("menuItem", class="AppBundle:MenuItem", options={"id" = "id"})
     */
    public function deleteMenuItemAction(Request $request, MenuItem $menuItem)
    {
        /** @var EntityManager $em */
        $em = $this->getDoctrine()->getManager();

        $em->remove($menuItem);
        $em->flush();

        return $this->redirectToRoute("admin_menu");
    }
}
