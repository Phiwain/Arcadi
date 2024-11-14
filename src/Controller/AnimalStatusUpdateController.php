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
    #[Route('/animal/status', name: 'app_animal_status')]
    public function index(EntityManagerInterface $entityManager): Response
    {
        // Récupérer tous les animaux
        $animals = $entityManager->getRepository(Amnial::class)->findAll();

        // Afficher la liste des animaux
        return $this->render('animal_status_update/index.html.twig', [
            'animals' => $animals,
        ]);
    }

    #[Route('/animal/status/update/{id}', name: 'app_animal_status_update')]
    public function update(int $id, Request $request, EntityManagerInterface $entityManager): Response
    {
        // Récupérer l'animal spécifique
        $animal = $entityManager->getRepository(Amnial::class)->find($id);

        if (!$animal) {
            throw $this->createNotFoundException('Animal non trouvé.');
        }

        // Récupérer l'historique des mises à jour pour cet animal
        $animalUpdates = $entityManager->getRepository(AnimalUpdate::class)->findBy(
            ['Animal' => $animal],
            ['Date' => 'DESC', 'Time' => 'DESC'] // Trier par date et heure décroissante
        );

        // Créer une nouvelle instance de AnimalUpdate pour enregistrer cette mise à jour
        $animalUpdate = new AnimalUpdate();
        $animalUpdate->setAnimal($animal); // Lier la mise à jour à l'animal

        // Créer le formulaire et le lier à AnimalUpdate
        $form = $this->createForm(AnimalStatusUpdateType::class, $animalUpdate);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            // Enregistrer la mise à jour dans la base de données
            $entityManager->persist($animalUpdate);
            $entityManager->flush();

            $this->addFlash('success', 'Informations de l\'animal mises à jour avec succès.');
            return $this->redirectToRoute('app_animal_status');
        }

        // Passer le formulaire, le nom de l'animal et l'historique au template
        return $this->render('animal_status_update/update.html.twig', [
            'form' => $form->createView(),
            'animal_name' => $animal->getNom(),
            'animal_updates' => $animalUpdates,
        ]);
    }

}
