<?php

namespace AppBundle\Command;

use AppBundle\Entity\User;
use Symfony\Bundle\FrameworkBundle\Command\ContainerAwareCommand;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Output\OutputInterface;

/**
 * Class CreateAdminCommand
 * @package AppBundle\Command
 *
 *  app/console blog:admin:create <username> <password> <firstName> <lastName>
 *  app/console blog:admin:create test1 test Roma Paliy
 *
 */
class CreateAdminCommand extends ContainerAwareCommand
{
    protected function configure()
    {
        $this
            ->setName('blog:admin:create')
            ->setDescription('Create admin for site')
            ->addArgument('username', InputArgument::REQUIRED, 'Username')
            ->addArgument('password', InputArgument::REQUIRED, 'Password')
            ->addArgument('firstName', InputArgument::REQUIRED, 'First Name')
            ->addArgument('lastName', InputArgument::REQUIRED, 'Last Name')
        ;
    }

    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $username = $input->getArgument('username');
        $password = $input->getArgument('password');
        $firstName = $input->getArgument('firstName');
        $lastName = $input->getArgument('lastName');

        $em = $this->getContainer()->get('doctrine')->getManager();

        if ($username && $password && $firstName && $lastName) {
            $admin = new User();
            $admin->setRoles('ROLE_ADMIN');
            $admin->setSalt('commandtest11111111111111111111111111111');
            $admin->setFirstName($firstName);
            $admin->setLastName($lastName);
            $admin->setUsername($username);
            $admin->setCreatedAt(new \DateTime());
            $admin->setUpdatedAt(new \DateTime());

            $encoder = $this->getContainer()->get('security.password_encoder');
            $password = $encoder->encodePassword($admin, $password);
            $admin->setPassword($password);

            $em->persist($admin);
            $em->flush();

            $text = 'Admin created!';
        }

        $output->writeln($text);
    }
}