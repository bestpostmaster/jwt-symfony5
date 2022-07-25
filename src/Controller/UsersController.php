<?php

namespace App\Controller;

use App\Entity\User;
use App\Repository\UserRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;

class UsersController extends AbstractController
{
    private $passwordEncoder;

    public function __construct(UserPasswordEncoderInterface $passwordEncoder)
    {
        $this->passwordEncoder = $passwordEncoder;
    }
    /**
     * @Route("/api/admin/users", name="app_users")
     */
    public function index(UserRepository $userRepository): Response
    {
        return $this->json($userRepository->findAll(), 200, [], ['groups' => 'user:read']);
    }

    /**
     * @Route("/api/admin/users/add", name="app_users_add")
     */
    public function add(Request $request): Response
    {
        if(!$this->container->get('security.authorization_checker')->isGranted('ROLE_ADMIN')) {
            throw new \Exception('Admin only !');
        }

        $data = json_decode($request->getContent());

        $user = new User();
        $user->setLogin($data->username);
        $user->setRoles($data->roles);
        $user->setRegistrationDate(new \DateTime('now', new \DateTimeZone('Europe/Paris')));
        $user->setSecretTokenForValidation(md5(uniqid(mt_rand(), true)).md5(uniqid(mt_rand(), true)));
        $user->setPassword($this->passwordEncoder->encodePassword($user,
            $data->password
        ));

        $manager = $this->getDoctrine()->getManager();
        $manager->persist($user);
        $manager->flush($user);

        return $this->json($user, 200, [], ['groups' => 'user:read']);
    }
}
