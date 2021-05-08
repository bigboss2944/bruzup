<?php

namespace App\Form;

use App\Entity\User;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\PasswordType;
use Symfony\Component\Form\Extension\Core\Type\RepeatedType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Validator\Constraints\Length;

class UserType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('username')
            ->add('password', RepeatedType::class, array(
                'type' => PasswordType::class,
                'required' => false,
                'invalid_message' => 'Les mots de passe ne correspondent pas.',
                'constraints' => array(
                    new Length(array('min' => 6)),
                ),
                'first_options'  => array('label' => 'Mot de passe '),
                'second_options' => array('label' => 'Confirmation '),
            ))
            ->add('nom')
            ->add('prenom')
            ->add('telephone')
            ->add('email')
//            ->add('isVerified')
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => User::class,
        ]);
    }
}
