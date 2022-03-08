<?php

namespace App\Form;

use App\Entity\User;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\Extension\Core\Type\PasswordType;
use Symfony\Component\Form\Extension\Core\Type\RepeatedType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Validator\Constraints\Length;

class RegisterType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('firstname',TextType::class,[
                'label'=>"Prenom",
                'constraints'=> new Length(30,3),
                'attr'=>[
                    'placeholder'=>"Tapez votre prenom"
                ]
            ])
            ->add('lastname',TextType::class,[
                'label'=>"Nom",
                'constraints'=> new Length(30,3),
                'attr'=>[
                    'placeholder'=>"Tapez votre nom"
                ]
            ])
            ->add('email',EmailType::class,[
                'label'=>"Email",
                'constraints'=> new Length(30,3),
                'attr'=>[
                    'placeholder'=>"exemple@mail.com"
                ]
            ])
            ->add('password',RepeatedType::class,[
                'type'=>PasswordType::class,
                'invalid_message'=>'le mot de passe et la confirmation doit etre identique',
                'required'=>true,
                'first_options'=>[
                    'label'=>"Mot de passe",
                    'attr'=>[
                        'placeholder'=>"tapez votre mot de passe"
                    ]
            
            ],
                'second_options'=>[
                    'label'=>"confirmed Mot de passe",
                    'attr'=>[
                        'placeholder'=>"confirme votre mot de passe"
                    ]
            
            ],
               
            ])
            ->add('sumit',SubmitType::class,[
                'label'=>"s'inscrit",
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
