<?php

namespace App\Form;

use App\Entity\PProduit;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class PProduitType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('designation')
            ->add('prixAchat')
            ->add('prixVente')
            ->add('conditionnement')
            ->add('codeZone')
            ->add('qteReste')
            ->add('nLot')
            // ->add('dateExp')
            ->add('codeBarre')
            ->add('tva')
            // ->add('dateCreation')
            ->add('qte')
            // ->add('livraisoncab')
            // ->add('article')
            // ->add('userCreation')
            // ->add('dossier')
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => PProduit::class,
        ]);
    }
}
