<?php

namespace App\DataFixtures;

use App\Entity\HostedFile;
use App\Entity\User;
use DateTimeZone;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;

class UserFixtures extends Fixture
{
     private UserPasswordHasherInterface $passwordEncoder;

     public function __construct(UserPasswordHasherInterface $passwordEncoder)
     {
         $this->passwordEncoder = $passwordEncoder;
     }

    public function load(ObjectManager $manager): void
    {
        $users = [
            [
                'login' => 'admin',
                'roles' => ['ROLE_ADMIN'],
                'pass' => 'f56f5h4f6g5h4f56df5gh4_admin'
            ],
            [
                'login' => 'user',
                'roles' => ['ROLE_USER'],
                'pass' => 'f56f5h4f6g5h4f56df5gh4'
            ]
        ];

        foreach($users as $item) {
            $user = new User();
            $user->setLogin($item['login']);
            $user->setRoles($item['roles']);
            $user->setPassword($this->passwordEncoder->hashPassword($user,
                $item['pass']
            ));

            $manager->persist($user);
            $manager->flush($user);
        }
    }
}
