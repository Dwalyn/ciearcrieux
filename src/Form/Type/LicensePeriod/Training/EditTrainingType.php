<?php

namespace App\Form\Type\LicensePeriod\Training;

use App\Form\Datas\LicensePeriod\Training\EditTrainingFormData;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\Extension\Core\Type\HiddenType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class EditTrainingType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $attr = [
            'min' => $options['data']->limitMinDate,
            'max' => $options['data']->limitMaxDate,
        ];
        $builder
            ->add('startDate', DateType::class, [
                'required' => false,
                'attr' => $attr,
            ])
            ->add('endDate', DateType::class, [
                'required' => false,
                'attr' => $attr,
            ])
            ->add('limitMinDate', HiddenType::class)
            ->add('limitMaxDate', HiddenType::class)
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => EditTrainingFormData::class,
        ]);
    }
}
