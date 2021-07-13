<?php

namespace App\Controller;

use App\Entity\Ticket;
use App\Entity\TicketMessage;
use App\Entity\TicketStatus;
use App\Entity\TicketType;
use App\Entity\User;
use App\Form\TicketTypeDemand;
use App\Form\TicketTypeIncident;
use App\Form\TicketFilter;
use App\Repository\TicketRepository;
use App\Repository\TicketStatusRepository;
use App\Repository\TicketTypeRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Core\Security;
use Symfony\Component\Security\Core\User\UserInterface;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\ParamConverter;


/**
 * @Route("/ticket/crud")
 */
class TicketCrudController extends AbstractController
{
    //L'utilisation du constructeur avec Security me permet d'accéder à l'User depuis n'importe ou.
    private $security;

    public function __construct(Security $security, TicketTypeRepository $ticketTypeRepository, TicketStatusRepository $ticketStatusRepository)
    {
        $this->security = $security;
        $this->allStatus = $ticketStatusRepository->findAll();
        $this->allTypes = $ticketTypeRepository->findAll();
    }

    /**
     * @Route("/", name="ticket_crud_index", methods={"GET"})
     */
    public function index(TicketRepository $ticketRepository): Response
    {
        return $this->render('ticket_crud/index.html.twig', [
            'tickets' => $ticketRepository->findAll(),
            'filtre' => false,
            'title' => "Tout les tickets"
            ]
        );
    }

    /**
     * @Route("/myTickets", name="ticket_crud_my_tickets", methods={"GET"})
     */
    public function myTickets(TicketRepository $ticketRepository): Response
    {
        $user = $this->security->getUser();
        $filteredTicket = $ticketRepository->filteredTickets($_GET, $user);

        return $this->render('ticket_crud/index.html.twig', [
            'tickets' => $filteredTicket,
            'status'=> $this->allStatus,
            'types' => $this->allTypes,
            'filtre' => true,
            'title' => 'Mes tickets'
        ]);
    }

    /**
     * @Route("/allIncidents", name="ticket_crud_all_incidents", methods={"GET"})
     */
    public function allIncidents(TicketTypeRepository $ticketTypeRepository, TicketRepository $ticketRepository): Response
    {
        //Cette requète permet d'aller chercher l'objet "type" dans la BDD
        $type = $ticketTypeRepository->findOneBy(['name' => 'incident' ]);
        
        return $this->render('ticket_crud/index.html.twig', [
            
            'tickets' => $ticketRepository->findBy(
                ['type' => $type ]
            ),
            'status'=> $this->allStatus,
            'types' => $this->allTypes,
            'filtre' => false,
            'title' => 'Tout les incidents'
        ]);
    }

    /**
     * @Route("/newDemand", name="ticket_crud_new_demand", methods={"GET","POST"})
     */
    public function newDemand(Request $request, TicketTypeRepository $ticketTypeRepository, TicketStatusRepository $ticketStatusRepository): Response
    {
        $ticket = new Ticket();
        $form = $this->createForm(TicketTypeDemand::class, $ticket);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {

            //Les string demand et open devront être des variables plus tard, variables crées par l'admin
            $type = $ticketTypeRepository->findOneBy(['name' => 'demand']);
            $status = $ticketStatusRepository->findOneBy(['name' => 'open']);
            $user = $this->security->getUser();

            $ticket->setAuthor($user);
            $ticket->setCreationDate(new \DateTime());
            $ticket->setType($type);
            $ticket->setStatus($status);
            
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($ticket);
            $entityManager->flush();

            return $this->redirectToRoute('ticket_crud_my_tickets', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('ticket_crud/new.html.twig', [
            'ticket' => $ticket,
            'form' => $form,
        ]);
    }

    /**
     * @Route("/newIncident", name="ticket_crud_new_incident", methods={"GET","POST"})
     */
    public function newIncident(Request $request, TicketTypeRepository $ticketTypeRepository, TicketStatusRepository $ticketStatusRepository): Response
    {
        $ticket = new Ticket();
        $form = $this->createForm(TicketTypeIncident::class, $ticket);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $type = $ticketTypeRepository->findOneBy(['name' => 'incident']);
            $status = $ticketStatusRepository->findOneBy(['name' => 'open']);
            $user = $this->security->getUser();
            $ticket->setAuthor($user);
            $ticket->setCreationDate(new \DateTime());
            $ticket->setType($type);
            $ticket->setStatus($status);
            
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($type);
            $entityManager->persist($status);
            $entityManager->persist($ticket);
            $entityManager->flush();

            return $this->redirectToRoute('ticket_crud_my_tickets', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('ticket_crud/new.html.twig', [
            'ticket' => $ticket,
            'form' => $form,
        ]);
    }

    /**
     * @Route("/{id}", name="ticket_crud_show", methods={"GET"})
     */
    public function show(Ticket $ticket): Response
    {
        return $this->render('ticket_crud/show.html.twig', [
            'ticket' => $ticket,
        ]);
    }

    /**
     * @Route("/{id}/assign", name="ticket_crud_assign", methods={"GET"}, requirements={"page"="\d+"})
     */
    public function assign(Ticket $ticket, TicketRepository $ticketRepository, $id): Response
    {
        $user = $this->security->getUser();
        $entityManager = $this->getDoctrine()->getManager();
        $ticket = $ticketRepository->find($id);
        $ticket->setSupportTechnicianAssign($user);
        $entityManager->persist($ticket);
        $entityManager->flush();
        
        return $this->redirectToRoute('ticket_crud_work', [
            'id' => $id
        ]);
    }

    /**
     * @Route("/{id}/work", name="ticket_crud_work", methods={"GET","POST"}, requirements={"page"="\d+"})
     */
    public function work(Request $request, Ticket $ticket, TicketRepository $ticketRepository,int $id, TicketStatus $ticketStatus, TicketStatusRepository $ticketStatusRepository): Response
    {
        $user = $this->security->getUser();
        $ticket = $ticketRepository->find($id);
        $comment = $request->request->get('comment');
        $commentSent = $request->request->get('commentSent');
        $wait = $request->request->get('wait');
        $close = $request->request->get('close');

        //Vérification qu'un commentaire ai bien été écris
        if ($comment) {
            $entityManager = $this->getDoctrine()->getManager();
            $ticketMessage = new TicketMessage;
            $timeStamp = new \DateTime;
            $ticketMessage->setValue($comment);
            $ticketMessage->setTicket($ticket);
            $ticketMessage->setTimeStamp($timeStamp);
            $ticketMessage->setUser($user);

            //Si le commentaire à bien été écris alors on vérifie quel bouton à été utilisé $commentSent / $wait / $close
            if ($commentSent) {
                $ticket->addMessage($ticketMessage);

                $entityManager->persist($ticket);
                $entityManager->persist($ticketMessage);
                $entityManager->flush();
            }

            if ($wait) {
                $ticketStatus = $ticketStatusRepository->findOneBy(['name' => 'waiting']);
                $ticket->addMessage($ticketMessage);
                $ticket->setStatus($ticketStatus);
                $entityManager->persist($ticket);
                $entityManager->persist($ticketMessage);
                $entityManager->flush();
            }

            if ($close) {
                $ticketStatus = $ticketStatusRepository->findOneBy(['name' => 'closed']);
                $ticket->addMessage($ticketMessage);
                $ticket->setStatus($ticketStatus);
                $entityManager->persist($ticket);
                $entityManager->persist($ticketMessage);
                $entityManager->flush();
            }
        }
        return $this->render('ticket_crud/work.html.twig',[
            'ticket' => $ticket
        ]);
    }

    /**
     * @Route("/{id}/edit", name="ticket_crud_edit", methods={"GET","POST"})
     */
    public function edit(Request $request, Ticket $ticket): Response
    {
        $form = $this->createForm(TicketTypeIncident::class, $ticket);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('ticket_crud_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('ticket_crud/edit.html.twig', [
            'ticket' => $ticket,
            'form' => $form,
        ]);
    }

    /**
     * @Route("/{id}", name="ticket_crud_delete", methods={"POST"})
     */
    public function delete(Request $request, Ticket $ticket): Response
    {
        if ($this->isCsrfTokenValid('delete'.$ticket->getId(), $request->request->get('_token'))) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->remove($ticket);
            $entityManager->flush();
        }

        return $this->redirectToRoute('ticket_crud_index', [], Response::HTTP_SEE_OTHER);
    }
}
