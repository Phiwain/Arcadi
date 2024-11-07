<?php

namespace App\Controller\Admin;

use App\Entity\User;
use Doctrine\ORM\EntityManagerInterface;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;
use EasyCorp\Bundle\EasyAdminBundle\Field\IdField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextEditorField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextField;
use EasyCorp\Bundle\EasyAdminBundle\Field\EmailField;
use EasyCorp\Bundle\EasyAdminBundle\Field\PassworField;
use EasyCorp\Bundle\EasyAdminBundle\Field\ChoiceField;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;

class UserCrudController extends AbstractCrudController
{
    private $passwordHasher;

    public function __construct(UserPasswordHasherInterface $passwordHasher)
    {
        $this->passwordHasher = $passwordHasher;
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
        if ($entityInstance->getPlainPassword()) {
            $entityInstance->setPassword(
                $this->passwordHasher->hashPassword(
                    $entityInstance,
                    $entityInstance->getPlainPassword()
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

        if ($entityInstance->getPlainPassword()) {
            $entityInstance->setPassword(
                $this->passwordHasher->hashPassword(
                    $entityInstance,
                    $entityInstance->getPlainPassword()
                )
            );
            $entityInstance->eraseCredentials();
        }

        parent::updateEntity($entityManager, $entityInstance);
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
           TextField::new('plainPassword', 'Mot de passe')
                ->onlyWhenCreating()
                ->setHelp('Laissez vide pour conserver le mot de passe actuel'),
            ChoiceField::new('roles')
                ->setChoices($roles)
                ->allowMultipleChoices(),
        ];
    }
}
