<?php

namespace App\DataFixtures;

use App\Entity\HostedFile;
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
            $user->setPassword($this->passwordEncoder->encodePassword($user,
                $item['pass']
            ));

            $manager->persist($user);
            $manager->flush($user);
        }
        $this->loadFiles($manager);
    }

    public function loadFiles(ObjectManager $manager): void
    {
        $users = $manager->getRepository(User::class)->findAll();

        $files = [
            [
                'realDir' => '/public/up/',
                'name' => 'test-name'.$users[0]->getId().'.jpg',
                'clientName' => 'test-cli-name'.$users[0]->getId().'.jpg',
                'uploadDate' => new \DateTime('now'),
                'user' => $users[0],
                'size' => 99191951951,
                'scaned' => false,
                'description' => 'ééé ààà desc',
                'downloadCounter' => 0,
                'url' => 'abcd',
                'uploadLocalisation' => '127.0.0.1',
                'copyrightIssue' => false,
                'conversionsAvailable' => 'jpg,png',
                'virtualDirectory' => 'test-dir'.$users[0]->getId()
            ],
            [
                'realDir' => '/public/up/',
                'name' => 'test-name'.$users[1]->getId().'.jpg',
                'clientName' => 'test'.$users[1]->getId().'.jpg',
                'uploadDate' => new \DateTime('now'),
                'user' => $users[1],
                'size' => 6516165161,
                'scaned' => false,
                'description' => 'ééé bbb desc',
                'downloadCounter' => 0,
                'url' => 'abcdef',
                'uploadLocalisation' => '127.0.0.1',
                'copyrightIssue' => false,
                'conversionsAvailable' => 'jpg,png',
                'virtualDirectory' => 'test-dir'.$users[1]->getId()
            ]
        ];

        foreach($files as $item) {
            $file = new HostedFile();
            $file->setRealDir($item['realDir']);
            $file->setName($item['name']);
            $file->setClientName($item['clientName']);
            $file->setUploadDate($item['uploadDate']);
            $file->setUser($item['user']);
            $file->setSize((int) $item['size']);
            $file->setScaned($item['scaned']);
            $file->setDescription($item['description']);
            $file->setDownloadCounter($item['downloadCounter']);
            $file->setUrl($item['url']);
            $file->setUploadLocalisation($item['uploadLocalisation']);
            $file->setCopyrightIssue($item['copyrightIssue']);
            $file->setConversionsAvailable($item['conversionsAvailable']);
            $file->setVirtualDirectory($item['virtualDirectory']);

            $manager->persist($file);
            $manager->flush($file);
        }
    }
}
