<?php

namespace App\Manager;

use App\Entity\User;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;

class UserManager
{
    /**
     * @var EntityManagerInterface
     */
    private $em;

    /**
     * @var UserPasswordEncoderInterface
     */
    private $passwordEncoder;


    public function __construct(EntityManagerInterface $em, UserPasswordEncoderInterface $passwordEncoder)
    {
        $this->em = $em;
        $this->passwordEncoder= $passwordEncoder;
    }

    /**
     * @param User $user
     * @param $plainPassword
     */
    public function changePassword(User $user, $plainPassword)
    {
        $this->encodePassword($user, $plainPassword);
        $this->em->flush();
    }

    /**
     * @param User $user
     * @param $plainPassword
     */
    public function encodePassword(User $user, $plainPassword)
    {
        $password = $this->passwordEncoder->encodePassword($user, $plainPassword);
        $user->setPassword($password);
        $user->eraseCredentials();
    }


}