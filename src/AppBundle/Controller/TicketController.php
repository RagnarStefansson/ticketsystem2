<?php

namespace AppBundle\Controller;

use AppBundle\Entity\Customer;
use AppBundle\Entity\Tickets;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\Extension\Core\Type\PasswordType;
use Symfony\Component\Form\Extension\Core\Type\NumberType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\RepeatedType;
use Symfony\Component\Form\Extension\Core\Type\HiddenType;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Security;

class TicketController extends Controller
{
    /**
     * @Route("/ticket", name="ticketmanagement")
     */
    public function ticketListAction()
    {
        $em = $this->getDoctrine()->getManager();
        $tickets = $em->getRepository('AppBundle:Tickets')->findAll();

        return $this->render('ticket/ticketmanagement.html.twig', [
            'tickets' => $tickets,
        ]);
    }

    /**
     * @Route("/ticket/create", name="createticket")
     */
    public function createTicket(Request $request)
    {
        $em = $this->getDoctrine()->getManager();

        // Beim erstellen ein leeres Ticket-Objekt instanziieren
        $ticket = new Tickets();

        $userManager = $this->get('fos_user.user_manager');
        $team = $userManager->findUsers();

        $customernames = $em->getRepository('AppBundle:Customer')->findAll();

        foreach($customernames as $names) {
            $customers[$names->getName()] = $names->getKid();
        }


        foreach($team as $worker) {
            $choices[$worker->getNachname().', '.$worker->getVorname()] = $worker->getId();
        }

        $form = $this->createFormBuilder($ticket)
            ->add('titel', TextType::class, array(
                'required' => true,
                'label' => 'Titel'
            ))
            ->add('kid', ChoiceType::class, array(
                'label' => 'Kunde',
                'choices' => $customers
            ))
            ->add('contact', TextType::class, array(
                'required' => true,
                'label' => 'Ansprechpartner'
            ))
            ->add('uid', ChoiceType::class, array(
                'label' => 'Verantwortlicher',
                'choices' => $choices
            ))
            ->add('phone', TextType::class, array(
                'required' => true,
                'label' => 'Nummer des Ansprechpartners'
            ))
            ->add('email', EmailType::class, array(
                'required' => false,
                'label' => 'E-Mail Adresse des Ansprechpartners*'
            ))
            ->add('freeform', TextType::class, array(
                'required' => true,
                'label' => 'Beschreibung'
            ))
            ->add('times', NumberType::class, array(
                'required' => true,
                'label' => 'Zeiten'
            ))
            ->add('status', ChoiceType::class, array(
                'label' => 'Status',
                'choices'  => array(
                    'ausstehend' => 1,
                    'in Bearbeitung' => 2,
                    'warten auf Kunde' => 3,
                    'warten auf Drittanbieter' => 4,
                    'warten' => 5,
                    'abgeschlossen' => 6,
                ),
            ))
            ->add('save', SubmitType::class, array('label' => 'Ticket Erstellen'))
            ->getForm();

        $form->handleRequest($request);
        //
        if($form->isSubmitted() && $form->isValid()) {
            $ticket = $form->getData();

            // TicketObjekt in Datenbank speichern
            $em->persist($ticket);
            $em->flush();

            $this->addFlash('success', 'Ticket geändert');
            return $this->redirectToRoute('ticketmanagement');

        }

        return $this->render('ticket/editticket.html.twig', array(
            'form' => $form->createView()
        ));
    }

    /**
     * @param $tid
     * @return \Symfony\Component\HttpFoundation\Response
     * @Route("/ticket/{tid}", name="showTicket")
     */
    public function showTicketAction($tid) {
        $em = $this->getDoctrine()->getManager();
        $ticket = $em->getRepository('AppBundle:Tickets')->find($tid);

        return $this->render("ticket/ticket.html.twig", array(
            'ticket' => $ticket
        ));
    }

    /**
     * @param Request $request
     * @param $tid
     * @return \Symfony\Component\HttpFoundation\RedirectResponse|\Symfony\Component\HttpFoundation\Response
     * @Route("/ticket/edit/{tid}", name="ticketedit")
     */
    public function editticket(Request $request, $tid)
    {
        $em = $this->getDoctrine()->getManager();

        $ticket = $em->getRepository('AppBundle:Tickets')->find($tid);

        $userManager = $this->get('fos_user.user_manager');
        $team = $userManager->findUsers();

        $customernames = $em->getRepository('AppBundle:Customer')->findAll();

        foreach($customernames as $names) {
            $customers[$names->getName()] = $names->getKid();
        }


        foreach($team as $worker) {
            $choices[$worker->getNachname().', '.$worker->getVorname()] = $worker->getId();
        }

        $form = $this->createFormBuilder($ticket)
            ->add('titel', TextType::class, array(
                'required' => true,
                'label' => 'Titel'
            ))
            ->add('kid', ChoiceType::class, array(
                'label' => 'Kunde',
                'choices' => $customers
            ))
            ->add('contact', TextType::class, array(
                'required' => true,
                'label' => 'Ansprechpartner'
            ))
            ->add('uid', ChoiceType::class, array(
                'label' => 'Verantwortlicher',
                'choices' => $choices
            ))
            ->add('phone', TextType::class, array(
                'required' => true,
                'label' => 'Nummer des Ansprechpartners'
            ))
            ->add('email', EmailType::class, array(
                'required' => false,
                'label' => 'E-Mail Adresse des Ansprechpartners*'
            ))
            ->add('freeform', TextType::class, array(
                'required' => true,
                'label' => 'Beschreibung'
            ))
            ->add('times', NumberType::class, array(
                'required' => true,
                'label' => 'Zeiten'
            ))
            ->add('status', ChoiceType::class, array(
                'label' => 'Status',
                'choices'  => array(
                    'ausstehend' => 1,
                    'in Bearbeitung' => 2,
                    'warten auf Kunde' => 3,
                    'warten auf Drittanbieter' => 4,
                    'warten' => 5,
                    'abgeschlossen' => 6,
                ),
            ))
            ->add('save', SubmitType::class, array('label' => 'Ticket Erstellen'))
            ->getForm();

        $form->handleRequest($request);
        //
        if($form->isSubmitted() && $form->isValid()) {
            $ticket = $form->getData();

            // TicketObjekt in Datenbank speichern
            $em->persist($ticket);
            $em->flush();

            $this->addFlash('success', 'Ticket geändert');
            return $this->redirectToRoute('ticketmanagement');

        }

        return $this->render('ticket/editticket.html.twig', array(
            'form' => $form->createView()
        ));
    }

}
