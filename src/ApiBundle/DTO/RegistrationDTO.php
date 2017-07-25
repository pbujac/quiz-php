<?php

namespace ApiBundle\DTO ;

use Symfony\Component\Validator\Constraints as Assert;
use JMS\Serializer\Annotation\Type;

class RegistrationDTO
{
    /**
     * @Assert\NotBlank
     * @Type("string")
     * @var string
     */
    public $username;

    /**
     * @Assert\NotBlank
     * @Type("string")
     * @var string
     */
    public $password;

    /**
     * @Assert\NotBlank
     * @Type("string")
     * @var string
     */
    public $firstName;

    /**
     * @Assert\NotBlank
     * @Type("string")
     * @var string
     */
    public $lastName;

    /**
     *
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

    /**
     * @return string
     */
    public function getUsername(): string
    {
        return $this->username;
    }

    /**
     * @return string
     */
    public function getPassword(): string
    {
        return $this->password;
    }

    /**
     * @return string
     */
    public function getFirstName(): string
    {
        return $this->firstName;
    }

    /**
     * @return string
     */
    public function getLastName(): string
    {
        return $this->lastName;
    }

}
