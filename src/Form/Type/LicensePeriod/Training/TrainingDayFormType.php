<?php

namespace App\Form\Type\LicensePeriod\Training;

use App\Enum\DayEnum;
use App\Enum\LicensedTypeEnum;
use App\Form\Datas\LicensePeriod\Training\TrainingDayFormData;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\EnumType;
use Symfony\Component\Form\Extension\Core\Type\TimeType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class TrainingDayFormType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('startTime', TimeType::class, [
                'label' => false,
            ])
            ->add('endTime', TimeType::class, [
                'label' => false,
            ])
            ->add('dayEnum', EnumType::class, [
                'class' => DayEnum::class,
                'label' => false,
                'choice_label' => function ($choice): string {
                    return $choice->getTranslationKey();
                },
            ])
            ->add('licensedTypeEnum', EnumType::class, [
                'class' => LicensedTypeEnum::class,
                'label' => false,
                'choice_label' => function ($choice): string {
                    return $choice->getTranslationKey();
                },
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => TrainingDayFormData::class,
        ]);
    }
}
