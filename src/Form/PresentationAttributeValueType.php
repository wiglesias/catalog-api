<?php

namespace App\Form;

use App\Entity\PresentationAttribute;
use App\Entity\PresentationAttributeValue;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class PresentationAttributeValueType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('attribute', EntityType::class, [
                'class' => PresentationAttribute::class,
                'choice_label' => 'name',
                'placeholder' => 'Select attribute',
            ])
            ->add('value', TextType::class, [
                'required' => false,
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => PresentationAttributeValue::class,
        ]);
    }
}
