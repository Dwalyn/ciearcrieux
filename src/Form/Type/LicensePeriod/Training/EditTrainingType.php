<?php

namespace App\Form\Type\LicensePeriod\Training;

use App\Entity\TrainingPlace;
use App\Form\Datas\LicensePeriod\Training\EditTrainingFormData;
use App\Repository\TrainingPlaceRepository;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\CollectionType;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\Extension\Core\Type\HiddenType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class EditTrainingType extends AbstractType
{
    public function __construct(
        private readonly TrainingPlaceRepository $trainingPlaceRepository,
    ) {
    }

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
                'label' => 'trainingPlace.startDate',
            ])
            ->add('endDate', DateType::class, [
                'required' => false,
                'attr' => $attr,
                'label' => 'trainingPlace.endDate',
            ])
            ->add('trainingPlace', ChoiceType::class, [
                'choices' => $this->trainingPlaceRepository->findAll(),
                'choice_value' => 'id',
                'choice_label' => function (?TrainingPlace $trainingPlace): string {
                    return $trainingPlace ? strtoupper($trainingPlace->getName()) : '';
                },
                'label' => 'trainingPlace.place',
            ])
            ->add('limitMinDate', HiddenType::class)
            ->add('limitMaxDate', HiddenType::class)
            ->add('listTrainingDayFormData', CollectionType::class, [
                'entry_type' => TrainingDayFormType::class,
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => EditTrainingFormData::class,
        ]);
    }
}
