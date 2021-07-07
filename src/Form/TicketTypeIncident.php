<?php

namespace App\Form;

use App\Entity\Ticket;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Security\Core\Security;

class TicketTypeIncident extends AbstractType
{
    //L'utilisation du constructeur avec Security me permet d'accéder à l'User depuis n'importe ou.
    private $security;

    public function __construct(Security $security)
    {
        $this->security = $security;
    }

    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $user = $this->security->getUser();
        $builder
            ->add('Name')
            ->add('Description')
            ->add('Creation_date', HiddenType::class, [
                'data' => date('d-m-Y')
            ])
            ->add('Incident_date')
            ->add('type', HiddenType::class, [
                'data' => 'incident'
            ])
            ->add('gravity')
            ->add('status', HiddenType::class, [
                'data' => 'ouvert'
            ])
            ->add('incidentCategory')
            ->add('author', HiddenType::class, [
                'data' => $user
            ])
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
