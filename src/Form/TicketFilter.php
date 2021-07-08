<?php

namespace App\Form\Type;

use App\Entity\Ticket;
use App\Entity\TicketGravity;
use App\Entity\TicketStatus;
use App\Entity\TicketType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class TicketFilter extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('search', TextType::class)
            ->add('gravity', TicketGravity::class)
            ->add('beginDate', DateType::class)
            ->add('endDate', DateType::class)
            ->add('status', TicketStatus::class)
            ->add('type', TicketType::class)
            ->add('filter', SubmitType::class)
        ;
    }
    
    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Ticket::class,
        ]);
    }
}