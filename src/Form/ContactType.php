<?php

namespace App\Form;

use App\Model\Contact;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Validator\Constraints as Assert;

class ContactType extends AbstractType
{
    public function buildForm(
        FormBuilderInterface $builder,
        array $options
    ): void {
        $builder

            ->add('nom', TextType::class, [
                'label' => 'false',
                'constraints' => [
                    new Assert\NotBlank(
                        message: 'Le nom est obligatoire.'
                    ),
                    new Assert\Length(
                        min: 2,
                        max: 100
                    ),
                ],
            ])

            ->add('prenom', TextType::class, [
                'label' => 'false',
                'constraints' => [
                    new Assert\NotBlank(
                        message: 'Le prénom est obligatoire.'
                    ),
                    new Assert\Length(
                        min: 2,
                        max: 100
                    ),
                ],
            ])

            ->add('email', EmailType::class, [
                'label' => 'false',
                'constraints' => [
                    new Assert\NotBlank(),
                    new Assert\Email(
                        message: 'Email invalide.'
                    ),
                ],
            ])

            ->add('message', TextareaType::class, [
                'label' => 'false',
                'constraints' => [
                    new Assert\NotBlank(),
                    new Assert\Length(
                        min: 10,
                        max: 2000
                    ),
                ],
            ]);
    }

    public function configureOptions(
        OptionsResolver $resolver
    ): void {
        $resolver->setDefaults([
            'data_class' => Contact::class,
        ]);
    }
}