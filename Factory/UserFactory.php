<?php

namespace OAuth2\ServerBundle\Factory;
use Doctrine\ORM\EntityManager;
use OAuth2\ServerBundle\User\UserManager;
use Symfony\Component\Security\Core\Encoder\EncoderFactoryInterface;
use Symfony\Component\DependencyInjection\Exception\ParameterNotFoundException;

/**
 * User factory
 */
class UserFactory
{
    private $encoderFactory;
    private $userRepository;

    public function __construct(EntityManager $entityManager, EncoderFactoryInterface $encoderFactory)
    {
        $this->userRepository = $entityManager->getRepository('OAuth2ServerBundle:User');
        $this->encoderFactory = $encoderFactory;
    }

    public function create(array $data)
    {
        if (empty($data)) {
            throw new ParameterNotFoundException("user data for create/update not found");
        }

        if (isset($data['id'])) {
            $user = $this->userRepository->findOneBy(['id' => $data['id']]);
        } else {
            $user = new \OAuth2\ServerBundle\Entity\User();
        }

        if (isset($data['username'])) {
            $user->setUsername($data['username']);
        }

        if (isset($data['password'])) {
            $salt = $this->generateSalt();
            $password = $this->encoderFactory->getEncoder($user)->encodePassword($data['password'], $salt);

            $user->setSalt($salt);
            $user->setPassword($password);
        }

        if (isset($data['roles'])) {
            $user->setRoles($data['roles']);
        }

        if (isset($data['scopes'])) {
            $user->setScopes($data['scopes']);
        }

        return $user;
    }

    /**
     * Creates a salt for password hashing
     *
     * @return string salt
     */
    private function generateSalt()
    {
        return base_convert(sha1(uniqid(mt_rand(), true)), 16, 36);
    }
} 