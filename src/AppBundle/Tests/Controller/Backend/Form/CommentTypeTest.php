<?php

namespace AppBundle\Tests\Controller\Backend\Form;

use AppBundle\Entity\Article;
use AppBundle\Entity\Comment;
use AppBundle\Form\CommentType;
use Symfony\Component\Form\Test\TypeTestCase;

class CommentTypeTest extends TypeTestCase
{
    public function testCommentType()
    {

//        $article = new Article();
//        $article->setTitle('test');
//        $article->setDescription('test');
//        $article->setContent('test');
//
//        $arrData = [
//            'message' => 'test message',
//            'article' => $article
//        ];
//
//        $object = new Comment();
//        $object->setMessage('test message');
//        $object->setArticle($article);
//
//        $type = new CommentType();
//        $form = $this->factory->create($type);
//
//        $form->submit($arrData);
//
//        $this->assertTrue($form->isSynchronized());
//
//        echo "<pre>";
//        var_dump($form->getData());
//        echo "</pre>";
//        exit;
//
//        $this->assertEquals($object, $form->getData());
//
//        $view = $form->createView();
//        $children = $view->children;
//
//        foreach (array_keys($arrData) as $key) {
//            $this->assertArrayHasKey($key, $children);
//        }
    }
}