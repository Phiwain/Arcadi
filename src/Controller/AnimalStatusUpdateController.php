<?php

namespace App\Controller;

use App\Entity\Amnial;
use App\Entity\AnimalUpdate;
use App\Form\AnimalStatusUpdateType;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class AnimalStatusUpdateController extends AbstractController
{
    #[Route('/update/animal/status', name: 'app_animal_status')]
    public function index(EntityManagerInterface $entityManager): Response
    {
        $animals = $entityManager->getRepository(Amnial::class)->findAll();

        return $this->render('animal_status_update/index.html.twig', [
            'animals' => $animals,
        ]);
    }

    #[Route('/update/animal/status/{id}', name: 'app_animal_status_update')]
    public function update(int $id, Request $request, EntityManagerInterface $entityManager): Response
    {
        $animal = $entityManager->getRepository(Amnial::class)->find($id);

        if (!$animal) {
            throw $this->createNotFoundException('Animal non trouvé.');
        }

        $animalUpdates = $entityManager->getRepository(AnimalUpdate::class)->findBy(
            ['Animal' => $animal],
            ['Date' => 'DESC', 'Time' => 'DESC']
        );

        $animalUpdate = new AnimalUpdate();
        $animalUpdate->setAnimal($animal);

        $form = $this->createForm(AnimalStatusUpdateType::class, $animalUpdate);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {

            $entityManager->persist($animalUpdate);
            $entityManager->flush();

            $this->addFlash('success', 'Informations de l\'animal mises à jour avec succès.');
            return $this->redirectToRoute('app_animal_status');
        }


        return $this->render('animal_status_update/update.html.twig', [
            'form' => $form->createView(),
            'animal_name' => $animal->getNom(),
            'animal_updates' => $animalUpdates,
        ]);
    }

}
