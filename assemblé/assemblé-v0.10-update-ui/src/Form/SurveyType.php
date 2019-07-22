<?php

namespace App\Form;

use App\Entity\Survey;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

use Symfony\Component\Form\Extension\Core\Type\CollectionType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;

class SurveyType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('title')
            ->add('description')
            //->add('question', QuestionSurveyType::class, [])
            ->add('questionSurveys', CollectionType::class, [
                'entry_type' => QuestionSurveyType::class,
                'allow_add' => true,
                'allow_delete' => true,
                'delete_empty' => function ($question) {
                    return empty($question->getContent());
                },
                'by_reference' => false,
                'prototype' => true,
                'entry_options' => array('label' => false),
            ])
        
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Survey::class,
        ]);
    }
}
