<?php

// src/Controller/AdminController.php

namespace App\Controller;

use App\Entity\Amnial;
use App\Entity\Animaux;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Redis ;




class AnimauxCompteurController extends AbstractController
{
    private $entityManager;
    private $redis;

    public function __construct(EntityManagerInterface $entityManager, Redis $redis)
    {
        $this->entityManager = $entityManager;

    }

    #[Route('/admin/stats', name: 'admin_stats')]
    public function stats(): Response
    {
        $animals = $this->entityManager->getRepository(Amnial::class)->findAll();
        $totalViews = 0;

        foreach ($animals as $animal) {
            $views = $this->redis->get('animal:' . $animal->getId() . ':views');
            $animal->setViews($views ?: 0);
            $totalViews += $animal->getViews();
        }

        return $this->render('animaux_compteur/index.html.twig', [
            'animals' => $animals,
            'totalViews' => $totalViews,
        ]);
    }}
