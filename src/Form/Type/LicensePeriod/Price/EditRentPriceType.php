<?php

namespace App\Form\Type\LicensePeriod\Price;

use App\Form\Datas\LicensePeriod\Price\EditPriceFormData;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\CollectionType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class EditRentPriceType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder->add('licensePriceFormDataCollection', CollectionType::class, [
            'entry_type' => RentPriceType::class,
            'block_name' => 'license_price',
        ]);
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => EditPriceFormData::class,
        ]);
    }
}
