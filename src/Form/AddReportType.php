<?php

namespace App\Form;

use App\Entity\Reports;
use DateTime;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\Extension\Core\Type\NumberType;
use Symfony\Component\Form\Extension\Core\Type\TimeType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class AddReportType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('date', DateType::class, [
                'label' => "Date :",
                'data' => new DateTime(),
                'format' => 'dd MMMM yyyy',
                'required' => true,
                'attr' => ['class' => 'form-control']
            ])
            ->add('hours', TimeType::class, [
                'label' => "Hours :",
                'required' => true,
                'attr' => ['class' => 'form-control']
            ])
            ->add('publications', NumberType::class, [
                'label' => "Publications :",
                'required' => false,
                'attr' => ['class' => 'form-control']
            ])
            ->add('videos', NumberType::class, [
                'label' => "Videos :",
                'required' => false,
                'attr' => ['class' => 'form-control']
            ])
            ->add('nv_visites', NumberType::class, [
                'label' => "Return Visits :",
                'required' => false,
                'attr' => ['class' => 'form-control']
            ])
            ->add('studies', NumberType::class, [
                'label' => "Studies :",
                'required' => false,
                'attr' => ['class' => 'form-control']
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Reports::class,
        ]);
    }
}
