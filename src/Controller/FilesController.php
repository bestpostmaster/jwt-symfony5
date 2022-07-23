<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use App\Repository\HostedFileRepository;

class FilesController extends AbstractController
{
    /**
     * @Route("/api/files", name="app_files")
     */
    public function index(HostedFileRepository $hostedFileRepository): Response
    {
        $userId = ($this->getUser())->getId();

        if($this->container->get('security.authorization_checker')->isGranted('ROLE_ADMIN')) {
            return $this->json($hostedFileRepository->findAll(), 200, [], ['groups' => 'file:read']);
        }

        return $this->json($hostedFileRepository->findBy(['user' => $userId]), 200, [], ['groups' => 'file:read']);
    }

    /**
     * TO DO
     * @Route("/api/files/upload", name="app_files_upload")
     */
    public function upload(HostedFileRepository $hostedFileRepository): Response
    {
        $userId = ($this->getUser())->getId();

        if($this->container->get('security.authorization_checker')->isGranted('ROLE_ADMIN')) {
            return $this->json($hostedFileRepository->findAll(), 200, [], ['groups' => 'file:read']);
        }

        return $this->json($hostedFileRepository->findBy(['user' => $userId]), 200, [], ['groups' => 'file:read']);
    }

    /**
     * TO DO
     * @Route("/api/files/download", name="app_files_download")
     */
    public function download(HostedFileRepository $hostedFileRepository): Response
    {
        $userId = ($this->getUser())->getId();

        if($this->container->get('security.authorization_checker')->isGranted('ROLE_ADMIN')) {
            return $this->json($hostedFileRepository->findAll(), 200, [], ['groups' => 'file:read']);
        }

        return $this->json($hostedFileRepository->findBy(['user' => $userId]), 200, [], ['groups' => 'file:read']);
    }

    /**
     * TO DO
     * @Route("/api/files/delete", name="app_files_delete")
     */
    public function delete(HostedFileRepository $hostedFileRepository): Response
    {
        $userId = ($this->getUser())->getId();

        if($this->container->get('security.authorization_checker')->isGranted('ROLE_ADMIN')) {
            return $this->json($hostedFileRepository->findAll(), 200, [], ['groups' => 'file:read']);
        }

        return $this->json($hostedFileRepository->findBy(['user' => $userId]), 200, [], ['groups' => 'file:read']);
    }

    /**
     * TO DO
     * @Route("/api/files/convert", name="app_files_convert")
     */
    public function convert(HostedFileRepository $hostedFileRepository): Response
    {
        $userId = ($this->getUser())->getId();

        if($this->container->get('security.authorization_checker')->isGranted('ROLE_ADMIN')) {
            return $this->json($hostedFileRepository->findAll(), 200, [], ['groups' => 'file:read']);
        }

        return $this->json($hostedFileRepository->findBy(['user' => $userId]), 200, [], ['groups' => 'file:read']);
    }
}
