<?php

namespace OAuth2\ServerBundle\User;
use Doctrine\ORM\EntityManager;
use OAuth2\ServerBundle\Exception\Oauth2Exception;
use OAuth2\ServerBundle\Factory\UserFactory;
use Symfony\Component\DependencyInjection\Exception\ParameterNotFoundException;

/**
 * Manager 
 */
class UserManager
{
    private $em;
    private $userFactory;
    private $repository;

    public function __construct(EntityManager $entityManager, UserFactory $userFactory)
    {
        $this->em = $entityManager;
        $this->userFactory = $userFactory;
        $this->repository = $this->em->getRepository('OAuth2ServerBundle:User');
    }

    /**
     * @param $username
     * @param $password
     * @param array $roles
     * @param array $scopes
     * @return bool
     */
    public function create(array $data)
    {
        $user = $this->userFactory->createNew($data);
        $this->em->persist($user);
        $this->em->flush();
        return $user;
    }

    /**
     * Update user
     */
    public function update(array $data)
    {
        $user = $this->userFactory->createExists($data);
        $this->em->persist($user);
        $this->em->flush();
        return $user;
    }

    /**
     * Delete by id
     */
    public function delete($id)
    {
        if (is_null($id)) {
            throw new ParameterNotFoundException("Please provide id to delete user");
        }

        $user = $this->get($id);
        $this->em->remove($user);
        $this->em->flush();

        return true;
    }

    /**
     * Find users by criteria
     */
    public function find(array $criteria = [])
    {
        return $this->repository->findBy($criteria);
    }

    /**
     * Get user
     */
    public function get($id)
    {
        if (is_null($id)) {
            throw new ParameterNotFoundException("Please provide id get user");
        }

        $user = $this->repository->findOneBy(['id' => $id]);

        if (is_null($user)) {
            throw Oauth2Exception::cantFindUserWithId($id);
        }

        return $user;
    }
} 