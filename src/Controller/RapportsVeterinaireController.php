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
    #[Route('/update/rapport/status', name: 'app_rapports_status')]
    public function index(EntityManagerInterface $entityManager): Response
    {
        $animals = $entityManager->getRepository(Amnial::class)->findAll();
        return $this->render('rapports_veterinaire/index.html.twig', [
            'animals' => $animals,
        ]);
    }


    #[Route('/update/rapport/status/{id}', name: 'app_rapports_status_update')]
    public function update(int $id, Request $request, EntityManagerInterface $entityManager): Response
    {

        $rapportExistant = $entityManager->getRepository(Rapports::class)->find($id);

        if (!$rapportExistant) {
            throw $this->createNotFoundException('Rapport non trouvé.');
        }


        $nouveauRapport = new Rapports();
        $nouveauRapport->setEtat($rapportExistant->getEtat());
        $nouveauRapport->setNourriture($rapportExistant->getNourriture());
        $nouveauRapport->setPoidsNourriture($rapportExistant->getPoidsNourriture());
        $nouveauRapport->setDatePassage(new \DateTime()); // Date actuelle
        $nouveauRapport->setDetail($rapportExistant->getDetail());
        $nouveauRapport->setAnimal($rapportExistant->getAnimal());
        $nouveauRapport->setPoids($rapportExistant->getPoids());

        $animal = $rapportExistant->getAnimal();
        $rapports = $entityManager->getRepository(Rapports::class)->findBy(['Animal' => $animal]);

        $form = $this->createForm(RapportsVeterinaireType::class, $nouveauRapport);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->persist($nouveauRapport);
            $entityManager->flush();
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

    #[Route('/update/rapport/status/create/{animalId}', name: 'app_rapports_status_create')]
    public function create(int $animalId, Request $request, EntityManagerInterface $entityManager): Response
    {
        $animal = $entityManager->getRepository(Amnial::class)->find($animalId);

        if (!$animal) {
            throw $this->createNotFoundException('Animal non trouvé.');
        }

        $nouveauRapport = new Rapports();
        $nouveauRapport->setAnimal($animal);
        $nouveauRapport->setDatePassage(new \DateTime());

        $rapports = $entityManager->getRepository(Rapports::class)->findBy(['Animal' => $animal]);

        $form = $this->createForm(RapportsVeterinaireType::class, $nouveauRapport);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {

            $entityManager->persist($nouveauRapport);
            $entityManager->flush();

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

    #[Route(' /update/animal/{id}/rapports', name: 'app_animal_rapports_list')]
    public function listRapports(int $id, EntityManagerInterface $entityManager): Response
    {

        $animal = $entityManager->getRepository(Amnial::class)->find($id);

        if (!$animal) {
            throw $this->createNotFoundException('Animal non trouvé.');
        }
        $rapports = $entityManager->getRepository(Rapports::class)->findBy(['Animal' => $animal]);

        if (empty($rapports)) {

            return $this->redirectToRoute('app_rapports_status_create', ['animalId' => $animal->getId()]);
        }

        return $this->render('rapports_veterinaire/list_rapports.html.twig', [
            'animal_name' => $animal->getNom(),
            'rapports' => $rapports,
            'animal_id' => $animal->getId(),
        ]);
    }

    #[Route('/rapports/all', name: 'app_all_rapports')]
    public function allRapports(EntityManagerInterface $entityManager): Response
    {

        $rapports = $entityManager->getRepository(Rapports::class)->findAll();
        $animals = $entityManager->getRepository(Amnial::class)->findAll();

        return $this->render('rapports_veterinaire/allrapports.html.twig', [
            'rapports' => $rapports,
            'animals' => $animals,
        ]);
    }
}
