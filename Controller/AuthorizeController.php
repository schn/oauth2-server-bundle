<?php

namespace OAuth2\ServerBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Symfony\Component\HttpFoundation\Response;

class AuthorizeController extends Controller
{
    /**
     * @Route("/authorize", name="_authorize_validate")
     * @Method({"GET"})
     */
    public function validateAuthorizeAction()
    {
        $server = $this->get('oauth2.server');


        if (!$server->validateAuthorizeRequest($this->get('oauth2.request'), $this->get('oauth2.response'))) {
            return $server->getResponse();
        }

        return $server->handleAuthorizeRequest($this->get('oauth2.request'), $this->get('oauth2.response'), true, $this->getUser()->getId());
    }
}
