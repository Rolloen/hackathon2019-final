<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\JsonResponse;
use Doctrine\Common\Persistence\ObjectManager;
use App\Entity\User;

class UserController extends AbstractController
{
    /**
     * @Route("/user/get-user", name="_getUser", methods="GET")
     * Exemple : /user/get-user?mail=XXXXX&password=XXXXX
     * Return jsonUser
     */
    public function getUserToFront(Request $request, ObjectManager $objectManager)
    {
        $mail = $request->query->get('mail');
        $password = $request->query->get('password');
        $arrayToJson = array();

        $user = $objectManager->getRepository(User::class)->findOneBy([
            'mail' => $mail,
            'md5_password' => $password,
            ]);

        if (!empty($user))
        {
            $arrayToJson += ['responseUser' => 1];

            $arrayToJson += ['mail' => $user->getMail()];
            $arrayToJson += ['nom' => $user->getNom()];
            $arrayToJson += ['prenom' => $user->getPrenom()];
            $arrayToJson += ['privilege' => $user->getPrivilege()];
        }
        else{
            $arrayToJson += ['responseUser' => 0];
            $arrayToJson += ['Error' => 'User not found'];
        }

        $json_user = json_encode($arrayToJson);

        return JsonResponse::fromJsonString($json_user);
    }
}