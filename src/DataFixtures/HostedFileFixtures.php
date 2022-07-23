<?php

namespace App\DataFixtures;

use App\Entity\HostedFile;
use App\Entity\User;
use App\Repository\UserRepository;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;

class HostedFileFixtures extends Fixture
{
    public function load(ObjectManager $manager): void
    {
    }
}
