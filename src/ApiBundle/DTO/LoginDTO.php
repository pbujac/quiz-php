<?php

namespace ApiBundle\DTO;

use JMS\Serializer\Annotation\Type;

class LoginDTO
{
    /**
     * @Type("string")
     * @var string
     */
    public $username;

    /**
     * @Type("string")
     * @var string
     */
    public $password;
}
