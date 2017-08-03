<?php

namespace ApiBundle\Transformer;

use ApiBundle\DTO\UserDTO;
use AppBundle\Entity\User;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;

class UserTransformer implements TransformerInterface
{
    /** @var  UserPasswordEncoderInterface $encoder */
    private $encoder;

    /**
     * @param UserPasswordEncoderInterface $encoder
     */
    public function __construct(UserPasswordEncoderInterface $encoder)
    {
        $this->encoder = $encoder;
    }

    /**
     * @param UserDTO $userDTO
     * @param User|null $user
     *
     * @return User
     */
    public function reverseTransform($userDTO, $user = null): User
    {
        $user = $user ?: new User();
        $user->setUsername($userDTO->username);

        $encodedPassword = $this->encoder->encodePassword($user, $userDTO->password);
        $user->setPassword($encodedPassword);

        $user->setFirstName($userDTO->firstName);
        $user->setLastName($userDTO->lastName);
        $user->setActive(true);
        $user->addRole(User::ROLE_USER);

        return $user;
    }

    /**
     * @param User $user
     *
     * @return UserDTO
     */
    public function transform($user): UserDTO
    {
        $userDTO = new UserDTO();

        $userDTO->id = $user->getId();
        $userDTO->username = $user->getUsername();
        $userDTO->lastName = $user->getLastName();
        $userDTO->firstName = $user->getFirstName();
        $userDTO->active = $user->isActive();
        $userDTO->roles = $user->getRoles();
        $userDTO->createdAt = $user->getCreatedAt()->getTimestamp();

        return $userDTO;
    }

    /**
     * @return string
     */
    public function getEntityClass(): string
    {
        return User::class;
    }
}
