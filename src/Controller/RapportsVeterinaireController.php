<?php

namespace App\Controller;

use App\Entity\Amnial;
use App\Entity\Rapports;
use App\Form\RapportsVeterinaireType;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class RapportsVeterinaireController extends AbstractController
{
    #[Route('/rapport/status', name: 'app_rapports_status')]
    public function index(EntityManagerInterface $entityManager): Response
    {
        // Récupérer tous les animaux
        $animals = $entityManager->getRepository(Amnial::class)->findAll();

        // Afficher la liste des animaux
        return $this->render('rapports_veterinaire/index.html.twig', [
            'animals' => $animals,
        ]);
    }

    // Méthode pour mettre à jour un rapport existant
    #[Route('/rapport/status/update/{id}', name: 'app_rapports_status_update')]
    public function update(int $id, Request $request, EntityManagerInterface $entityManager): Response
    {
        // Récupérer le rapport existant
        $rapportExistant = $entityManager->getRepository(Rapports::class)->find($id);

        if (!$rapportExistant) {
            throw $this->createNotFoundException('Rapport non trouvé.');
        }

        // Créer une nouvelle instance de Rapports avec les mêmes données, sans ID
        $nouveauRapport = new Rapports();
        $nouveauRapport->setEtat($rapportExistant->getEtat());
        $nouveauRapport->setNourriture($rapportExistant->getNourriture());
        $nouveauRapport->setPoidsNourriture($rapportExistant->getPoidsNourriture());
        $nouveauRapport->setDatePassage(new \DateTime()); // Date actuelle
        $nouveauRapport->setDetail($rapportExistant->getDetail());
        $nouveauRapport->setAnimal($rapportExistant->getAnimal());
        $nouveauRapport->setPoids($rapportExistant->getPoids());

        $animal = $rapportExistant->getAnimal();

        // Récupérer tous les rapports pour cet animal
        $rapports = $entityManager->getRepository(Rapports::class)->findBy(['Animal' => $animal]);

        // Créer le formulaire et le lier au nouveau rapport
        $form = $this->createForm(RapportsVeterinaireType::class, $nouveauRapport);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            // Persister le nouveau rapport
            $entityManager->persist($nouveauRapport);
            $entityManager->flush();

            // Message de confirmation et redirection
            $this->addFlash('success', 'Rapport mis à jour avec succès.');
            return $this->redirectToRoute('app_animal_rapports_list', ['id' => $animal->getId()]);
        }

        return $this->render('rapports_veterinaire/update.html.twig', [
            'form' => $form->createView(),
            'rapport_date' => $rapportExistant->getDatePassage(),
            'rapport' => $nouveauRapport,
            'rapports' => $rapports,
            'isFirstReport' => false,
        ]);
    }

    // Méthode pour créer un nouveau rapport pour un animal
    #[Route('/rapport/status/create/{animalId}', name: 'app_rapports_status_create')]
    public function create(int $animalId, Request $request, EntityManagerInterface $entityManager): Response
    {
        $animal = $entityManager->getRepository(Amnial::class)->find($animalId);

        if (!$animal) {
            throw $this->createNotFoundException('Animal non trouvé.');
        }

        $nouveauRapport = new Rapports();
        $nouveauRapport->setAnimal($animal);
        $nouveauRapport->setDatePassage(new \DateTime());

        // Récupérer tous les rapports pour cet animal (sera vide)
        $rapports = $entityManager->getRepository(Rapports::class)->findBy(['Animal' => $animal]);

        // Créer le formulaire et le lier au nouveau rapport
        $form = $this->createForm(RapportsVeterinaireType::class, $nouveauRapport);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            // Persister le nouveau rapport
            $entityManager->persist($nouveauRapport);
            $entityManager->flush();

            // Message de confirmation et redirection
            $this->addFlash('success', 'Premier rapport créé avec succès.');
            return $this->redirectToRoute('app_animal_rapports_list', ['id' => $animal->getId()]);
        }

        return $this->render('rapports_veterinaire/update.html.twig', [
            'form' => $form->createView(),
            'rapport_date' => new \DateTime(),
            'rapport' => $nouveauRapport,
            'rapports' => $rapports,
            'isFirstReport' => true,
        ]);
    }

    #[Route('/animal/{id}/rapports', name: 'app_animal_rapports_list')]
    public function listRapports(int $id, EntityManagerInterface $entityManager): Response
    {
        // Récupérer l'animal spécifique
        $animal = $entityManager->getRepository(Amnial::class)->find($id);

        if (!$animal) {
            throw $this->createNotFoundException('Animal non trouvé.');
        }

        // Récupérer les rapports associés à cet animal
        $rapports = $entityManager->getRepository(Rapports::class)->findBy(['Animal' => $animal]);

        // Vérifier si aucun rapport n'existe
        if (empty($rapports)) {
            // Rediriger vers la page de création du premier rapport
            return $this->redirectToRoute('app_rapports_status_create', ['animalId' => $animal->getId()]);
        }

        // Passer les données au template
        return $this->render('rapports_veterinaire/list_rapports.html.twig', [
            'animal_name' => $animal->getNom(),
            'rapports' => $rapports,
            'animal_id' => $animal->getId(),
        ]);
    }

    #[Route('/rapports/all', name: 'app_all_rapports')]
    public function allRapports(EntityManagerInterface $entityManager): Response
    {
        // Récupérer tous les rapports
        $rapports = $entityManager->getRepository(Rapports::class)->findAll();

        // Récupérer tous les animaux
        $animals = $entityManager->getRepository(Amnial::class)->findAll();

        // Rendre la vue
        return $this->render('rapports_veterinaire/allrapports.html.twig', [
            'rapports' => $rapports,
            'animals' => $animals,
        ]);
    }
}
