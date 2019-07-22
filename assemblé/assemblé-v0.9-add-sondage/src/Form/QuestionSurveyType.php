<?php

namespace App\Form;

use App\Entity\QuestionSurvey;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\CollectionType;

class QuestionSurveyType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('content')
            ->add('type', ChoiceType::class, [
                'placeholder' => 'Type de la question ?',
                'choices' => [
                    'Question a choix multiple' => 'QCM',
                    'Question a choix unique' => 'QCU',
                    'Texte (reponse attendu de type texte)' => 'TEXT',
                    'Nombre (reponse attendu de type nombre)' => 'NUMBER',
                    'Date (reponse attendu de type date)' => 'DATE',
                ],
                'required' => true,
                'multiple'=>false,
                'expanded'=>false,
            ])

            ->add('answerQuestionSurveys', CollectionType::class, [
                'entry_type' => AnswerQuestionSurveyType::class,
                'allow_add' => true,
                'allow_delete' => true,
                'delete_empty' => function ($question) {
                    return empty($question->getContent());
                },
                'by_reference' => false,
                'prototype' => true,
                'entry_options' => array('label' => 'Reponse :'),
                'attr' => ['class' => 'answerQuestionSurvey'],
            ])
            
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => QuestionSurvey::class,
        ]);
    }
}
