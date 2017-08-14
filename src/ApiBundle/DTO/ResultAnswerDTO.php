<?php

namespace ApiBundle\DTO;

use Doctrine\Common\Collections\ArrayCollection;
use Symfony\Component\Validator\Constraints as Assert;
use JMS\Serializer\Annotation\Type;

class ResultAnswerDTO
{
    /**
     * @Type("int")
     *
     * @var int
     */
    public $id;

    /**
     * @Type("ApiBundle\DTO\QuestionDTO")
     *
     * @Assert\NotBlank(groups={"quiz_solve"})
     * @Assert\Valid
     *
     * @var QuestionDTO
     */
    public $question;

    /**
     * @Type("ArrayCollection<ApiBundle\DTO\AnswerDTO>")
     *
     * @Assert\NotBlank(groups={"quiz_solve"})
     * @Assert\Valid
     *
     * @var ArrayCollection
     */
    public $answers;

    /**
     * @Type("ApiBundle\DTO\ResultDTO")
     *
     * @Assert\Valid
     *
     * @var ResultDTO
     */
    public $result;

}
