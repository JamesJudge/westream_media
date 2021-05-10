<?php

namespace App\Form\Type;

use App\Entity\User;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\FileType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;

use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Validator\Constraints\File;

use Symfony\Component\Validator\Constraints\NotBlank;

class UserType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('email', TextType::class, [
                'label' => 'Email Address',
                'constraints' => [
                    new NotBlank([
                        'message' => 'Email Address required'
                    ])
                ],
                'trim' => true,
                'required' => true,
                'disabled' => true
            ])
            ->add('nickname', TextType::class, [
                'label' => 'Nick Name',
                'empty_data' => '',
                'constraints' => [
                    new NotBlank([
                        'message' => 'Nick Name required'
                    ])
                ],
                'trim' => true,
                'required' => true
            ])
            ->add('firstName', TextType::class, [
                'label' => 'First Name',
                'empty_data' => '',
                'constraints' => [
                    new NotBlank([
                        'message' => 'First Name required'
                    ])
                ],
                'trim' => true,
                'required' => true
            ])
            ->add('lastName', TextType::class, [
                'label' => 'Last Name',
                'empty_data' => '',
                'constraints' => [
                    new NotBlank([
                        'message' => 'Last Name required'
                    ])
                ],
                'trim' => true,
                'required' => true
            ])
            ->add('profileImage', FileType::class, [
                'label' => 'Profile Image',
                'mapped' => false,
                'required' => false,
                'constraints' => [
                    new File([
                        'maxSize' => '1024k',
                        'mimeTypes' => [
                            'image/jpeg',
                            'image/png',
                            'image/gif',
                            'image/bmp',
                        ],
                        'mimeTypesMessage' => 'Please upload a valid image (jpg, png, gif, bmp)',
                    ])
                ],
            ])
            ->add('bio', TextareaType::class, [
                'label' => 'Bio',
                'required' => false
            ])
            ->add('category', TextType::class, ['label' => 'Category', 'required' => false])
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => User::class,
        ]);
    }
}