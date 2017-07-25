<?php

namespace ApiBundle\DTO ;

use AppBundle\Entity\User;
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
     * @return User
     */
    public function addUser() {

        $user = new User();
        $user->setUsername($this->username);
        $user->setPassword($this->password);
        $user->setFirstName($this->firstName);
        $user->setLastName($this->lastName);
        $user->setActive(true);

        return $user;
    }

}
