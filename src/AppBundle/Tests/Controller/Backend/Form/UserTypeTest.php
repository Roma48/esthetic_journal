<?php

namespace AppBundle\Tests\Controller\Backend\Form;

use AppBundle\Entity\User;
use AppBundle\Form\UserType;
use Symfony\Component\Form\Test\TypeTestCase;

class UserTypeTest extends TypeTestCase
{
    public function testUserType()
    {
        $user = [
            'firstName' => 'Roma',
            'lastName' => 'Paliy'
        ];

        $object = new User();
        $object->setFirstName('Roma');
        $object->setLastName('Paliy');

        $type = new UserType();
        $form = $this->factory->create($type);

        $form->submit($user);

        $this->assertTrue($form->isSynchronized());

        $this->assertEquals($object, $form->getData());

        $view = $form->createView();
        $children = $view->children;

        foreach (array_keys($user) as $key) {
            $this->assertArrayHasKey($key, $children);
        }
    }
}