<?php

namespace App\Controller;

use App\Entity\HostedFile;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use App\Repository\HostedFileRepository;
use Psr\Log\LoggerInterface;

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
    public function upload(Request $request, LoggerInterface $logger): Response
    {
        if (empty($request->files) || !($request->files)->get("file")) {
            throw new \Exception('No file sent');
        }

        $receivedFile = ($request->files)->get("file");
        $logger->info('Try to upload file : '.$receivedFile->getClientOriginalName());

        if(!$this->container->get('security.authorization_checker')->isGranted('ROLE_USER')) {
            throw new \Exception('No user logged in');
        }

        $name = md5(uniqid(mt_rand(), true)).'.'.strtolower($receivedFile->getClientOriginalExtension());
        $directory = $this->getParameter('kernel.project_dir') . '/public/up/';
        $receivedFile->move($directory, $name);

        if (!file_exists($directory.$name)) {
            throw new \Exception('Upload error...');
        }

        $file = new HostedFile();
        $file->setRealDir('/public/up/');
        $file->setName($name);
        $file->setClientName($receivedFile->getClientOriginalName());
        $file->setUploadDate(new \DateTime('now'));
        $file->setUser($this->getUser());
        $file->setSize(filesize($directory.$name));
        $file->setScaned(false);
        $file->setDescription($receivedFile->getClientOriginalName());
        $file->setDownloadCounter(0);
        $file->setUrl(md5(uniqid(mt_rand(), true)));
        $file->setUploadLocalisation($_SERVER['REMOTE_ADDR']);
        $file->setCopyrightIssue(false);
        $file->setConversionsAvailable('');
        $file->setVirtualDirectory('/');

        $manager = $this->getDoctrine()->getManager();
        $manager->persist($file);
        $manager->flush($file);

        return $this->json($file, 200, [], ['groups' => 'file:read']);
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
