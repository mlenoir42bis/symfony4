<?php

namespace App\Form;

use App\Entity\Assemble;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

use Symfony\Component\Form\Extension\Core\Type\CollectionType;

use Symfony\Component\Form\Extension\Core\Type\TextareaType;

class AssembleType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('title')
            ->add('subject', TextareaType::class, [
                'attr' => ['cols' => '15', 'rows' => '15'],
            ])
            ->add('resume', TextareaType::class, [
                'attr' => ['cols' => '15', 'rows' => '15'],
            ])
            ->add('prev_analyse', TextareaType::class, [
                'attr' => ['cols' => '15', 'rows' => '15'],
            ])
            ->add('htag', CollectionType::class, [
                'entry_type' => HtagType::class,
                'allow_add' => true,
                'allow_delete' => true,
                'delete_empty' => function ($htag) {
                    return empty($htag->getName());
                },
                'by_reference' => false,
                'prototype' => true,
                'entry_options' => array('label' => false),
                
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
