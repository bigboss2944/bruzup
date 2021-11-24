<?php

namespace App\Form;

use App\Entity\Categorie;
use App\Entity\Entreprise;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Form\FormEvent;
use Symfony\Component\Form\FormEvents;
use Symfony\Component\Form\Extension\Core\Type\FileType;
use Symfony\Component\OptionsResolver\OptionsResolver;

class EntrepriseType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            //->add('id')
            //->add('idlogo')
            
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
            ->add('categorie',EntityType::class,[
                'class'=>Categorie::class,
                'placeholder'=>'Entrer la catégorie',

            ])
            ->add('images', FileType::class, [
                'label' => false,
                'multiple'=> true,
                'mapped' => false,
                'required' => false,
            ])
            ;
        $builder ->get('categorie')->addEventListener(
            FormEvents::PRE_SET_DATA,
            function (FormEvent $event){
                dump($event->getForm());
                dump($event->getData());
            }

        );
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Entreprise::class,
        ]);
    }
}
