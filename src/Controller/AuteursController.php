<?php

namespace App\Controller;

use App\Repository\AuteursRepository;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Serializer\SerializerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class AuteursController extends AbstractController
{
    #[Route('/api/auteurs', name: 'app_auteurs', methods: ['GET'])]
    public function getBookList(AuteursRepository $auteursRepository, SerializerInterface $serializer): JsonResponse
    {
        $auteursListe = $auteursRepository->findAll();

        $jsonAuteursListe = $serializer->serialize($auteursListe, 'json', ['groups' => 'getAuteurs']);

        return new JsonResponse($jsonAuteursListe, Response::HTTP_OK, [], true);

    }

    #[Route('/api/auteurs/{id}', name: 'app_auteurs_show', methods: ['GET'])]
    public function getDetailBook( int $id, AuteursRepository $auteursRepository, SerializerInterface $serializer): JsonResponse
    {
        $auteur = $auteursRepository->find($id);
        if ($auteur) {
            $jsonBook = $serializer->serialize($auteur, 'json', ['groups' => 'getAuteurs']);
            return new JsonResponse($jsonBook, Response::HTTP_OK, [], true);
        }
        return new JsonResponse(null, Response::HTTP_NOT_FOUND);
    }
}
