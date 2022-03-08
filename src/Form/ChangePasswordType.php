<?php

namespace App\Form;

use App\Entity\User;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\PasswordType;
use Symfony\Component\Form\Extension\Core\Type\RepeatedType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class ChangePasswordType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('email',TextType::class,[
                'disabled'=>true,
                'label'=>"E-mail"
            ])
            ->add('firstname',TextType::class,[
                'disabled'=>true,
                'label'=>"Prenom"
            ])
            ->add('lastname',TextType::class,[
                'disabled'=>true,
                'label'=>"Nom"
            ])
            ->add('old_password',PasswordType::class,
            [
                'label'=>"Mot de passe",
                'mapped'=>false,
             'attr'=>[
                 'placeholder'=>"tapez actuel password"
             ]
            ]
            )
            ->add('new_password',RepeatedType::class,[
                'type'=>PasswordType::class,
                'mapped'=>false,
                'invalid_message'=>'le mot de passe et la confirmation doit etre identique',
                'required'=>true,
                'first_options'=>[
                    'label'=>"nouveau Mot de passe",
                    'attr'=>[
                        'placeholder'=>"tapez votre nouveau mot de passe"
                    ]
            
            ],
                'second_options'=>[
                    'label'=>"confirmed Mot de passe",
                    'attr'=>[
                        'placeholder'=>"confirme votre nouveau mot de passe"
                    ]
            
            ],
               
            ])
            ->add('sumit',SubmitType::class,[
                'label'=>"Edit",
                'attr'=>[
                    'class'=>"btn-success btn-block"
                ]
               
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => User::class,
        ]);
    }
}
