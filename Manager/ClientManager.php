<?php

namespace OAuth2\ServerBundle\Manager;

use Doctrine\ORM\EntityManager;
use OAuth2\ServerBundle\Exception\ScopeNotFoundException;

class ClientManager
{
    private $em;

    /**
     * @var ScopeManagerInterface
     */
    private $sm;

    public function __construct(EntityManager $entityManager, ScopeManagerInterface $scopeManager)
    {
        $this->em = $entityManager;
        $this->sm = $scopeManager;
    }

    /**
     * Creates a new client
     *
     * @param string $identifier
     *
     * @param array $redirect_uris
     *
     * @param array $grant_type
     *
     * @param array $scopes
     *
     * @param string $homePage
     *
     * @return Client
     */
    public function createClient($identifier, array $redirect_uris = array(), array $grant_types = array(), array $scopes = array(), $homePage)
    {
        $client = new \OAuth2\ServerBundle\Entity\Client();
        $client->setClientId($identifier);
        $client->setClientSecret($this->generateSecret());
        $client->setRedirectUri($redirect_uris);
        $client->setGrantTypes($grant_types);
        $client->setHomepage($homePage);

        // Verify scopes
        foreach ($scopes as $scope) {
            // Get Scope
            $scopeObject = $this->sm->findScopeByScope($scope);
            if (!$scopeObject) {
                throw new ScopeNotFoundException();
            }
        }

        $client->setScopes($scopes);

        // Store Client
        $this->em->persist($client);
        $this->em->flush();

        return $client;
    }

    /**
     * Creates a secret for a client
     *
     * @return A secret
     */
    public function generateSecret()
    {
        return base_convert(sha1(uniqid(mt_rand(), true)), 16, 36);
    }

    /**
     * return all clients
     *
     * @param array $criteria
     * @param array $orderBy
     * @param null $limit
     * @param null $offset
     * @return array|bool
     */
    public function find(array $criteria=[], array $orderBy = null, $limit = null, $offset = null)
    {
        $clients = $this->em->getRepository('OAuth2ServerBundle:Client')->findBy($criteria, $orderBy, $limit, $offset);

        return $clients;
    }
}
