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
        !$userDTO->username ?: $user->setUsername($userDTO->username);

        $encodedPassword = $this->encoder->encodePassword($user, $userDTO->password);
        !$userDTO->password ?: $user->setPassword($encodedPassword);

        !$userDTO->firstName ?: $user->setFirstName($userDTO->firstName);
        !$userDTO->lastName ?: $user->setLastName($userDTO->lastName);
        !$userDTO->roles ?: $user->addRole(User::ROLE_USER);

        $user->setActive(true);

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
