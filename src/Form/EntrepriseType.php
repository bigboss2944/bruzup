<?php

namespace App\Form;

use App\Entity\Entreprise;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class EntrepriseType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            //->add('id')
            //->add('idlogo')
            ->add('password')
            ->add('nom')
            ->add('rue')
            ->add('codepostal')
            ->add('ville')
            ->add('telephone')
            ->add('siteweb')
            ->add('longdescription')
            ->add('shortdescription')
            ->add('email')
            //->add('username')
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Entreprise::class,
        ]);
    }
}
