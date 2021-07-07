<?php

namespace App\Form;

use App\Entity\Ticket;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class TicketTypeDemand extends AbstractType
{

    public function buildForm(FormBuilderInterface $builder, array $options)
    {

        $builder
            ->add('Name')
            ->add('Description')
            //Affiche toute les catégories en vrac, il faudra utiliser les Forms Events https://symfony.com/doc/current/form/dynamic_form_modification.html#form-events-submitted-data
            ->add('demandCategory')
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
