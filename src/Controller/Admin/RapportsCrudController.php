<?php

namespace App\Controller\Admin;

use App\Entity\Rapports;
use EasyCorp\Bundle\EasyAdminBundle\Config\Crud;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;
use EasyCorp\Bundle\EasyAdminBundle\Field\AssociationField;
use EasyCorp\Bundle\EasyAdminBundle\Field\DateTimeField;
use EasyCorp\Bundle\EasyAdminBundle\Field\IdField;
use EasyCorp\Bundle\EasyAdminBundle\Field\NumberField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextEditorField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextField;

class RapportsCrudController extends AbstractCrudController
{
    public static function getEntityFqcn(): string
    {
        return Rapports::class;
    }

    public function configureCrud(Crud $crud): Crud
    {
        return $crud
            ->setEntityLabelInSingular('Rapport vétérinaire')
            ->setEntityLabelInPlural('Rapports vétérinaires');
    }

    public function configureFields(string $pageName): iterable
    {
        return [
            AssociationField::new('Animal', 'Animal'),
            TextField::new('etat'),
            TextField::new('nourriture', label: 'Nourriture proposée'),
            NumberField::new('Poidsnourriture', label: 'Quantité de nourriture en gramme'),
            DatetimeField::new('datepassage', label: 'Date du dernier passage'),
            TextEditorField::new('detail', 'Détail sur l\'état de l\'animal si besoin')

        ];
    }

}
