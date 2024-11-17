<?php

namespace App\Controller;

use App\Entity\Ouvertures;
use App\Entity\Service;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

class ServiceController extends AbstractController
{

    private $entityManager;

    public function __construct(EntityManagerInterface $entityManager){
        $this->entityManager = $entityManager;
    }
    #[Route('/services', name: 'app_services')]
    public function index(): Response
    {
        $services=$this->entityManager->getRepository(Service::class)->findAll();
        $openings=$this->entityManager->getRepository(Ouvertures::class)->findAll();
        return $this->render('service/index.html.twig',[
            'services'=>$services,
            'openings'=>$openings
        ]);
    }
}
