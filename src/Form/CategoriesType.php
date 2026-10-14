<?php

namespace App\Form;

use App\Entity\Categories;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;

class CategoriesType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('Nom', TextType::class, ['attr'=> ['class' => 'form-control'], 'label_attr' => ['class' => 'form-label mt-4']])
            ->add('Categorie', TextType::class, ['attr'=> ['class' => 'form-control'], 'label_attr' => ['class' => 'form-label mt-4']])
            ->add('Envoyer', SubmitType::class, ['attr' => ['class' => 'btn btn-primary m-4'], 'row_attr' => ['class' => 'text-center']])
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Categories::class,
        ]);
    }
}
