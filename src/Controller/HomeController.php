<?php

namespace App\Controller;

use App\Entity\Avis;
use App\Entity\Habitats;
use App\Entity\Service;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

class HomeController extends AbstractController
{
    private $entityManager;

    public function __construct(EntityManagerInterface $entityManager){
        $this->entityManager = $entityManager;
    }
    #[Route('/', name: 'app_home')]
    public function index(): Response
    {
        $services=$this->entityManager->getRepository(Service::class)->findAll();
        $habitats=$this->entityManager->getRepository(Habitats::class)->findAll();
        $avis=$this->entityManager->getRepository(Avis::class)->findAll();
        return $this->render('home/index.html.twig',[
            'services'=>$services,
            'habitats'=>$habitats,
            'avis'=>$avis
        ]);
    }
}
