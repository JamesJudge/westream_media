<?php

namespace App\Form\Type;

use App\Entity\User;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\FileType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;

use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Validator\Constraints\File;

class UserType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('email', TextType::class, [
                'label' => 'Email Address',
                'required' => 'Email Address required',
                'disabled' => true
            ])
            ->add('nickname', TextType::class, [
                'label' => 'Nick Name',
                'required' => 'Nick Name required'
            ])
            ->add('firstName', TextType::class, [
                'label' => 'First Name',
                'required' => 'First Name required'
            ])
            ->add('lastName', TextType::class, [
                'label' => 'Last Name',
                'required' => 'Last Name required'
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