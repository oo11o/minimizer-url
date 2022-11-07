<?php

namespace App\Form;

use Symfony\Component\Form\Extension\Core\Type\IntegerType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;

class GenerateType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('url', TextType::class,
                [
                    'label' => 'URL',
                    'attr' => ['class' => 'form-control mb-2', 'value' => ''],
                    'help' => 'Paste the url you want to minify',
                ])
            ->add('timer', IntegerType::class,
                [
                    'label' => 'Timer in seconds',
                    'attr' => ['class' => 'form-control mb-2 ', 'value' => '120'],
                    'help' => 'Specify, in seconds, how long the minimized link will run. Max 10000 seconds. Default 2 minutes',
                ])
            ->add('save', SubmitType::class,
                [
                    'attr' => ['class' => 'btn btn-primary'],
                    'label' => 'Generate Short Url']);
    }
}