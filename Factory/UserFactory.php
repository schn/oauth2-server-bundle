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

    /**
     * Создать нового пользователя
     *
     * @param array $data
     * @return null|\OAuth2\ServerBundle\Entity\User|object
     */
    public function createNew(array $data)
    {
        if (empty($data)) {
            throw new ParameterNotFoundException("You must provide data for user create");
        }
        $user = new \OAuth2\ServerBundle\Entity\User();

        if (empty($data['username'])) {
            throw new ParameterNotFoundException("You must provide data.login for new user");
        }
        $user->setUsername($data['username']);

        if (empty($data['password'])) {
            throw new ParameterNotFoundException("You must provide data.password for new user");
        }
        $salt = $this->generateSalt();
        $password = $this->encoderFactory->getEncoder($user)->encodePassword($data['password'], $salt);

        $user->setSalt($salt);
        $user->setPassword($password);

        if (!empty($data['email'])) {
            $user->setEmail($data['email']);
        }

        if (!empty($data['roles'])) {
            $user->setRoles($data['roles']);
        }

        if (!empty($data['scopes'])) {
            $user->setScopes($data['scopes']);
        }

        if (!empty($data['firstname'])) {
            $user->setFirstName($data['firstname']);
        }

        if (!empty($data['lastname'])) {
            $user->setLastName($data['lastname']);
        }

        if (!empty($data['middlename'])) {
            $user->setMiddleName($data['middlename']);
        }

        if (!empty($data['birthdate'])) {
            $user->setBirthDate($data['birthdate']);
        }

        return $user;
    }

    /**
     * Накатить данные на существующего пользователя
     *
     * @param array $data
     */
    public function createExists(array $data)
    {
        if (empty($data)) {
            throw new ParameterNotFoundException("You must provide data for user update");
        }

        if (empty($data['id'])) {
            throw new ParameterNotFoundException("You must provide data.id to update user");
        }
        $user = $this->userRepository->findOneBy(['id' => $data['id']]);

        if (!empty($data['username'])) {
            $user->setUsername($data['username']);
        }

        if (!empty($data['password'])) {
            $salt = $this->generateSalt();
            $password = $this->encoderFactory->getEncoder($user)->encodePassword($data['password'], $salt);

            $user->setSalt($salt);
            $user->setPassword($password);
        }

        if (!empty($data['roles'])) {
            $user->setRoles($data['roles']);
        }

        if (!empty($data['scopes'])) {
            $user->setScopes($data['scopes']);
        }

        if (!empty($data['firstname'])) {
            $user->setFirstName($data['firstname']);
        }

        if (!empty($data['lastname'])) {
            $user->setLastName($data['lastname']);
        }

        if (!empty($data['middlename'])) {
            $user->setMiddleName($data['middlename']);
        }

        if (!empty($data['birthdate'])) {
            $user->setBirthDate($data['birthdate']);
        }

        return $user;
    }

    /**
     * Creates a salt for password hashing
     *
     * @return string salt
     */
    public function generateSalt()
    {
        return base_convert(sha1(uniqid(mt_rand(), true)), 16, 36);
    }

    public function getEncoderFactory()
    {
        return $this->encoderFactory;
    }
} 