<?php

namespace App\Form\Type\Actuality;

use App\Form\Datas\Actuality\PostFormData;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\HiddenType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class PostFormType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder->add('content', HiddenType::class, [ // Ou TextareaType si vous voulez un fallback sans JS
            'attr' => [
                'id' => 'your_entity_content_quill', // ID unique pour ce champ
            ],
            'label' => false, // Cache le label par défaut si vous le gérez manuellement dans Twig
            'required' => false, // Adaptez selon vos besoins
        ]);
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => PostFormData::class,
        ]);
    }
}
