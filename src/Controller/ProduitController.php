<?php

namespace App\Controller;

use App\Entity\Produit;
use App\Repository\ProduitRepository;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Serializer\SerializerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;


class ProduitController extends AbstractController
{
    
    #[Route('/legumes', name: 'legumes_list')]
public function getLegumesList(ProduitRepository $produitRepository): JsonResponse
{
    $legumes = $produitRepository->findBy(['typeProduit' => 'Légumes'], ['nomProduit' => 'ASC']);
    
    // Créez un tableau associatif pour stocker les noms, les prix et les images des produits de la catégorie "Légumes"
    $produitsLegumes = [];
    
    // Parcourez les produits de la catégorie "Légumes" et ajoutez leurs noms, prix et images au tableau
    foreach ($legumes as $legume) {
        $produitsLegumes[] = [
            'nomProduit' => $legume->getNomProduit(),
            'prixProduit' => $legume->getPrixProduit(),
            'imageProduit' => $legume->getImageProduit(), // Assurez-vous que la méthode getImageProduit() existe
            'idProduit' => $legume->getId(),
            'typeProduit' => $legume->getTypeProduit()
        ];
    }

    return new JsonResponse($produitsLegumes);
}


#[Route('/boissons', name: 'boissons_list')]
public function getBoissonsList(ProduitRepository $produitRepository): JsonResponse
{
    $boissons = $produitRepository->findBy(['typeProduit' => 'Boisson'], ['nomProduit' => 'ASC']);
    
    // Créez un tableau associatif pour stocker les noms, les prix et les images des produits de la catégorie "Boissons"
    $produitsBoissons = [];
    
    // Parcourez les produits de la catégorie "Boissons" et ajoutez leurs noms, prix et images au tableau
    foreach ($boissons as $boisson) {
        $produitsBoissons[] = [
            'nomProduit' => $boisson->getNomProduit(),
            'prixProduit' => $boisson->getPrixProduit(),
            'imageProduit' => $boisson->getImageProduit(), // Assurez-vous que la méthode getImageProduit() existe
            'idProduit' => $boisson->getId(),
            'typeProduit' => $boisson->getTypeProduit()
        ];
    }

    return new JsonResponse($produitsBoissons);
}

    
    #[Route('/fruits', name: 'fruits_list')]
public function getFruitsList(ProduitRepository $produitRepository): JsonResponse
{
    $fruits = $produitRepository->findBy(['typeProduit' => 'Fruits'], ['nomProduit' => 'ASC']);
    
    // Créez un tableau associatif pour stocker les noms, les prix et les images des produits de la catégorie "Fruits"
    $produitsFruits = [];
    
    // Parcourez les produits de la catégorie "Fruits" et ajoutez leurs noms, prix et images au tableau
    foreach ($fruits as $fruit) {
        $produitsFruits[] = [
            'nomProduit' => $fruit->getNomProduit(),
            'prixProduit' => $fruit->getPrixProduit(),
            'imageProduit' => $fruit->getImageProduit(), // Assurez-vous que la méthode getImageProduit() existe
            'idProduit' => $fruit->getId(),
            'typeProduit' => $fruit->getTypeProduit()
        ];
    }

    return new JsonResponse($produitsFruits);
}


    #[Route('/epicerie', name: 'epicerie_list')]
    public function getEpicerieList(ProduitRepository $produitRepository): JsonResponse
    {
        $epiceries = $produitRepository->findBy(['typeProduit' => 'Epicerie'], ['nomProduit' => 'ASC']);
        
        // Créez un tableau associatif pour stocker les noms, les prix et les images des produits d'épicerie
        $produitsEpicerie = [];
        
        // Parcourez les produits d'épicerie et ajoutez leurs noms, prix et images au tableau
        foreach ($epiceries as $epicerie) {
            $produitsEpicerie[] = [
                'nomProduit' => $epicerie->getNomProduit(),
                'prixProduit' => $epicerie->getPrixProduit(),
                'imageProduit' => $epicerie->getImageProduit(), // Assurez-vous que la méthode getImageProduit() existe
                'idProduit' => $epicerie->getId(),
                'typeProduit' => $epicerie->getTypeProduit()
            ];
        }
    
        return new JsonResponse($produitsEpicerie);
    }
    


    #[Route('/frais', name: 'frais_list')]
    public function getFraisList(ProduitRepository $produitRepository): JsonResponse
    {
        $frais = $produitRepository->findBy(['typeProduit' => 'Produits frais'], ['nomProduit' => 'ASC']);
        
        // Créez un tableau associatif pour stocker les noms, les prix et les images
        $produitsFrais = [];
        
        // Parcourez les produits frais et ajoutez leurs noms, prix et images au tableau
        foreach ($frais as $frai) {
            $produitsFrais[] = [
                'nomProduit' => $frai->getNomProduit(),
                'prixProduit' => $frai->getPrixProduit(),
                'imageProduit' => $frai->getImageProduit(), // Assurez-vous que la méthode getImageProduit() existe
                'idProduit' => $frai->getId(),
                'typeProduit' => $frai->getTypeProduit()
            ];
        }

        return new JsonResponse($produitsFrais);

    }

    #[Route('/produit', name: 'app_produit')]
public function getPProduitList(ProduitRepository $produitRepository): JsonResponse
{
    // Récupérer la liste de tous les produits depuis la table "Produit"
    $produits = $produitRepository->findAll();

    // Créez un tableau associatif pour stocker les données de chaque produit
    $produitsArray = [];

    // Parcourez les produits et ajoutez leurs données au tableau
    foreach ($produits as $produit) {
        $produitsArray[] = [
            'idProduit' => $produit->getId(),
            'nomProduit' => $produit->getNomProduit(),
            'prixProduit' => $produit->getPrixProduit(),
            'imageProduit' => $produit->getImageProduit(),
            'typeProduit' => $produit->getTypeProduit(),
        ];
    }

    return new JsonResponse($produitsArray);
}

/**
     * @Route("/produit/{id}", name="get_product")
     */
    public function getProduct($id, ProduitRepository $produitRepository): JsonResponse
    {
        $produit = $produitRepository->find($id);

        if (!$produit) {
            // Gérez ici le cas où le produit n'est pas trouvé (par exemple, renvoyez une erreur 404)
            return new JsonResponse(['message' => 'Produit non trouvé'], 404);
        }

        // Construisez un tableau avec les caractéristiques du produit
        $produitData = [
            'idProduit' => $produit->getId(),
            'nomProduit' => $produit->getNomProduit(),
            'prixProduit' => $produit->getPrixProduit(),
            'imageProduit' => $produit->getImageProduit(),
            'typeProduit' => $produit->getTypeProduit(),
        ];

        return new JsonResponse($produitData);
    }

    // #[Route('/produit/{type}',name:"app_type_produit",methods:['GET'])]
    // public function getProduitsByType(string $type, ProduitRepository $produitRepository): JsonResponse{

    //     $produits = $produitRepository->findBy(['typeProduit' => $type]);

    //     return $this->json($produits, Response::HTTP_OK, [], ['groups' => 'getPaniers']);
    // }


    
}