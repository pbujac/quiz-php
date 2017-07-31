<?php

namespace ApiBundle\DTO;

use AdminBundle\Validator\Constraints\UniqueUser;
use Symfony\Component\Validator\Constraints as Assert;
use JMS\Serializer\Annotation\Type;
use Hateoas\Configuration\Annotation as Hateoas;

/**
 * @Hateoas\Relation(
 *     "self",
 *     href = "expr('/api/users/' ~ object.id)"
 * )
 */
class UserDTO
{
    /**
     * @Type("int")
     *
     * @Assert\NotBlank()
     *
     * @var int
     */
    public $id;

    /**
     * @Type("string")
     *
     * @Assert\NotBlank()
     * @UniqueUser()
     *
     * @var string
     */
    public $username;

    /**
     * @Type("string")
     *
     * @Assert\NotBlank()
     *
     * @var string
     */
    public $password;

    /**
     * @Type("string")
     *
     * @var string
     */
    public $firstName;

    /**
     * @Type("string")
     *
     * @var string
     */
    public $lastName;

    /**
     * @Type("int")
     *
     * @var \DateTime
     */
    public $createdAt;

    /**
     * @Type("boolean")
     *
     * @var bool
     */
    public $active;

    /**
     * @Type("array")
     *
     * @var array
     */
    public $roles;
}
