<?php
namespace AppBundle\Repository;

use Doctrine\ORM\EntityRepository;

class TicketRepository extends EntityRepository
{

    public function getMyTickets($uid)
    {

        return $this->getEntityManager()
            ->createQuery("SELECT t FROM AppBundle:Tickets t WHERE t.uid=" . $uid)
            ->getResult();
    }

    public function getEscalatedTickets()
    {

        return $this->getEntityManager()
            ->createQuery("SELECT t FROM AppBundle:Tickets t WHERE t.status=" . '6')
            ->getResult();
    }

    public function getClosedTickets()
    {

        return $this->getEntityManager()
            ->createQuery("SELECT t FROM AppBundle:Tickets t WHERE t.status=" . '7')
            ->getResult();
    }

}