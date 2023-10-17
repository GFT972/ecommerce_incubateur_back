<?php

namespace App\Controller;

use App\Entity\User;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Serializer\SerializerInterface;
use Symfony\Component\Security\Http\Attribute\IsGranted;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class UserController extends AbstractController
{
    #[Route('/api/user/{id}',name:"app_detail_user",methods:['GET'])]
    #[IsGranted('ROLE_USER', message: 'Vous n\'avez pas les droits suffisants')]

    public function getDetailPanier(User $user, SerializerInterface $serializer): JsonResponse
    {
        if ($user !== $this->getUser()) {
            throw $this->createAccessDeniedException('Vous n\'avez pas le droit d\'accéder à ces données.');
        }
        $jsonUser = $serializer->serialize($user,'json', ['groups' => 'getPanier']);
        return new JsonResponse($jsonUser, Response::HTTP_OK,['accept'=>'json'],true);
    }
    
}