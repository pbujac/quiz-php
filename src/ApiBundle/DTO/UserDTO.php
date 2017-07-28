<?php

namespace ApiBundle\DTO;

use AdminBundle\Validator\Constraints\UniqueUser;
use Symfony\Component\Validator\Constraints as Assert;
use JMS\Serializer\Annotation\Type;
use Hateoas\Configuration\Annotation as Hateoas;

/**
 * @Hateoas\Relation("self", href = "expr('/api/users/' ~ object.getId())")
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
     * @return int
     */
    public function getId(): int
    {
        return $this->id;
    }

    /**
     * @param int $id
     */
    public function setId(int $id)
    {
        $this->id = $id;
    }
}
