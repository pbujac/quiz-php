<?php

namespace ApiBundle\DTO;

use Symfony\Component\Validator\Constraints as Assert;
use JMS\Serializer\Annotation\Type;

class LoginDTO
{
    /**
     * @Assert\NotBlank(groups={"login"})
     *
     * @Type("string")
     * @var string
     */
    public $username;

    /**
     * @Assert\NotBlank(groups={"login"})
     *
     * @Type("string")
     * @var string
     */
    public $password;

    /**
     * @Assert\NotBlank(groups={"token"})
     *
     * @Type("string")
     * @var string
     */
    public $token;
}
