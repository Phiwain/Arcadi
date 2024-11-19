<?php
namespace App\Controller\Admin;

use App\Entity\User;
use Doctrine\ORM\EntityManagerInterface;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;
use EasyCorp\Bundle\EasyAdminBundle\Field\IdField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextField;
use EasyCorp\Bundle\EasyAdminBundle\Field\EmailField;
use EasyCorp\Bundle\EasyAdminBundle\Field\ChoiceField;
use Symfony\Component\HttpFoundation\RequestStack;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\Mailer\MailerInterface;
use Symfony\Component\Mime\Email;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;

class UserCrudController extends AbstractCrudController
{
    private $passwordHasher;
    private $mailer;
    private $requestStack;

    public function __construct(UserPasswordHasherInterface $passwordHasher, MailerInterface $mailer, RequestStack $requestStack)
    {
        $this->passwordHasher = $passwordHasher;
        $this->mailer = $mailer;
        $this->requestStack = $requestStack;
    }

    public static function getEntityFqcn(): string
    {
        return User::class;
    }

    public function persistEntity(EntityManagerInterface $entityManager, $entityInstance): void
    {
        if (!$entityInstance instanceof User) {
            return;
        }


        $password = $entityInstance->getPassword();


        if (strlen($password) < 10 || !preg_match('/[!@#$%^&*(),.?":{}|<>]/', $password)) {
            $this->addFlash('danger', 'Le mot de passe doit contenir au moins 10 caractères et inclure un caractère spécial.');


            $request = $this->requestStack->getCurrentRequest();
            $referer = $request->headers->get('referer');
            $this->requestStack->getSession()->save();
            header("Location: $referer");
            exit();
        }


        $entityInstance->setPassword(
            $this->passwordHasher->hashPassword(
                $entityInstance,
                $password
            )
        );

        $entityInstance->eraseCredentials();

        // Envoyer l'email de bienvenue
        $this->sendWelcomeEmail($entityInstance);

        parent::persistEntity($entityManager, $entityInstance);
    }

    private function sendWelcomeEmail(User $user): void
    {
        $email = (new Email())
            ->from('admin@example.com')
            ->to($user->getEmail())
            ->subject('Bienvenue sur notre plateforme')
            ->html('<p>Bonjour ' . htmlspecialchars($user->getNom()) . ',</p><p>Bienvenue sur notre plateforme !</p>');

        $this->mailer->send($email);
    }

    public function configureFields(string $pageName): iterable
    {
        $roles = ['Soigneur' => 'ROLE_SOIGNEUR', 'Vétérinaire' => 'ROLE_VETERINAIRE'];

        return [
            IdField::new('id')->onlyOnIndex(),
            EmailField::new('email'),
            TextField::new('nom'),
            TextField::new('prenom'),
            TextField::new('password', 'Mot de passe')
                ->onlyWhenCreating()
                ->setFormTypeOption('attr', ['type' => 'password'])
                ->setHelp('Doit contenir au moins 10 caractères et un caractère spécial'),
            ChoiceField::new('roles')
                ->setChoices($roles)
                ->allowMultipleChoices(),
        ];
    }
}

