<?php

namespace App\Form;

use App\Entity\Rapports;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\NumberType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class RapportsVeterinaireType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('etat', TextType::class, [
                'label' => 'État de l\'animal',
            ])
            ->add('nourriture', TextType::class, [
                'label' => 'Nourriture',
            ])
            ->add('Poidsnourriture', NumberType::class, [
                'label' => 'Poids de la Nourriture (kg)',
            ])
            ->add('datepassage', DateType::class, [
                'widget' => 'single_text',
                'label' => 'Date de Passage',
            ])
            ->add('detail', TextType::class, [
                'label' => 'Détail sur l\'animal',
                'required' => false,
            ])
            ->add('Poids', NumberType::class, [
                'label' => 'Poids de l\'animal (kg)',
            ]);
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Rapports::class,
        ]);
    }
}
