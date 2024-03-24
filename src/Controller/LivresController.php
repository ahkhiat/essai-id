<?php

namespace App\Controller;

use App\Repository\LivresRepository;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Serializer\SerializerInterface;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class LivresController extends AbstractController
{
    #[Route('/api/livres', name: 'app_livres', methods: ['GET'])]
    public function getBookList(LivresRepository $livresRepository, SerializerInterface $serializer): JsonResponse
    {
        $livresListe = $livresRepository->findAll();

        $jsonLivresListe = $serializer->serialize($livresListe, 'json');

        return new JsonResponse($jsonLivresListe, Response::HTTP_OK, [], true);

    }

    #[Route('/api/livres/{id}', name: 'app_livres_show', methods: ['GET'])]
    public function getDetailBook( int $id, LivresRepository $livresRepository, SerializerInterface $serializer): JsonResponse
    {
        $livre = $livresRepository->find($id);
        if ($livre) {
            $jsonBook = $serializer->serialize($livre, 'json');
            return new JsonResponse($jsonBook, Response::HTTP_OK, [], true);
        }
        return new JsonResponse(null, Response::HTTP_NOT_FOUND);
    }

}
