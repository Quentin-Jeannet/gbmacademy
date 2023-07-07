<?php

namespace App\DataFixtures;

use App\Entity\User;
use Doctrine\Persistence\ObjectManager;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;

class UserFixtures extends Fixture
{
    // ====================================================== //
    // ===================== PROPRIETES ===================== //
    // ====================================================== //
    private $encoder;
    // ====================================================== //
    // ==================== CONSTRUCTEUR ==================== //
    // ====================================================== //
    public function __construct(UserPasswordHasherInterface $userPasswordHasherInterface)
    {
        $this->encoder = $userPasswordHasherInterface;
    }
    
    public function load(ObjectManager $manager): void
    {
        $user = new User();
        $user->setEmail('cmeneux@graphikchannel.com');
        $user->setRoles(['ROLE_USER', 'ROLE_ADMIN', 'ROLE_SUPERADMIN']);
        $encodedPassword = $this->encoder->hashPassword($user, "pass");
        $user->setPassword($encodedPassword);
        $manager->persist($user);

        // --- ADMIN/SUPERADMIN --- //
        $user = new User();
        $user->setEmail('henrinesci@gmail.com');
        $user->setRoles(['ROLE_USER', 'ROLE_ADMIN']);
        $encodedPassword = $this->encoder->hashPassword($user, "pass");
        $user->setPassword($encodedPassword);
        $manager->persist($user);

        $user = new User();
        $user->setEmail('quentin@graphikchannel.com');
        $user->setRoles(['ROLE_USER', 'ROLE_ADMIN', 'ROLE_SUPERADMIN']);
        $encodedPassword = $this->encoder->hashPassword($user, "pass");
        $user->setPassword($encodedPassword);
        $manager->persist($user);


        $manager->flush();
    }
}
