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
    private $firstname;

    /**
     * @var string
     */
    private $lastname;

    /**
     * @var string
     */
    private $middlename;

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
     * @var datetime
     */
    private $birthdate;

    /**
     * @var string
     */
    private $email;

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
     * @param  string $username
     * @return User
     */
    public function setUsername($username)
    {
        $this->username = $username;

        return $this;
    }

    /**
     * @return string
     */
    public function getUsername()
    {
        return $this->username;
    }

    /**
     * Set FirstName
     *
     * @param  string $firstName
     * @return User
     */
    public function setFirstName($firstName)
    {
        $this->firstname = $firstName;

        return $this;
    }

    /**
     * Get FirstName
     *
     * @return string
     */
    public function getFirstName()
    {
        return $this->firstname;
    }

    /**
     * Set LastName
     *
     * @param  string $lastName
     * @return User
     */
    public function setLastName($lastName)
    {
        $this->lastname = $lastName;

        return $this;
    }

    /**
     * Get LastName
     *
     * @return string
     */
    public function getLastName()
    {
        return $this->lastname;
    }

    /**
     * Get MiddleName
     *
     * @return string
     */
    public function getMiddleName()
    {
        return $this->middlename;
    }

    /**
     * Set MiddleName
     *
     * @param  string $middleName
     * @return User
     */
    public function setMiddleName($middleName)
    {
        $this->middlename = $middleName;

        return $this;
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
     * Set Email
     *
     * @param  string $email
     * @return User
     */
    public function setEmail($email)
    {
        $this->email = $email;

        return $this;
    }

    /**
     * Get Email
     *
     * @return string
     */
    public function getEmail()
    {
        return $this->email;
    }

    /**
     * Set BirthDate
     *
     * @param  datetime $birthDate
     * @return User
     */
    public function setBirthDate($birthDate)
    {
        $this->birthdate = $birthDate;

        return $this;
    }

    /**
     * Get BirthDate
     *
     * @return string
     */
    public function getBirthDate()
    {
        return $this->birthdate;
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
            'scope' => $this->getScope(),
            'firstname' => $this->getFirstName(),
            'lastname' => $this->getLastName(),
            'middlename' => $this->getMiddleName(),
            'email' => $this->getEmail(),
            'birthdate' => $this->getBirthDate()
        ];
    }

    public function getFIO()
    {
        return $this->lastname . ' ' . $this->firstname . ' ' . $this->middlename;
    }

    /**
     * @return string
     */
    public function __toString()
    {
        return is_null($this->getUsername()) ? '' : $this->getUsername();
    }

    /**
     * @return bool
     */
    public function isNew()
    {
        return !$this->id ? true : false;
    }

    /**
     * @return string
     */
    public function getRolesAsString()
    {
        $roles = array();
        foreach ($this->getRoles() as $role) {
            $roles[] = $role;
        }

        return implode(', ', $roles);
    }
}
