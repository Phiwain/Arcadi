<?php

namespace App\Form;

use App\Entity\AnimalUpdate;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\Extension\Core\Type\NumberType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\TimeType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class AnimalStatusUpdateType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('Date', DateType::class, [
                'widget' => 'single_text',
                'label' => 'Date de mise à jour',
            ])
            ->add('Time', TimeType::class, [
                'widget' => 'single_text',
                'label' => 'Heure de mise à jour',
            ])
            ->add('QuantiteNourriture', NumberType::class, [
                'label' => 'Quantité de Nourriture (kg)',
            ])
            ->add('Nourriture', TextType::class, [
                'label' => 'Type de Nourriture',
            ]);
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => AnimalUpdate::class,
        ]);
    }
}
