<?php

namespace App\Form\Type\Actuality;

use App\Enum\PostTypeEnum;
use App\Form\Datas\Actuality\PostFormData;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\Extension\Core\Type\EnumType;
use Symfony\Component\Form\Extension\Core\Type\HiddenType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Translation\TranslatableMessage;

class PostFormType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder->add('content', HiddenType::class, [
            'attr' => [
                'id' => 'post_content',
            ],
            'label' => false,
            'required' => false,
        ])
            ->add('postTypeEnum', EnumType::class, [
                'class' => PostTypeEnum::class,
                'label' => false,
                'choice_label' => function ($choice): string {
                    return $choice->getTranslationKey();
                },
                'placeholder' => new TranslatableMessage('post.placeholder.postTypeEum'),
                'required' => false,
            ])
            ->add('postDate', DateType::class, [
                'label' => false,
                'required' => false,
            ])
            ->add('postTitle', TextType::class, [
                'label' => false,
                'attr' => [
                    'placeholder' => new TranslatableMessage('post.placeholder.postTitle'),
                ],
                'required' => false,
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => PostFormData::class,
        ]);
    }
}
