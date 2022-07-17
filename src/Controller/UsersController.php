<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class UsersController extends AbstractController
{
    /**
     * @Route("/api/admin/users", name="app_users")
     */
    public function index(): Response
    {
        return JsonResponse::fromJsonString('{ "users": ["user1", "user2", "user3"] }');
    }
}
