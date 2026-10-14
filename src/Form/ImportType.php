<?php

namespace App\Form;

use App\Entity\Import;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\FileType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;

class ImportType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('Nom', TextType::class, ['attr' => ['class' => 'form-control'], 'label_attr' => ['class' => 'form-label mt-4']])
            ->add('CategorieFile', ChoiceType::class, ['choices' => ['--Veuillez sélectionner une catégorie--' => FALSE,'Factures' => 'Factures','Devis' => 'Devis','Divers' => 'Divers'], 'attr' => ['class' => 'form-control'], 'label_attr' => ['class' => 'form-label mt-4']] )
            ->add('Fichier', FileType::class, ['attr' => ['class' => 'form-control' ], 'label_attr' => ['class' => 'form-label mt-4']] )
            ->add('Deposer', SubmitType::class, ['attr' => ['class' => 'btn btn-primary m-4'], 'row_attr' => ['class' => 'text-center']])
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Import::class,
        ]);
    }
}
