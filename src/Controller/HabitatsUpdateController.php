<?php


namespace App\Controller;

use App\Entity\Habitats;
use App\Entity\HabitatsUpdate;
use App\Entity\Ouvertures;
use App\Form\HabitatsUpdateType;
use App\Repository\HabitatsRepository;
use App\Repository\HabitatsUpdateRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class HabitatsUpdateController extends AbstractController
{
    #[Route('/update/habitats', name: 'app_habitats_update')]
    public function index(HabitatsRepository $habitatsRepository): Response
    {
        $habitats = $habitatsRepository->findAll();


        return $this->render('habitats_update/index.html.twig', [
            'habitats' => $habitats,

        ]);
    }
    #[Route('/update/habitats/{id}', name: 'app_habitats_update_update')]
    public function update(
        Request $request,
        Habitats $habitat,
        EntityManagerInterface $entityManager,
        HabitatsUpdateRepository $habitatsUpdateRepository
    ): Response {

        $updates = $habitatsUpdateRepository->findBy(['habitat' => $habitat], ['createdAt' => 'DESC']);
        $habitatsUpdate = new HabitatsUpdate();
        $habitatsUpdate->setHabitat($habitat);
        $form = $this->createForm(HabitatsUpdateType::class, $habitatsUpdate);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {

            $entityManager->persist($habitatsUpdate);
            $entityManager->flush();

            return $this->redirectToRoute('app_habitats_update_update', ['id' => $habitat->getId()]);
        }

        return $this->render('habitats_update/update.html.twig', [
            'habitat' => $habitat,
            'updates' => $updates,
            'form' => $form->createView(),
        ]);
    }
}
