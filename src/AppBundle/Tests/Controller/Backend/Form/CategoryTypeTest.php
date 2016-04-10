<?php

namespace AppBundle\Tests\Controller\Backend\Form;

use AppBundle\Entity\Category;
use AppBundle\Form\CategoryType;
use Symfony\Component\Form\Test\TypeTestCase;

class CategoryTypeTest extends TypeTestCase
{
    public function testCategoryType()
    {
//        $arrData = [
//            'name' => 'Cars',
//            'class' => 'car'
//        ];
//
//        $object = new Category();
//        $object->setName('Cars');
//        $object->setClass('car');
//
//        $type = new CategoryType();
//        $form = $this->factory->create($type);
//
//        $form->submit($arrData);
//
//        $this->assertTrue($form->isSynchronized());
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