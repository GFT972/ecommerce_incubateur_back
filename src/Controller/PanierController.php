<?php

namespace App\Controller;
use App\Entity\Panier;
use App\Repository\PanierRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Serializer\SerializerInterface;
use Symfony\Component\Security\Http\Attribute\IsGranted;
use Symfony\Component\Serializer\Normalizer\AbstractNormalizer;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class PanierController extends AbstractController
{
    #[Route('/api/panier', name: 'app_panier',methods:['GET'])]
    public function getPanierList(PanierRepository $panierRepository, SerializerInterface $serializer): JsonResponse
    {
        $panierList = $panierRepository -> findAll();
        $jsonPanierList = $serializer->serialize($panierList, 'json', ['groups' => 'getPanier']);
        return new JsonResponse($jsonPanierList, Response::HTTP_OK,[], true);
    }

    #[Route('/api/panier/{id}',name:"app_detail_panier",methods:['GET'])]
    #[IsGranted('ROLE_USER', message: 'Vous n\'avez pas les droits suffisants')]
    public function getDetailPanier(Panier $panier, SerializerInterface $serializer): JsonResponse
    {

        $jsonPanier = $serializer->serialize($panier,'json', ['groups' => 'getPanier']);
        return new JsonResponse($jsonPanier, Response::HTTP_OK,['accept'=>'json'],true);
    }

    #[Route('/api/panier/{id}', name: 'delete_Panier', methods:['DELETE'])]
    public function deletePanier(Panier $panier, EntityManagerInterface $em): JsonResponse
    {
        $em->remove($panier);
        $em->flush();
        return new JsonResponse(null, Response::HTTP_NO_CONTENT);
    }

    #[Route('/api/panier/{id}', name:"update_Panier", methods:['PUT'])]
    public function updatePanier(Request $request, SerializerInterface $serializer, Panier $currentPanier, EntityManagerInterface $em): JsonResponse 
    {
        $updatedPanier = $serializer->deserialize($request->getContent(), 
                Panier::class, 
                'json', 
                [AbstractNormalizer::OBJECT_TO_POPULATE => $currentPanier]);
 
        $em->persist($updatedPanier);
        $em->flush();
        return new JsonResponse(null, JsonResponse::HTTP_NO_CONTENT);
    }

}