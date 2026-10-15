<?php

namespace App\Form;

use App\Entity\Categories;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;

class SupprCategorieType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('categories',EntityType::class,[
                'class'=> Categories::class,
                'choices'=>$options['categories'],
                'choice_label'=>'Categorie',
                'expanded'=>True,
                'multiple'=>True,
                'label'=>False,
                'mapped'=>False,
            ])
            ->add('Supprimer', SubmitType::class, ['attr' => ['class' => 'btn btn-danger m-4'], 'row_attr' => ['class' => 'text-center']])
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'categories' => [],
        ]);
    }
}
