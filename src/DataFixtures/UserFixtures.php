<?php

namespace App\DataFixtures;

use App\Entity\User;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;

class UserFixtures extends Fixture
{
    private $passwordHasher;

    public function __construct(UserPasswordHasherInterface $passwordHasher)
    {
        $this->passwordHasher = $passwordHasher;
    }

    public function load(ObjectManager $manager)
    {
        for ($i=0; $i < 3; $i++) { 

            $user = new User();
            $user->setPassword($this->passwordHasher->hashPassword(
                $user,
                'password'
            ));

            if ($i == 0) {
                $user->setEmail('admin@admin.fr');
                $user->setFirstName('John');
                $user->setLastName('Admin');
                $user->setRoles(['ROLE_ADMIN']);
            }

            if ($i == 1) {
                $user->setEmail('user@front.fr');
                $user->setFirstName('Michel');
                $user->setLastName('Front');
                $user->setRoles(['ROLE_USER']);
            }

            if ($i == 2) {
                $user->setEmail('user@back.fr');
                $user->setFirstName('Lea');
                $user->setLastName('Support');
                $user->setRoles(['ROLE_SUPPORT']);
            }

            $manager->persist($user);
            $manager->flush();
        }
    }
}
