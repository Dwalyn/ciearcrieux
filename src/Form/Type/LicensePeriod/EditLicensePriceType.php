<?php

namespace App\Form\Type\LicensePeriod;

use App\Form\Datas\LicensePeriod\EditPriceFormData;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\CollectionType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class EditLicensePriceType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder->add('licensePriceFormDataCollection', CollectionType::class, [
            'entry_type' => LicensePriceType::class,
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
