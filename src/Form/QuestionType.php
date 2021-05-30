<?php

declare(strict_types=1);

namespace App\Form;


use App\Entity\Category;
use App\Entity\Question;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class QuestionType extends \Symfony\Component\Form\AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('Category', EntityType::class, [
                'class' => Category::class,
                'label' => 'Kategoria',
            ])
            ->add('question', TextType::class, [
                'label' => 'Pytanie',
            ])
            ->add('answer', TextType::class, [
                'label' => 'Odpowiedź',
            ])
        ;
    }


    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Question::class,
        ]);
    }
}