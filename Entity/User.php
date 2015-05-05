<?php

namespace OAuth2\ServerBundle\Entity;

use OAuth2\ServerBundle\User\OAuth2UserInterface;
use FOS\UserBundle\Model\User as BaseUser;
use UserManagementBundle\User\DicomUserInterface;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * User
 */
class User extends BaseUser implements DicomUserInterface
{
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
     * @var array
     */
    private $scopes = [];

    /**
     * @var \DateTime
     */
    private $birthdate;

    /**
     * @Assert\True(message="Username should not contain email")
     */
    public function isUsernameCheck()
    {
        $isUsernameCheck = ($this->username === $this->email || preg_match('/^(([a-zA-Z0-9_\-.]+)@([a-zA-Z0-9\-]+)\.[a-zA-Z0-9\-.]+$)/', $this->username)) ? false : true;

        return $isUsernameCheck;
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
     * Set BirthDate
     *
     * @param  \DateTime $birthDate
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
