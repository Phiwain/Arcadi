<?php

namespace App\Controller\Admin;

use App\Entity\User;
use Doctrine\ORM\EntityManagerInterface;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;
use EasyCorp\Bundle\EasyAdminBundle\Field\IdField;
use EasyCorp\Bundle\EasyAdminBundle\Field\PasswordField;

use EasyCorp\Bundle\EasyAdminBundle\Field\TextEditorField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextField;
use EasyCorp\Bundle\EasyAdminBundle\Field\EmailField;
use EasyCorp\Bundle\EasyAdminBundle\Field\PassworField;
use EasyCorp\Bundle\EasyAdminBundle\Field\ChoiceField;
use Symfony\Component\Mailer\MailerInterface;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;

class UserCrudController extends AbstractCrudController
{
    private $passwordHasher;
    private $mailer;

    public function __construct(UserPasswordHasherInterface $passwordHasher, MailerInterface $mailer)
    {
        $this->passwordHasher = $passwordHasher;
        $this->mailer = $mailer;
    }
    public static function getEntityFqcn(): string
    {

        return User::class;
    }
    public function persistEntity(EntityManagerInterface $entityManager, $entityInstance): void
    {
        // Vérifiez que l'entité est une instance de User
        if (!$entityInstance instanceof User) {
            return;
        }

        // Encoder le mot de passe si le plainPassword est défini
        if ($entityInstance->getPassword()) {
            $entityInstance->setPassword(
                $this->passwordHasher->hashPassword(
                    $entityInstance,
                    $entityInstance->getPassword()
                )
            );
            $entityInstance->eraseCredentials();
        }

        // Envoyer un email ici si nécessaire

        parent::persistEntity($entityManager, $entityInstance);
    }

    public function updateEntity(EntityManagerInterface $entityManager, $entityInstance): void
    {
        // Même logique que persistEntity
        if (!$entityInstance instanceof User) {
            return;
        }

        if ($entityInstance->getPassword()) {
            $entityInstance->setPassword(
                $this->passwordHasher->hashPassword(
                    $entityInstance,
                    $entityInstance->getPassword()
                )
            );
            $entityInstance->eraseCredentials();
        }

        parent::updateEntity($entityManager, $entityInstance);
    }




    private function sendWelcomeEmail(User $user): void
    {
        $email = (new Email())
            ->from('admin@example.com')
            ->to($user->getEmail())
            ->subject('Bienvenue sur notre plateforme')
            ->html('<p>Bonjour ' . htmlspecialchars($user->getNom()) . ',</p><p>Bienvenue sur notre plateforme !</p>');

        // Envoyer l'email
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
            // Utilisez PasswordField pour le mot de passe

            TextField::new('Password', 'Mot de passe')
                ->onlyWhenCreating()
                ->setHelp('Laissez vide pour conserver le mot de passe actuel'),
            ChoiceField::new('roles')
                ->setChoices($roles)
                ->allowMultipleChoices(),
        ];
    }
}
