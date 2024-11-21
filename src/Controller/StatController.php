<?php

declare(strict_types=1);

namespace App\Controller;

use App\Document\Stat;
use App\Entity\Amnial;
use Doctrine\ODM\MongoDB\DocumentManager;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class StatController extends AbstractController
{
    private DocumentManager $dm;
    private EntityManagerInterface $entityManager;

    public function __construct(DocumentManager $dm, EntityManagerInterface $entityManager)
    {
        $this->dm = $dm;
        $this->entityManager = $entityManager;
    }

    #[Route('/stats', name: 'stats_list', methods: ['GET'])]
    public function list(): JsonResponse
    {
        $stats = $this->dm->getRepository(Stat::class)->findAll();

        $data = array_map(function (Stat $stat) {
            return [
                'id' => $stat->id,
                'animal' => $stat->animal,
                'count' => $stat->count,
            ];
        }, $stats);

        return new JsonResponse($data);
    }

    #[Route('/stats/update', name: 'stats_update', methods: ['POST'])]
    public function update(Request $request): JsonResponse
    {
        $data = json_decode($request->getContent(), true);

        // Vérification de la validité des données
        if (!isset($data['animal']) || empty($data['animal'])) {
            return new JsonResponse(['error' => 'Invalid data: animal name is required'], Response::HTTP_BAD_REQUEST);
        }

        $animalName = $data['animal'];

        // Vérifier si l'animal existe dans la base de données relationnelle
        $animal = $this->entityManager->getRepository(Amnial::class)->findOneBy(['nom' => $animalName]);

        if (!$animal) {
            return new JsonResponse(['error' => 'Animal not found'], Response::HTTP_NOT_FOUND);
        }

        // Recherche ou création dans la collection "stats" (MongoDB)
        $stat = $this->dm->getRepository(Stat::class)->findOneBy(['animal' => $animalName]);

        if ($stat) {
            // Si l'animal existe dans les stats, incrémentez le count
            $stat->count++;
        } else {
            // Sinon, créez un nouveau document Stat
            $stat = new Stat();
            $stat->animal = $animalName;
            $stat->count = 1;

            $this->dm->persist($stat);
        }

        // Sauvegarder les modifications dans MongoDB
        $this->dm->flush();

        return new JsonResponse([
            'message' => 'Stat updated successfully',
            'id' => $stat->id,
            'animal' => $stat->animal,
            'count' => $stat->count,
        ]);
    }
}
