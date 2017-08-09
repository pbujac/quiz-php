<?php

namespace ApiBundle\DTO;

use Doctrine\Common\Collections\ArrayCollection;
use Symfony\Component\Validator\Constraints as Assert;
use JMS\Serializer\Annotation\Type;

class ResultDTO
{
    /**
     * @Type("int")
     *
     * @var int
     */
    public $id;

    /**
     * @Type("ApiBundle\DTO\UserDTO")
     *
     * @Assert\Valid
     *
     * @var UserDTO
     */
    public $user;

    /**
     * @Type("ApiBundle\DTO\QuizDTO")
     *
     * @Assert\Valid
     *
     * @var QuizDTO
     */
    public $quiz;

    /**
     * @Type("int")
     *
     * @var \DateTime
     */
    public $createdAt;

    /**
     * @Type("int")
     *
     * @var int
     */
    public $score;

    /**
     * @Type("boolean")
     *
     * @var bool
     */
    public $finished;

    /**
     * @Type("ArrayCollection<ApiBundle\DTO\ResultAnswerDTO>")
     *
     * @Assert\Valid
     *
     * @var ArrayCollection|ResultAnswerDTO[]
     */
    public $resultAnswers;
}
