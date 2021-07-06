<?php

namespace App\Form;

use App\Entity\Ticket;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class TicketType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('Name')
            ->add('Description')
            ->add('Creation_date')
            ->add('Incident_date')
            ->add('type')
            ->add('gravity')
            ->add('status')
            ->add('incidentCategory')
            ->add('demandCategory')
            ->add('author')
            ->add('support_technician_assign')
            ->add('support_assign')
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Ticket::class,
        ]);
    }
}
