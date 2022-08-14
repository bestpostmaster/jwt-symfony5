<?php

namespace App\Service;

use App\Entity\HostedFile;
use Doctrine\Persistence\ManagerRegistry;

class VirusScannerService
{
    private ManagerRegistry $doctrine;
    private string $hostingDirectory;
    private string $quarantineDirectory;
    private string $projectDirectory;

    public function __construct(ManagerRegistry $doctrine, string $hostingDirectory, string $quarantineDirectory, string $projectDirectory)
    {
        $this->doctrine = $doctrine;
        $this->hostingDirectory = $hostingDirectory;
        $this->quarantineDirectory = $quarantineDirectory;
        $this->projectDirectory = $projectDirectory;
    }

    public function scan(HostedFile $hostedFile):void
    {
        if (!is_dir($this->quarantineDirectory)) {
            mkdir($this->quarantineDirectory);
        }

        exec("clamscan -r --move=".$this->quarantineDirectory." ".$this->hostingDirectory.$hostedFile->getName()." -l ".$this->projectDirectory.'/var/log/'.$hostedFile->getName()."-ScanResult.log");

        $hostedFile->setScaned(true);
        $em = $this->doctrine->getManager();
        $em->persist($hostedFile);
        $em->flush();
    }
}