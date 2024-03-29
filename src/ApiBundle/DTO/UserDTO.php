<?php

namespace ApiBundle\DTO;

use AdminBundle\Validator\Constraints\UniqueUser;
use Symfony\Component\Validator\Constraints as Assert;
use JMS\Serializer\Annotation\Type;
use Hateoas\Configuration\Annotation as Hateoas;

/**
 * @Hateoas\Relation(
 *     "self",
 *     href = "expr('/api/v1/users/' ~ object.id)"
 * )
 */
class UserDTO
{
    /**
     * @Type("int")
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
     * @Assert\NotBlank()
     *
     * @var string
     */
    public $firstName;

    /**
     * @Type("string")
     *
     * @Assert\NotBlank()
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
