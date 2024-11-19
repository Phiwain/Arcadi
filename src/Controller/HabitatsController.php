<?php

namespace App\Controller;

use App\Entity\Habitats;
use App\Entity\Ouvertures;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class HabitatsController extends AbstractController
{
    private $entityManager;

    public function __construct(EntityManagerInterface $entityManager){
        $this->entityManager = $entityManager;
    }

    #[Route('/habitats', name: 'app_habitats')]
    public function index(): Response
    {
        $habitats = $this->entityManager->getRepository(Habitats::class)->findAll();
        $openings=$this->entityManager->getRepository(Ouvertures::class)->findAll();

        return $this->render('habitats/index.html.twig', [
            'habitats' => $habitats,
            'openings' => $openings,
        ]);
    }


}
