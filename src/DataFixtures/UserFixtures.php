<?php

Namespace App\DataFixtures;

use App\Entity\User;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Bundle\FixturesBundle\ORMFixtureInterface;
use Doctrine\Persistence\ObjectManager;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;


class UserFixtures extends Fixture 
{
    private UserPasswordHasherInterface $passwordHasher;

    public function __construct(UserPasswordHasherInterface $passwordHasher)
    {
        $this->passwordHasher = $passwordHasher;
    }


    public function load(ObjectManager $manager): void
{   
    $userData = [
        ['email' => 'jose.ecfarcadia@gmail.com', 'password' => 'Studi123ECF', 'roles' => ['ROLE_ADMIN']],
        ['email' => 'veterinaire.ecfarcadia@gmail.com', 'password' => 'Studi123ECF', 'roles' => ['ROLE_VET']],
        ['email' => 'employe.ecfarcadia@gmail.com', 'password' => 'Studi123ECF', 'roles' => ['ROLE_EMPLOYE']],  
    ];

    foreach ($userData as $UD) {
        $user = new User(
            $UD['email'],
            $UD['password'],
            $UD['roles'],
            new \DateTimeImmutable(),
            null,
            1
        );
        $user->setPassword($this->passwordHasher->hashPassword($user, $UD['password']));
        $user->setCreatedAt(new \DateTimeImmutable());
        $manager->persist($user);   
    }
    $manager->flush();
    }

    
}