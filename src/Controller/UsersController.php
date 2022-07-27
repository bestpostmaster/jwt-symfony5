<?php

namespace App\Controller;

use App\Entity\User;
use App\Repository\UserRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;
use Symfony\Component\Serializer\Normalizer\DenormalizerInterface;

class UsersController extends AbstractController
{
    private UserPasswordEncoderInterface $passwordEncoder;
    private DenormalizerInterface $denormalizer;

    public function __construct(UserPasswordEncoderInterface $passwordEncoder, DenormalizerInterface $denormalizer)
    {
        $this->passwordEncoder = $passwordEncoder;
        $this->denormalizer = $denormalizer;
    }

    /**
     * @Route("/api/admin/users", name="app_users")
     */
    public function getUsers(UserRepository $userRepository): Response
    {
        return $this->json($userRepository->findAll(), 200, [], ['groups' => 'user:read']);
    }

    /**
     * @Route("/api/admin/user/{userId}", name="app_user_infos")
     */
    public function getUserInfos(Request $request, UserRepository $userRepository): Response
    {
        if(!$this->container->get('security.authorization_checker')->isGranted('ROLE_ADMIN')) {
            throw new \Exception('Admin only !');
        }

        $result = $userRepository->findOneBy(['id'=>$request->get('userId')]);
        if(!$result) {
            throw $this->createNotFoundException('Unknown user id : '.$request->get('userId'));
        }

        return $this->json($result, 200, [], ['groups' => 'user:read']);
    }

    /**
     * @Route("/api/admin/edit-user/{userId}", name="edit_user")
     * @throws \Symfony\Component\Serializer\Exception\ExceptionInterface
     */
    public function editUserInfos(Request $request, UserRepository $userRepository): Response
    {
        if(!$this->container->get('security.authorization_checker')->isGranted('ROLE_ADMIN')) {
            throw new \Exception('Admin only !');
        }

        $user = $userRepository->findOneBy(['id'=>$request->get('userId')]);
        if(!$user) {
            throw $this->createNotFoundException('Unknown user id : '.$request->get('userId'));
        }

        $user = $this->hydrateUser($request, $user);
        $em = $this->getDoctrine()->getManager();
        $em->persist($user);
        $em->flush();

        return $this->json($user, 200, [], ['groups' => 'user:read']);
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

    /**
     * @param Request $request
     * @param User $user
     * @return void
     */
    public function hydrateUser(Request $request, User $user): User
    {
        $data = json_decode($request->getContent(), true);
        empty($data['email']) ? true : $user->setEmail($data['email']);
        empty($data['login']) ? true : $user->setLogin($data['login']);
        empty($data['roles']) ? true : $user->setRoles($data['roles']);

        empty($data['password']) ? true : $user->setPassword($this->passwordEncoder->encodePassword($user,
            $data['password']
        ));

        empty($data['totalSpaceUsedMo']) ? true : $user->setTotalSpaceUsedMo($data['totalSpaceUsedMo']);
        empty($data['authorizedSizeMo']) ? true : $user->setAuthorizedSizeMo($data['authorizedSizeMo']);
        empty($data['phoneNumber']) ? true : $user->setPhoneNumber($data['phoneNumber']);
        empty($data['city']) ? true : $user->setCity($data['city']);
        empty($data['country']) ? true : $user->setCountry($data['country']);
        empty($data['zipCode']) ? true : $user->setZipCode($data['zipCode']);
        empty($data['preferredLanguage']) ? true : $user->setPreferredLanguage($data['preferredLanguage']);
        empty($data['typeOfAccount']) ? true : $user->setTypeOfAccount($data['typeOfAccount']);
        empty($data['description']) ? true : $user->setDescription($data['description']);
        empty($data['avatarPicture']) ? true : $user->setAvatarPicture($data['avatarPicture']);
        empty($data['dateOfBirth']) ? true : $user->setDateOfBirth($data['dateOfBirth']);
        empty($data['isBanned']) ? true : $user->setIsBanned($data['isBanned']);

        return $user;
    }
}
