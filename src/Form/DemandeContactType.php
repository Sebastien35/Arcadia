<?php

namespace App\Form;

use App\Entity\DemandeContact;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use App\Entity\Zoo;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Validator\Constraints\Regex;
use Symfony\Component\Validator\Constraints\Email;

class DemandeContactType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('titre')
            ->add('message')
            ->add('mail', null, [
                'constraints' => [
                   new Email([
                        'message' => 'Veuillez saisir une adresse email valide'
                   ])
                ],
            ])
            ->add('zoo', EntityType::class, [
                'class' => Zoo::class,
                'choice_label' => 'nom',
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => DemandeContact::class,
        ]);
    }
}
