<?php

namespace App\Form;

use App\Entity\Avis;
use App\Entity\Zoo;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class AvisType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('pseudo')
            ->add('Avis_content')
            ->add('note')
            ->add('validation')
            ->add('createdAt', null, [
                'widget' => 'single_text'
            ])
            ->add('zoo', EntityType::class, [
                'class' => Zoo::class,
'choice_label' => 'id',
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Avis::class,
        ]);
    }
}
