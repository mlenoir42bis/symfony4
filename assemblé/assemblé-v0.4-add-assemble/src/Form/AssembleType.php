<?php

namespace App\Form;

use App\Entity\Assemble;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

use Symfony\Component\Form\Extension\Core\Type\CollectionType;

class AssembleType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('title')
            ->add('subject')
            ->add('resume')
            ->add('analyse')
            ->add('htag', CollectionType::class, [
                'entry_type' => HtagType::class,
                'allow_add' => true,
                'allow_delete' => true,
                'delete_empty' => function ($htag) {
                    return empty($htag->getName());
                },
                'by_reference' => false,
            ])
            ->add('files', CollectionType::class, [
                'entry_type' => FilesType::class,
                'allow_add' => true,
                'by_reference' => false,
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Assemble::class,
        ]);
    }
}
