<?php


namespace App\Controller;

use App\Entity\Avis;
use App\Form\AvisType;
use App\Form\ContactType;
use App\Model\ContactMessage;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bridge\Twig\Mime\TemplatedEmail;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Mailer\MailerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Mime\Address;
use Symfony\Component\Routing\Annotation\Route;

class ContactController extends AbstractController
{
    #[Route('/contact', name: 'app_contact')]
    public function contact(
        Request $request,
        MailerInterface $mailer,
        EntityManagerInterface $entityManager
    ) {
        // Formulaire de contact
        $contactMessage = new ContactMessage();
        $contactForm = $this->createForm(ContactType::class, $contactMessage);
        $contactForm->handleRequest($request);

        // Formulaire d'avis
        $avis = new Avis();
        $avisForm = $this->createForm(AvisType::class, $avis);
        $avisForm->handleRequest($request);

        // Vérifier quel formulaire a été soumis
        if ($contactForm->isSubmitted() && $contactForm->isValid()) {
            $email = (new TemplatedEmail())
                ->from(new Address($contactMessage->getEmail()))
                ->to('contact@zooarcadia.fr') // Remplacez ici avec l'adresse du zoo
                ->subject($contactMessage->getTitreDemande())
                ->htmlTemplate('emails/contact.html.twig')
                ->context([
                    'subject' => $contactMessage->getTitreDemande(),
                    'message' => $contactMessage->getMessage(),
                    'userEmail' => $contactMessage->getEmail(), // Utilisez 'userEmail' au lieu de 'email'
                ]);

            $mailer->send($email);

            $this->addFlash('success', 'Votre message a été envoyé avec succès.');
            return $this->redirectToRoute('app_contact');
        }




        if ($avisForm->isSubmitted() && $avisForm->isValid()) {
            $avis->setIsPublished(false);

            $entityManager->persist($avis);
            $entityManager->flush();

            $this->addFlash('success', 'Votre avis a été soumis avec succès.');

            return $this->redirectToRoute('app_contact');
        }

        return $this->render('contact/index.html.twig', [
            'contactForm' => $contactForm->createView(),
            'avisForm' => $avisForm->createView(),
        ]);
    }
}
