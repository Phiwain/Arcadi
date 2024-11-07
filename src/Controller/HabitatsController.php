<?php

namespace App\Controller;

use App\Entity\Amnial;
use App\Entity\Habitats;
use App\Entity\Rapports;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

class HabitatsController extends AbstractController
{
    private $entityManager;

    public function __construct(EntityManagerInterface $entityManager){
        $this->entityManager = $entityManager;
    }
    #[Route('/habitats', name: 'app_habitats')]
    public function index(): Response
    {
        $habitats=$this->entityManager->getRepository(Habitats::class)->findAll();
        $animaux=$this->entityManager->getRepository(Amnial::class)->findAll();
        $rapports=$this->entityManager->getRepository(Rapports::class)->findAll();

        return $this->render('habitats/index.html.twig', [
            'habitats' => $habitats,
            'animaux' => $animaux,
            'rapports' => $rapports,
        ]);
    }
}
