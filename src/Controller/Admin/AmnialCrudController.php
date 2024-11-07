<?php

namespace App\Controller\Admin;

use App\Entity\Amnial;
use EasyCorp\Bundle\EasyAdminBundle\Config\Crud;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;
use EasyCorp\Bundle\EasyAdminBundle\Field\AssociationField;
use EasyCorp\Bundle\EasyAdminBundle\Field\ImageField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextField;

class AmnialCrudController extends AbstractCrudController
{
    public static function getEntityFqcn(): string
    {
        return Amnial::class;
    }
    public function configureCrud(Crud $crud): Crud
    {
        return $crud
            ->setEntityLabelInSingular('Animal')
            ->setEntityLabelInPlural('Animaux');
    }

    public function configureFields(string $pageName): iterable
    {
        return [
            TextField::new('nom'),
            AssociationField::new('race'),
            AssociationField::new('habitat'),
            ImageField::new('illustration')
                ->setBasePath('/uploads/images/animaux')
                ->setUploadDir('public/uploads/images/animaux')
                ->setUploadedFileNamePattern('[randomhash].[extension]')
                ->setRequired(false),

        ];
}

}