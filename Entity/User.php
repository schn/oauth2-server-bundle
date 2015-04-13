<?php

namespace OAuth2\ServerBundle\Entity;

use OAuth2\ServerBundle\User\OAuth2UserInterface;

/**
 * User
 */
class User implements OAuth2UserInterface
{

    /**
     * @var
     */
    private $id;

    /**
     * @var string
     */
    private $username;

    /**
     * @var string
     */
    private $password;

    /**
     * @var string
     */
    private $salt;

    /**
     * @var array
     */
    private $roles = [];

    /**
     * @var array
     */
    private $scopes = [];


    /**
     * @return mixed
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * @param mixed $id
     */
    public function setId($id)
    {
        $this->id = $id;
    }

    /**
     * Set username
     *
     * @param  string $username
     * @return User
     */
    public function setUsername($username)
    {
        $this->username = $username;

        return $this;
    }

    /**
     * Get username
     *
     * @return string
     */
    public function getUsername()
    {
        return $this->username;
    }

    /**
     * Set password
     *
     * @param  string $password
     * @return User
     */
    public function setPassword($password)
    {
        $this->password = $password;

        return $this;
    }

    /**
     * Get password
     *
     * @return string
     */
    public function getPassword()
    {
        return $this->password;
    }

    /**
     * Set salt
     *
     * @param  string $salt
     * @return User
     */
    public function setSalt($salt)
    {
        $this->salt = $salt;

        return $this;
    }

    /**
     * Get salt
     *
     * @return string
     */
    public function getSalt()
    {
        return $this->salt;
    }

    /**
     * Set roles
     *
     * @param  array $roles
     * @return User
     */
    public function setRoles($roles)
    {
        $this->roles = $roles;

        return $this;
    }

    /**
     * Get roles
     *
     * @return array
     */
    public function getRoles()
    {
        return $this->roles;
    }

    /**
     * Set scopes
     *
     * @param  array $scopes
     * @return User
     */
    public function setScopes($scopes)
    {
        $this->scopes = $scopes;

        return $this;
    }

    /**
     * Get scopes
     *
     * @return array
     */
    public function getScopes()
    {
        return $this->scopes;
    }

    /**
     * Get scope
     *
     * @return string
     */
    public function getScope()
    {
        return implode(' ', $this->getScopes());
    }

    /**
     * Erase credentials
     *
     * @return void
     */
    public function eraseCredentials()
    {
        // We don't hold anything sensitivie, do nothing
    }

    /**
     * Return a array representation of user
     * @return array key => value
     */
    public function toArray()
    {
        return [
            'id' => $this->getId(),
            'username' => $this->getUsername(),
            'roles' => $this->getRoles(),
            'scope' => $this->getScope()
        ];
    }

    /**
     * @return string
     */
    public function __toString()
    {
        return is_null($this->username) ? '' : $this->username;
    }
}
