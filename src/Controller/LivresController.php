<?php

namespace App\Controller;

use App\Entity\Livres;
use App\Repository\LivresRepository;
use App\Repository\AuteursRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Serializer\SerializerInterface;
use Symfony\Component\Routing\Generator\UrlGeneratorInterface;
use Symfony\Component\Serializer\Normalizer\AbstractNormalizer;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class LivresController extends AbstractController
{
    #[Route('/api/livres', name: 'app_livres', methods: ['GET'])]
    public function getBookList(LivresRepository $livresRepository, SerializerInterface $serializer): JsonResponse
    {
        $livresListe = $livresRepository->findAll();

        $jsonLivresListe = $serializer->serialize($livresListe, 'json', ['groups' => 'getLivres']);

        return new JsonResponse($jsonLivresListe, Response::HTTP_OK, [], true);

    }

    #[Route('/api/livres/{id}', name: 'app_livres_show', methods: ['GET'])]
    public function getDetailBook( int $id, LivresRepository $livresRepository, SerializerInterface $serializer): JsonResponse
    {
        $livre = $livresRepository->find($id);
        if ($livre) {
            $jsonBook = $serializer->serialize($livre, 'json', ['groups' => 'getLivres']);
            return new JsonResponse($jsonBook, Response::HTTP_OK, [], true);
        }
        return new JsonResponse(null, Response::HTTP_NOT_FOUND);
    }

    #[Route('/api/livres/{id}', name: 'delete_livre', methods: ['DELETE'])]
    public function deleteBook(Livres $livre, EntityManagerInterface $em): JsonResponse 
    {
        $em->remove($livre);
        $em->flush();

        return new JsonResponse(null, Response::HTTP_NO_CONTENT);
    }

    #[Route('/api/livres', name:"createLivre", methods: ['POST'])]
    public function createLivre(Request $request, AuteursRepository $auteursRepository, SerializerInterface $serializer, EntityManagerInterface $em, UrlGeneratorInterface $urlGenerator): JsonResponse 
    {

        $livre = $serializer->deserialize($request->getContent(), Livres::class, 'json');

        $content = $request->toArray();

        $idAuteur = $content['idAuteur'] ?? -1;

        $livre->setAuteur($auteursRepository->find($idAuteur));

        $em->persist($livre);
        $em->flush();

        $jsonLivre = $serializer->serialize($livre, 'json', ['groups' => 'getLivres']);
        
        $location = $urlGenerator->generate('app_livres_show', ['id' => $livre->getId()], UrlGeneratorInterface::ABSOLUTE_URL);

        return new JsonResponse($jsonLivre, Response::HTTP_CREATED, ["Location" => $location], true);
   }

   #[Route('/api/livres/{id}', name:"updateLivre", methods:['PUT'])]

    public function updateLivre(Request $request, SerializerInterface $serializer, Livres $currentLivre, EntityManagerInterface $em, AuteursRepository $auteursRepository): JsonResponse 
    {
        $updatedLivre = $serializer->deserialize($request->getContent(), 
                Livres::class, 
                'json', 
                [AbstractNormalizer::OBJECT_TO_POPULATE => $currentLivre]);
        $content = $request->toArray();
        $idAuteur = $content['idAuteur'] ?? -1;
        $updatedLivre->setAuteur($auteursRepository->find($idAuteur));
        
        $em->persist($updatedLivre);
        $em->flush();
        return new JsonResponse(null, JsonResponse::HTTP_NO_CONTENT);
   }

}
