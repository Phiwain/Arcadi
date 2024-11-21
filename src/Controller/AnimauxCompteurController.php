<?php

// src/Controller/AdminController.php

namespace App\Controller;

use App\Document\Stat;
use App\Entity\Animaux;
use Doctrine\ODM\MongoDB\DocumentManager;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;




class AnimauxCompteurController extends AbstractController
{
    private $entityManager;
    private $redis;

    public function __construct(DocumentManager $dm, EntityManagerInterface $entityManager)
    {
        $this->dm = $dm;
        $this->entityManager = $entityManager;
    }

    #[Route('/admin/stats', name: 'admin_stats')]
    public function stats(): Response
    {
        // Récupérer les statistiques depuis MongoDB
        $stats = $this->dm->getRepository(Stat::class)->findAll();

        // Calculer le total des vues et formater les données
        $totalViews = 0;
        $animals = [];

        foreach ($stats as $stat) {
            $totalViews += $stat->count;

            $animals[] = [
                'nom' => $stat->animal,
                'views' => $stat->count,
            ];
        }

        // Trier les animaux par nombre de vues en ordre croissant
        usort($animals, function ($a, $b) {
            return $b['views'] <=> $a['views'];
        });

        // Passer les données à la vue Twig
        return $this->render('animaux_compteur/index.html.twig', [
            'animals' => $animals,
            'totalViews' => $totalViews,
        ]);
    }


}
