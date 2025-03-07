<?php

namespace App\Form\Type\User;

use App\Enum\RoleEnum;
use App\Form\Datas\User\AddUserFormData;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\Extension\Core\Type\EnumType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class AddUserType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('lastName', TextType::class, [
                'required' => false,
                'label' => 'user.lastname',
            ])
            ->add('firstName', TextType::class, [
                'required' => false,
                'label' => 'user.firstname',
            ])
            ->add('email', TextType::class, [
                'required' => false,
                'label' => 'user.email',
            ])
            ->add('licenseNumber', TextType::class, [
                'required' => false,
                'label' => 'user.license_number',
            ])
            ->add('birthday', DateType::class, [
                'required' => false,
                'label' => 'user.birthday',
            ])
            ->add('role', EnumType::class, [
                'class' => RoleEnum::class,
                'label' => 'user.role',
                'choice_label' => function ($choice): string {
                    return $choice->getTranslationKey();
                },
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => AddUserFormData::class,
        ]);
    }
}
