<?php

namespace App\Form;

use App\Entity\User;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\PasswordType;
use Symfony\Component\Form\Extension\Core\Type\RepeatedType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class ChangePasswordType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder

            ->add('old_password', PasswordType::class, [
                'label'=> 'Mon ancien mot de passe',
                'mapped'=> false,
                'attr'=> [
                    'placeholder' => 'Veuillez saisir votre ancien mot de passe',
                    'class'=>'form-control w-50 mx-auto my-1 text-center'
                ]
            ])
            ->add('new_password',RepeatedType::class, [
                'type'=> PasswordType::class,
                'mapped'=> false,
                'invalid_message'=>'Les deux mots de passe doivent etre identiques',
                'label'=>'Votre nouveau mot de passe',
                'required'=>true,
                'first_options'=>[
                    'label'=>'Nouveau mot de passe',
                    'attr'=>['placeholder'=>'Merci de saisir votre nouveau mot de passe',
                        'class'=>'form-control w-50 mx-auto my-1 text-center']
                ],
                'second_options'=>[
                    'label'=>'Confirmez votre mot de passe',
                    'attr'=>['placeholder'=>'Confirmez votre mot de passe',
                        'class'=>'form-control w-50 mx-auto my-1 text-center']
                ]
            ])
            ->add(child: 'submit',type: SubmitType::class,options: [
                'label'=>"Mettre à jour",
                'attr'=>['class'=>'btn btn-success']
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => User::class,
        ]);
    }
}
