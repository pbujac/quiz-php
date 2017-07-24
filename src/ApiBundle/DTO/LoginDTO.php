<?php

namespace ApiBundle\DTO;

use AppBundle\Entity\User;
use Symfony\Component\Validator\Constraints as Assert;
use JMS\Serializer\Annotation\Type;

class LoginDTO
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
     * @return string
     */
    public function getUsername(): string
    {
        return $this->username;
    }

    /**
     * @param string $username
     */
    public function setUsername(string $username)
    {
        $this->username = $username;
    }

    /**
     * @return string
     */
    public function getPassword(): string
    {
        return $this->password;
    }

    /**
     * @param string $password
     */
    public function setPassword(string $password)
    {
        $this->password = $password;
    }

    /**
     * @return User
     */
    public function getUser()
    {
        $user = new User();
        $user->setUsername($this->username);
        $user->setPassword($this->password);
        $user->setActive(true);

        return $user;
    }
}
