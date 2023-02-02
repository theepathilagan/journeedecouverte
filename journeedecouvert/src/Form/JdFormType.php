<?php

namespace App\Form;

use App\Entity\JourneeDecouverte;
use App\Entity\Niveau;
use App\Entity\User;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\TimeType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\Extension\Core\Type\IntegerType;

class JdFormType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('title', TextType::class, [
                'required' => true,
            ])
            ->add('date', DateType::class, [
                'format' => 'dd-MM-yyyy',
                'required' => true,
            ])
            ->add('lieu', TextType::class, [
                'required' => true,
            ])
            ->add('nb_max_grimpeurs', IntegerType::class, [
                'required' => true,
            ])
            ->add('niveau_minimum', EntityType::class, [
                'class' => Niveau::class,
                'choice_label' => 'nom',
                'required' => true,
            ])
            ->add('enregistrer', SubmitType::class)
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => JourneeDecouverte::class,
        ]);
    }
}
