<?php

namespace AppBundle\OAuthUserProvider;

use AppBundle\Entity\User;
use Doctrine\ORM\EntityManager;
use HWI\Bundle\OAuthBundle\OAuth\Response\UserResponseInterface;
use \HWI\Bundle\OAuthBundle\Security\Core\User\OAuthAwareUserProviderInterface;
use Symfony\Component\Security\Core\Exception\UsernameNotFoundException;

/**
 * Class OAuthCustomUserProvider
 * @package AppBundle\OAuthUserProvider
 */
class OAuthCustomUserProvider implements OAuthAwareUserProviderInterface
{
    /**
     * @var EntityManager $em
     */
    protected $em;

    /**
     * OAuthCustomUserProvider constructor.
     * @param EntityManager $em
     */
    public function __construct(EntityManager $em)
    {
        $this->em = $em;
    }

    /**
     * @param UserResponseInterface $response
     * @return User|null|object
     */
    public function loadUserByOAuthUserResponse(UserResponseInterface $response)
    {
        $type = $response->getResourceOwner()->getName();
        $user = $this->em->getRepository('AppBundle:User')->findOneBy(['username' => $response->getEmail()]);

        if (!$user){
            $user = new User();

            $user->setSalt('1111111');
            $user->setRoles('ROLE_USER');
            $user->setPassword(rand(100000, 1500000));
            $user->setEmail($response->getEmail());
            $user->setUsername($response->getEmail());

            if ($type == 'vkontakte') {
                $user->setVkontakteId($response->getResponse()['response'][0]['uid']);
                $user->setFirstName($response->getResponse()['response'][0]['first_name']);
                $user->setLastName($response->getResponse()['response'][0]['last_name']);
                $user->setAvatarPath($response->getResponse()['response'][0]['photo_medium']);
            }

            if ($type == 'facebook') {
                $user->setFacebookId($response->getResponse()['id']);
                $user->setFirstName($response->getResponse()['name']);
                $user->setAvatarPath($response->getResponse()['picture']['data']['url']);
            }

            if ($type == 'google') {
                $user->setGoogleId($response->getResponse()['id']);
                $user->setFirstName($response->getResponse()['given_name']);
                $user->setLastName($response->getResponse()['family_name']);
                $user->setAvatarPath($response->getResponse()['picture']);
            }

            $this->em->persist($user);
            $this->em->flush();
        }

        return $user;
    }

    /**
     * @param $username
     * @return User|null|object
     */
    public function loadUserByUsername($username)
    {
        $user = $this->em->getRepository('AppBundle:User')->findOneBy(['username' => $username]);

        if (!$user) {
            throw new UsernameNotFoundException(sprintf("User '%s' not found.", $username));
        }

        return $user;
    }
}