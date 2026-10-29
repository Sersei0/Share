<?php

namespace App\Form;

use App\Entity\Contact;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;

class SupprContactType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('contacts',EntityType::class,[
                'class'=>Contact::class, /*la class ici est l'entité importée, si erreur "Class "App\Form\Contacts" does not exist" vérifier que l'entité est renseignée avec la bonne orthographe*/
                'choices'=>$options['contacts'],
                'choice_label'=>'Nom',
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
            'contacts' => [],
        ]);
    }
}
