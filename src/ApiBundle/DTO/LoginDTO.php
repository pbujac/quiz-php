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
}
