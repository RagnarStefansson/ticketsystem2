<?php

namespace AppBundle\Controller;

use AppBundle\Entity\Tickets;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;

class DefaultController extends Controller
{


    /**
     * @Route("/", name="homepage")
     */
    public function indexAction()
    {
        $currentUser = $this->getUser();
        $em = $this->getDoctrine()->getManager();

        $openTickets = $em->getRepository("AppBundle:Tickets")->findBy(array("status" => 1));
        $myTickets = $em->getRepository("AppBundle:Tickets")->findBy(array("uid" => $currentUser->getId()));
        $escalatedTickets = $em->getRepository("AppBundle:Tickets")->findBy(array("status" => 6));

        // replace this example code with whatever you need
        return $this->render('default/index.html.twig', [
            'openTickets' => $openTickets,
            'myTickets' => $myTickets,
            'escalatedTickets' => $escalatedTickets
        ]);
    }

    /**
     * @param String $name
     * @return \Symfony\Component\HttpFoundation\Response
     * @Route("/hello/{name}", name="helloworld")
     */
    public function helloWorldAction($name = 'World')
    {

        /*$user = $this->getUser(1);
        var_dump($user->getUsername());

        $user->setUsername('testuser');
        $em = $this->getDoctrine()->getManager();

        // tells Doctrine you want to (eventually) save the Product (no queries yet)
        $em->persist($user);

        // actually executes the queries (i.e. the INSERT query)
        $em->flush();

        var_dump($user->getUsername());
        die;*/

        /*return $this->render('default/helloworld.html.twig', array(
            'word' => $name,

            $tickets = $em->getRepository('AppBundle:Tickets')->findBy(array(
                'uid' => $userid
            ), array(
                'tid' => 'DESC'
            ));
        ));*/
    }

    /**
     * @return \Symfony\Component\HttpFoundation\Response
     * @Route("/tickettest", name="ticket")
     */
    public function ticketAction()
    {
        return $this->render('default/ticket.html.twig');
    }


}
