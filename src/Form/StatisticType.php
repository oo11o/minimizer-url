<?php

namespace App\Form;

use Symfony\Component\Form\Extension\Core\Type\IntegerType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;

class StatisticType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('url', TextType::class,
                [
                    'label' => 'URL',
                    'attr' => ['class' => 'form-control mb-2', 'value' => ''],
                    'help' => 'Paste the url you want see statistics. You need past full url link'
                ])
            ->add('save', SubmitType::class,
                [
                    'attr' => ['class' => 'btn btn-primary'],
                    'label' => 'Show Statistic']);
    }
}