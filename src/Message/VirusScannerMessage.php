<?php

namespace App\Message;

final class VirusScannerMessage
{
     private int $fileId;

     public function __construct(string $fileId)
     {
         $this->fileId = $fileId;
     }

    public function getFileId(): int
    {
        return $this->fileId;
    }
}
