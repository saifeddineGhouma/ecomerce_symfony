<?php

namespace App\Form;

use App\Entity\Address;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\CountryType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TelType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class AdressType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('name',TextType::class,[
                'label'=>'Name Adress',
                
                'attr'=>[
                    'placeholder'=>'tapez vous name  adress'
                ]
            ])
            ->add('firstname',TextType::class,[
                'label'=>'First Name',
                
                'attr'=>[
                    'placeholder'=>'tapez vous firstname'
                ]
            ])
            ->add('lastname',TextType::class,[
                'label'=>'Last Name',
                
                'attr'=>[
                    'placeholder'=>'tapez vous lastname'
                ]
            ])
            ->add('company',TextType::class,[
                'label'=>'Company',
                
                'attr'=>[
                    'placeholder'=>'tapez vous company'
                ]
            ])
            ->add('adress',TextType::class,[
                'label'=>' Adress',
                
                'attr'=>[
                    'placeholder'=>'tapez vous   adresse'
                ]
            ])
            ->add('postal',TextType::class,[
                'label'=>'Code Postal',
                
                'attr'=>[
                    'placeholder'=>'tapez vous postal  adresse'
                ]
            ])
            ->add('city',TextType::class,[
                'label'=>'City',
                
                'attr'=>[
                    'placeholder'=>'tapez vous city  adresse'
                ]
            ])
            ->add('country',CountryType::class,[
                'label'=>'Country',
                
                'attr'=>[
                    'placeholder'=>'tapez vous country  adresse'
                ]
            ])
            ->add('phone',TelType::class,[
                'label'=>'Phone',
                
                'attr'=>[
                    'placeholder'=>'tapez vous phone'
                ]
            ])
            ->add('Save',SubmitType::class,[
                'label'=>'Ajouter une adress',
                
                'attr'=>[
                    'placeholder'=>'tapez vous phone',
                    'class'=>'btn btn-info btn-block'
                ]
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Address::class,
        ]);
    }
}
