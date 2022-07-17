<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class FilesController extends AbstractController
{
    /**
     * @Route("/api/files", name="app_files")
     */
    public function index(): Response
    {
        return JsonResponse::fromJsonString('{ "files": ["file1", "file2", "file3"] }');
    }
}
