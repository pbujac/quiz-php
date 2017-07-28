<?php


namespace ApiBundle\DTO;

use DateTime;
use JMS\Serializer\Annotation\Type;

class AccessTokenDTO
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
     * @var string
     */
    public $accessToken;

    /**
     * @Type("DateTime")
     *
     * @var DateTime
     */
    public $expireAt;


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
