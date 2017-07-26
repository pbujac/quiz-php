<?php

namespace ApiBundle\DTO ;

use Symfony\Component\Validator\Constraints as Assert;
use JMS\Serializer\Annotation\Type;

class RegistrationDTO
{
    /**
     * @Type("string")
     *
     * @Assert\NotBlank
     * @Assert\Length(min = 4, max = 15)
     *
     * @var string
     */
    public $username;

    /**
     * @Type("string")
     *
     * @Assert\NotBlank
     * @Assert\Length(min = 6, max = 15)
     *
     * @var string
     */
    public $password;

    /**
     * @Type("string")
     *
     * @Assert\NotBlank
     * @Assert\Length(min = 3, max = 15)
     *
     * @var string
     */
    public $firstName;

    /**
     * @Type("string")
     *
     * @Assert\NotBlank
     * @Assert\Length(min = 3, max = 15)
     *
     * @var string
     */
    public $lastName;
}
