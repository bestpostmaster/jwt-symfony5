<?php

namespace App\DataFixtures;

use App\Entity\HostedFile;
use App\Entity\User;
use DateTimeZone;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\DataFixtures\DependentFixtureInterface;
use Doctrine\Persistence\ObjectManager;

class HostedFileFixtures extends Fixture implements DependentFixtureInterface
{
    public function load(ObjectManager $manager): void
    {
        $users = $manager->getRepository(User::class)->findAll();
        $files = $this->getFilesFixturesFromUsers($users);

        foreach($files as $item) {
            $file = new HostedFile();
            $file->setRealDir($item['realDir']);
            $file->setName($item['name']);
            $file->setClientName($item['clientName']);
            $file->setUploadDate($item['uploadDate']);
            $file->setExpirationDate($item['expirationDate']);
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

    private function getFilesFixturesFromUsers(array $users):array
    {
        $files = [
            [
                'realDir' => '/public/up/',
                'name' => 'test-name'.$users[0]->getId().'.jpg',
                'clientName' => 'test-cli-name'.$users[0]->getId().'.jpg',
                'uploadDate' => new \DateTime('now'),
                'expirationDate' => new \DateTime("2024-07-05T06:00:00Z", new DateTimeZone("Europe/Paris")),
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
                'expirationDate' => new \DateTime("2024-07-05T06:00:00Z", new DateTimeZone("Europe/Paris")),
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

        return $files;
    }

    public function getDependencies(): array
    {
        return [
            UserFixtures::class,
        ];
    }
}
