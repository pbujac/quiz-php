<?php

namespace ApiBundle\DTO;

class RegisterDTO
{
    /**
     * @var string
     *
     * @ORM\Column(type="string", length=45)
     */
    public $username;

    /**
     * @var string
     *
     * @ORM\Column(type="string", length=255)
     */
    public $password;

    /**
     * @var string
     *
     * @ORM\Column(name="first_name", type="string", length=45)
     */
    public $firstName;

    /**
     * @var string
     *
     * @ORM\Column(name="last_name", type="string", length=45)
     */
    public $lastName;

    public function __construct() {

    }

    /**
     * @param string $username
     */
    public function setUsername(string $username)
    {
        $this->username = $username;
    }

    /**
     * @param string $password
     */
    public function setPassword(string $password)
    {
        $this->password = $password;
    }

    /**
     * @param string $firstName
     */
    public function setFirstName(string $firstName)
    {
        $this->firstName = $firstName;
    }

    /**
     * @param string $lastName
     */
    public function setLastName(string $lastName)
    {
        $this->lastName = $lastName;
    }
}
