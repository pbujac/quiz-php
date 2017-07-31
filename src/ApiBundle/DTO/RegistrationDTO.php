<?php

namespace ApiBundle\DTO;

use AdminBundle\Validator\Constraints\UniqueUser;
use Symfony\Component\Validator\Constraints as Assert;
use JMS\Serializer\Annotation\Type;

class RegistrationDTO
{
    /**
     * @Type("string")
     *
     * @Assert\NotBlank(message="Username isn't specified.")
     * @Assert\Length(min = 4, max = 15, minMessage="Username too short.", maxMessage="Username too long")
     * @UniqueUser(message="Username taken already.")
     *
     * @var string
     */
    public $username;

    /**
     * @Type("string")
     *
     * @Assert\NotBlank(message="Password isn't specified.")
     * @Assert\Length(min = 6, max = 24, minMessage="Password too short.", maxMessage="Password too long")
     *
     * @var string
     */
    public $password;

    /**
     * @Type("string")
     *
     * @Assert\NotBlank(message="First name  isn't specified.")
     * @Assert\Length(min = 2, max = 15, minMessage="First name too short.", maxMessage="First name too long")
     *
     * @var string
     */
    public $firstName;

    /**
     * @Type("string")
     *
     * @Assert\NotBlank(message="Last name isn't specified.")
     * @Assert\Length(min = 2, max = 15, minMessage="Last name too short.", maxMessage="Last name too long")
     *
     * @var string
     */
    public $lastName;
}
