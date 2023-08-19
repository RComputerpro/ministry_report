<?php

namespace App\Form;

use App\Entity\User;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\CheckboxType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\Extension\Core\Type\PasswordType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Validator\Constraints\IsTrue;
use Symfony\Component\Validator\Constraints\Length;
use Symfony\Component\Validator\Constraints\NotBlank;

class RegistrationFormType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('email', EmailType::class,[
                'attr' => ['class' => 'form-control'],
                'label' => 'Email :'
            ])
            ->add('plainPassword', PasswordType::class, [
                
                // instead of being set onto the object directly,
                // this is read and encoded in the controller
                'label' => 'Password :',
                'mapped' => false,
                'attr' => ['autocomplete' => 'new-password', 'class' => 'form-control'],
                'constraints' => [
                    new NotBlank([
                        'message' => 'Please enter a password',
                    ]),
                    new Length([
                        'min' => 6,
                        'minMessage' => 'Your password should be at least {{ limit }} characters',
                        // max length allowed by Symfony for security reasons
                        'max' => 4096,
                    ]),
                ],

            ])

            ->add('name', TextType::class, [
                'attr' => ['class' => 'form-control'],
                'label' => 'Name :',
                'required' => true
            ])

            ->add('firstname', TextType::class, [
                'attr' => ['class' => 'form-control'],
                'label' => 'Firstname :',
                'required' => true
            ])

            ->add('statut', ChoiceType::class, [
                'attr' => ['class' => 'form-select'],
                'label' => 'Status :',
                'required' => true,
                'choices' => [
                    'Publisher' => 'proclamateur',
                    'Auxiliary Pioneer' => 'pionnier_auxiliaire',
                    'Permanent Pioneer' => 'pionnier_permanent'
                ]
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => User::class,
        ]);
    }
}
