<?php

namespace App\MessageHandler;

use App\Entity\HostedFile;
use App\Message\VirusScannerMessage;
use App\Service\VirusScannerService;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\Messenger\Handler\MessageHandlerInterface;

final class VirusScannerMessageHandler implements MessageHandlerInterface
{
    private EntityManagerInterface $em;
    private VirusScannerService $virusScannerService;

    /**
     * @param EntityManagerInterface $em
     * @param VirusScannerService $virusScannerService
     */
    public function __construct(EntityManagerInterface $em, VirusScannerService $virusScannerService)
    {
        $this->em = $em;
        $this->virusScannerService = $virusScannerService;
    }

    public function __invoke(VirusScannerMessage $message)
    {
        $hostedFile = $this->em->find(HostedFile::class, $message->getFileId());
        $this->virusScannerService->scan($hostedFile);
    }
}
