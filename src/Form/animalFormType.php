<?php

namespace App\Form;

use App\Entity\Animal;
use App\Entity\Habitat;
use Doctrine\ORM\Mapping\Entity;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Form\AbstractType;
use Vich\UploaderBundle\Form\Type\VichFileType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Validator\Constraints\NotBlank;
use Symfony\Component\Validator\Constraints\Length;
use Symfony\Component\Validator\Validator\ValidatorInterface;



class animalFormType extends AbstractType{
    public function buildForm(FormBuilderInterface $builder, array $options){
        $builder
            ->setMethod('POST')
            
            ->add('prenom', TextType::class, [
                'constraints' => [
                    new NotBlank([
                        'message' => 'Please enter a name',
                    ]),
                    new Length([
                        'min' => 2,
                        'minMessage' => 'Your name should be at least {{ limit }} characters',
                        'max' => 255,
                    ]),
                ],
            ])
            
            ->add('race', TextType::class, [
                'constraints' => [
                    new NotBlank(['message' => 'Merci de préciser une race']),
                    new Length([
                        'min' => 2,
                        'minMessage' => 'Race invalide',
                        'max' => 255,
                    ]),
                ],
            ])

            ->add('habitat', EntityType::class, [
                'class' => Habitat::class,
                'choice_label' => 'nom',
                'placeholder' => 'Choisir un habitat',
                'constraints' => [
                    new NotBlank(['message' => 'Merci de préciser un habitat']),
                ],
            ])

            ->add('imageFile', VichFileType::class, [
                'required' => false,
                'allow_delete' => true,
                'download_uri' => true,
            ]);
    }

        public function configureOptions(OptionsResolver $resolver){
            $resolver->setDefaults([
                'data_class' => Animal::class,
            ]);
        }
    }


