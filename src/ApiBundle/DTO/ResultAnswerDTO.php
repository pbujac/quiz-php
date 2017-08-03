<?php

namespace ApiBundle\DTO;

use Symfony\Component\Validator\Constraints as Assert;
use JMS\Serializer\Annotation\Type;
use Hateoas\Configuration\Annotation as Hateoas;

class ResultAnswerDTO
{
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
     * @Type("ApiBundle\DTO\AnswerDTO")
     *
     * @Assert\NotBlank(groups={"quiz_solve"})
     * @Assert\Valid
     *
     * @var AnswerDTO
     */
    public $answer;

    /**
     * @Type("ApiBundle\DTO\ResultDTO")
     *
     * @Assert\Valid
     *
     * @var ResultDTO
     */
    public $result;

}
