<?php

namespace App\DataFixtures;

use App\Entity\User;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;

class UserFixtures extends Fixture
{
     private $passwordEncoder;

     public function __construct(UserPasswordEncoderInterface $passwordEncoder)
     {
         $this->passwordEncoder = $passwordEncoder;
     }

    public function load(ObjectManager $manager): void
    {
        $users = [
            [
                'login' => 'admin',
                'roles' => ['ROLE_ADMIN'],
                'pass' => 'f56f5h4f6g5h4f56df5gh4'
            ],
            [
                'login' => 'user',
                'roles' => ['ROLE_USER'],
                'pass' => 'fd54gh5fg4h5fh4f5g54hf5'
            ]
        ];

        foreach($users as $item) {
            $user = new User();
            $user->setLogin($item['login']);
            $user->setRoles($item['roles']);
            $user->setPassword($this->passwordEncoder->encodePassword($user,
                $item['pass']
            ));

            $manager->persist($user);
            $manager->flush($user);
        }
    }
}
