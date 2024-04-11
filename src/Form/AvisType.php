<?php

namespace App\Form;

use App\Entity\Avis;
use App\Entity\Zoo;
use Doctrine\ODM\MongoDB\Aggregation\Stage\Search\Text;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\RangeType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;

class AvisType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('pseudo')
            ->add('Avis_content', TextAreaType::class, [
                'attr' => [
                    'placeholder' => 'Votre avis',
                    'class' => 'form-control',
                    'rows' => '5',
                    'cols' => '33',
                    'maxlength' => '255'
                ],
            ])
            ->add('note', RangeType::class, [
                'attr' => [
                    'min' => 1,
                    'max' => 5,
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
            'data_class' => Avis::class,
        ]);
    }
}
