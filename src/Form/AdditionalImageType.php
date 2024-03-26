<?php

namespace App\Form;

use App\Entity\AdditionalImages;
use App\Entity\animal;
use App\Entity\habitat;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Vich\UploaderBundle\Form\Type\VichFileType;

class AdditionalImageType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
        ->setMethod('POST')
        ->add('imageFile', VichFileType::class, [
            'required' => false,
            'allow_delete' => true,
            'download_uri' => true,
        ]);
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => AdditionalImages::class,
        ]);
    }
}
